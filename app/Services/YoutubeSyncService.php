<?php

namespace App\Services;

use App\Models\Series;
use App\Models\Sermon;
use App\Models\Speaker;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Synchronizuje kázání ze záložky „Živé přenosy" YouTube kanálu.
 *
 * Primárně přes YouTube Data API v3 (playlist UULV… odpovídá záložce Streams).
 * Bez API klíče použije veřejnou stránku kanálu jako záložní zdroj.
 * Existujícím kázáním pouze doplňuje chybějící údaje — ručně upravené
 * texty v administraci nikdy nepřepisuje.
 */
class YoutubeSyncService
{
    /** Kratší záznamy jsou přerušené nebo testovací streamy. */
    private const MIN_STREAM_SECONDS = 900;

    /**
     * @return array{source: string, created: int, updated: int, skipped: int, total: int}
     */
    public function sync(?string $channelId = null, bool $full = false, ?callable $log = null): array
    {
        $log ??= fn (string $message): null => null;
        $channelId = $channelId ?: config('services.youtube.channel_id');
        $apiKey = config('services.youtube.api_key');

        if ($apiKey) {
            $source = 'api';
            $videos = $this->fetchViaApi($apiKey, $channelId, $full);
        } else {
            $source = 'scrape';
            $log('YOUTUBE_API_KEY není nastaven — používám záložní čtení veřejné stránky kanálu.');
            $videos = $this->fetchViaScrape($channelId);
        }

        $result = $this->upsert($videos, $log);

        return ['source' => $source, ...$result, 'total' => $videos->count()];
    }

