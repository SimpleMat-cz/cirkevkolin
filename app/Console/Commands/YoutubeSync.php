<?php

namespace App\Console\Commands;

use App\Models\Sermon;
use App\Models\Speaker;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

#[Signature('youtube:sync {--channel= : YouTube channel ID (overrides config)}')]
#[Description('Sync sermons from YouTube channel via YouTube Data API v3')]
class YoutubeSync extends Command
{
    public function handle(): int
    {
        $apiKey = config('services.youtube.api_key');
        $channelId = $this->option('channel') ?? config('services.youtube.channel_id');

        if (empty($apiKey)) {
            $this->error('YOUTUBE_API_KEY is not set. Add it to your .env file.');

            return self::FAILURE;
        }

        $this->info("Syncing YouTube channel: {$channelId}");

        $videos = $this->fetchAllVideos($apiKey, $channelId);
        $this->info("Found {$videos->count()} videos.");

        $synced = 0;
        foreach ($videos as $video) {
            $this->syncVideo($video);
            $synced++;
        }

        $this->info("Synced {$synced} sermons.");

        return self::SUCCESS;
    }

    private function fetchAllVideos(string $apiKey, string $channelId): \Illuminate\Support\Collection
    {
        $videos = collect();
        $pageToken = null;

        do {
            $params = [
                'key' => $apiKey,
                'channelId' => $channelId,
                'part' => 'snippet',
                'type' => 'video',
                'maxResults' => 50,
                'order' => 'date',
            ];

            if ($pageToken) {
                $params['pageToken'] = $pageToken;
            }

            $response = Http::get('https://www.googleapis.com/youtube/v3/search', $params);

            if ($response->failed()) {
                $this->error('YouTube API error: '.$response->body());
                break;
            }

            $data = $response->json();
            $items = collect($data['items'] ?? []);

            if ($items->isNotEmpty()) {
                $videoIds = $items->pluck('id.videoId')->filter()->implode(',');
                $details = $this->fetchVideoDetails($apiKey, $videoIds);
                $videos = $videos->merge($details);
            }

            $pageToken = $data['nextPageToken'] ?? null;
        } while ($pageToken);

        return $videos;
    }

    private function fetchVideoDetails(string $apiKey, string $videoIds): \Illuminate\Support\Collection
    {
        $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'key' => $apiKey,
            'id' => $videoIds,
            'part' => 'snippet,contentDetails',
        ]);

        if ($response->failed()) {
            return collect();
        }

        return collect($response->json('items', []));
    }

    private function syncVideo(array $video): void
    {
        $snippet = $video['snippet'];
        $youtubeId = $video['id'];
        $title = $snippet['title'];
        $description = $snippet['description'] ?? null;
        $publishedAt = $snippet['publishedAt'] ?? null;
        $thumbnail = $snippet['thumbnails']['high']['url'] ?? $snippet['thumbnails']['default']['url'] ?? null;

        $defaultSpeaker = Speaker::firstOrCreate(
            ['slug' => 'martin-fridrich'],
            ['name' => 'Martin Fridrich', 'bio' => 'Pastor sboru']
        );

        Sermon::updateOrCreate(
            ['youtube_id' => $youtubeId],
            [
                'title' => $title,
                'slug' => Str::slug($title).'-'.substr($youtubeId, 0, 6),
                'description' => $description,
                'thumbnail_url' => $thumbnail,
                'speaker_id' => $defaultSpeaker->id,
                'is_published' => true,
                'published_at' => $publishedAt ? now()->parse($publishedAt) : null,
            ]
        );
    }
}