    /**
     * @return Collection<int, array{youtube_id: string, title: string, description: ?string, thumbnail_url: ?string, duration_seconds: int, broadcast_at: ?Carbon, finished: bool}>
     */
    private function fetchViaApi(string $apiKey, string $channelId, bool $full): Collection
    {
        $playlistId = 'UULV'.substr($channelId, 2);
        $videoIds = collect();
        $pageToken = null;

        do {
            $response = Http::get('https://www.googleapis.com/youtube/v3/playlistItems', array_filter([
                'key' => $apiKey,
                'playlistId' => $playlistId,
                'part' => 'contentDetails',
                'maxResults' => 50,
                'pageToken' => $pageToken,
            ]));

            if ($response->status() === 404) {
                return collect();
            }

            if ($response->failed()) {
                throw new RuntimeException('YouTube API (playlistItems) selhalo: '.$response->body());
            }

            $videoIds = $videoIds->merge(
                collect($response->json('items', []))->pluck('contentDetails.videoId')->filter()
            );

            $pageToken = $full ? $response->json('nextPageToken') : null;
        } while ($pageToken);

        return $videoIds->unique()->chunk(50)->flatMap(function (Collection $chunk) use ($apiKey): Collection {
            $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'key' => $apiKey,
                'id' => $chunk->implode(','),
                'part' => 'snippet,contentDetails,liveStreamingDetails',
            ]);

            if ($response->failed()) {
                throw new RuntimeException('YouTube API (videos) selhalo: '.$response->body());
            }

            return collect($response->json('items', []))->map(function (array $item): array {
                $snippet = $item['snippet'] ?? [];
                $thumbnails = $snippet['thumbnails'] ?? [];
                $startedAt = $item['liveStreamingDetails']['actualStartTime'] ?? $snippet['publishedAt'] ?? null;

                return [
                    'youtube_id' => $item['id'],
                    'title' => $snippet['title'] ?? '',
                    'description' => $snippet['description'] ?? null,
                    'thumbnail_url' => $thumbnails['maxres']['url']
                        ?? $thumbnails['high']['url']
                        ?? $thumbnails['default']['url']
                        ?? null,
                    'duration_seconds' => (int) (CarbonInterval::make($item['contentDetails']['duration'] ?? 'PT0S')?->totalSeconds ?? 0),
                    'broadcast_at' => $startedAt ? Carbon::parse($startedAt) : null,
                    'finished' => ($snippet['liveBroadcastContent'] ?? 'none') === 'none',
                ];
            });
        });
    }

    /**
     * Záložní zdroj bez API klíče: veřejná stránka záložky Streams + interní
     * player endpoint pro detaily. Vrací jen videa, která v databázi chybí
     * nebo mají neúplné údaje (stránka zobrazuje ~30 posledních streamů).
     *
     * @return Collection<int, array{youtube_id: string, title: string, description: ?string, thumbnail_url: ?string, duration_seconds: int, broadcast_at: ?Carbon, finished: bool}>
     */
    private function fetchViaScrape(string $channelId): Collection
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36',
            'Accept-Language' => 'cs',
            'Cookie' => 'CONSENT=YES+cb; SOCS=CAI',
        ])->get("https://www.youtube.com/channel/{$channelId}/streams");

        if ($response->failed()) {
            throw new RuntimeException('Stažení stránky kanálu selhalo: HTTP '.$response->status());
        }

        $data = $this->extractJsonObject($response->body(), 'ytInitialData');
        if ($data === null) {
            throw new RuntimeException('Na stránce kanálu se nepodařilo najít data o videích.');
        }

        $videoIds = [];
        $this->walk($data, function (array $node) use (&$videoIds): void {
            $contentId = $node['lockupViewModel']['contentId'] ?? null;
            if (is_string($contentId)) {
                $videoIds[$contentId] = true;
            }
        });

        $videoIds = array_keys($videoIds);

        $complete = Sermon::query()
            ->whereIn('youtube_id', $videoIds)
            ->whereNotNull('thumbnail_url')
            ->whereNotNull('duration_seconds')
            ->whereNotNull('published_at')
            ->pluck('youtube_id')
            ->all();

        return collect($videoIds)
            ->reject(fn (string $id): bool => in_array($id, $complete, true))
            ->map(fn (string $id): ?array => $this->fetchVideoDetail($id))
            ->filter()
            ->values();
    }

    /**
     * @return ?array{youtube_id: string, title: string, description: ?string, thumbnail_url: ?string, duration_seconds: int, broadcast_at: ?Carbon, finished: bool}
     */
    private function fetchVideoDetail(string $videoId): ?array
    {
        $response = Http::post('https://www.youtube.com/youtubei/v1/player', [
            'context' => ['client' => ['clientName' => 'WEB', 'clientVersion' => '2.20240501.00.00', 'hl' => 'cs']],
            'videoId' => $videoId,
        ]);

        $details = $response->json('videoDetails');
        if (! is_array($details) || empty($details['title'])) {
            return null;
        }

        $microformat = $response->json('microformat.playerMicroformatRenderer', []);
        $startedAt = $microformat['liveBroadcastDetails']['startTimestamp']
            ?? $microformat['publishDate']
            ?? null;
        $thumbnails = $details['thumbnail']['thumbnails'] ?? [];
        $thumbnail = $thumbnails !== [] ? end($thumbnails)['url'] : null;

        return [
            'youtube_id' => $videoId,
            'title' => $details['title'],
            'description' => $details['shortDescription'] ?? null,
            'thumbnail_url' => is_string($thumbnail) ? strtok($thumbnail, '?') : null,
            'duration_seconds' => (int) ($details['lengthSeconds'] ?? 0),
            'broadcast_at' => $startedAt ? Carbon::parse($startedAt) : null,
            'finished' => ! ($details['isLive'] ?? false) && ! ($details['isUpcoming'] ?? false),
        ];
    }

    /**
     * @param  Collection<int, array{youtube_id: string, title: string, description: ?string, thumbnail_url: ?string, duration_seconds: int, broadcast_at: ?Carbon, finished: bool}>  $videos
     * @return array{created: int, updated: int, skipped: int}
     */
    private function upsert(Collection $videos, callable $log): array
    {
        $knownSeries = Series::query()->pluck('title')->all();
        $knownSpeakers = Speaker::query()->pluck('name')->all();

        $created = $updated = $skipped = 0;

        foreach ($videos->sortBy(fn (array $v) => $v['broadcast_at']?->getTimestamp() ?? 0) as $video) {
            if (! $video['finished'] || $video['duration_seconds'] < self::MIN_STREAM_SECONDS) {
                $skipped++;
                $log("Přeskakuji {$video['youtube_id']} ({$video['title']}) — probíhající, plánovaný nebo příliš krátký stream.");

                continue;
            }

            $sermon = Sermon::query()->where('youtube_id', $video['youtube_id'])->first();

            if ($sermon) {
                $updated += $this->fillMissingFields($sermon, $video) ? 1 : 0;

                continue;
            }

            $parser = new YoutubeTitleParser($knownSeries, $knownSpeakers);
            $parsed = $parser->parse($video['title'], $video['broadcast_at']);

            $publishedAt = $video['broadcast_at'] ?? $parsed['date'] ?? now();
            $title = $parsed['title'] ?? 'Nedělní setkání '.$publishedAt->format('j. n. Y');

            $series = $parsed['series'] !== null
                ? Series::query()->firstWhere('title', $parsed['series'])
                : null;

            $speaker = null;
            if ($parsed['speaker'] !== null) {
                $speaker = Speaker::query()->firstOrCreate(
                    ['slug' => Str::slug($parsed['speaker'])],
                    ['name' => $parsed['speaker'], 'is_active' => true],
                );

                if ($speaker->wasRecentlyCreated) {
                    $knownSpeakers[] = $speaker->name;
                    $log("Vytvořen nový řečník: {$speaker->name}");
                }
            }

            Sermon::query()->create([
                'title' => $title,
                'slug' => Str::slug(trim(($series?->title ?? '').' '.$title)).'-'.$video['youtube_id'],
                'description' => $video['description'],
                'youtube_id' => $video['youtube_id'],
                'thumbnail_url' => $video['thumbnail_url'],
                'duration_seconds' => $video['duration_seconds'],
                'speaker_id' => $speaker?->id,
                'series_id' => $series?->id,
                'is_published' => true,
                'published_at' => $publishedAt,
            ]);

            $created++;
            $log("Nové kázání: {$title} ({$video['youtube_id']})");
        }

        return ['created' => $created, 'updated' => $updated, 'skipped' => $skipped];
    }

    /**
     * Doplní jen chybějící údaje — ruční úpravy z administrace zůstávají nedotčené.
     *
     * @param  array{description: ?string, thumbnail_url: ?string, duration_seconds: int, broadcast_at: ?Carbon}  $video
     */
    private function fillMissingFields(Sermon $sermon, array $video): bool
    {
        if (empty($sermon->description) && ! empty($video['description'])) {
            $sermon->description = $video['description'];
        }

        if (empty($sermon->thumbnail_url) && ! empty($video['thumbnail_url'])) {
            $sermon->thumbnail_url = $video['thumbnail_url'];
        }

        if (empty($sermon->duration_seconds) && $video['duration_seconds'] > 0) {
            $sermon->duration_seconds = $video['duration_seconds'];
        }

        if ($sermon->published_at === null && $video['broadcast_at'] !== null) {
            $sermon->published_at = $video['broadcast_at'];
        }

        if (! $sermon->isDirty()) {
            return false;
        }

        $sermon->save();

        return true;
    }

    /**
     * Najde v HTML JSON objekt přiřazený dané proměnné a rozparsuje ho
     * (počítáním složených závorek — JSON obsahuje vnořené objekty i řetězce).
     *
     * @return ?array<string, mixed>
     */
    private function extractJsonObject(string $html, string $marker): ?array
    {
        $position = strpos($html, $marker);
        if ($position === false) {
            return null;
        }

        $start = strpos($html, '{', $position);
        if ($start === false) {
            return null;
        }

        $depth = 0;
        $inString = false;
        $escaped = false;
        $length = strlen($html);

        for ($i = $start; $i < $length; $i++) {
            $char = $html[$i];

            if ($escaped) {
                $escaped = false;

                continue;
            }

            if ($char === '\\') {
                $escaped = true;

                continue;
            }

            if ($char === '"') {
                $inString = ! $inString;

                continue;
            }

            if ($inString) {
                continue;
            }

            if ($char === '{') {
                $depth++;
            } elseif ($char === '}') {
                $depth--;

                if ($depth === 0) {
                    return json_decode(substr($html, $start, $i - $start + 1), true);
                }
            }
        }

        return null;
    }

    /**
     * @param  array<array-key, mixed>  $node
     * @param  callable(array<array-key, mixed>): void  $callback
     */
    private function walk(array $node, callable $callback): void
    {
        $callback($node);

        foreach ($node as $child) {
            if (is_array($child)) {
                $this->walk($child, $callback);
            }
        }
    }
}
