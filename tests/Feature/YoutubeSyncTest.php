<?php

namespace Tests\Feature;

use App\Models\Series;
use App\Models\Sermon;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class YoutubeSyncTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.youtube.api_key' => 'test-api-key',
            'services.youtube.channel_id' => 'UCnsKOpdlWx4wS0mos_PXfDg',
        ]);
    }

    /**
     * @param  list<array<string, mixed>>  $videos
     */
    private function fakeYoutubeApi(array $videos): void
    {
        Http::fake([
            'https://www.googleapis.com/youtube/v3/playlistItems*' => Http::response([
                'items' => array_map(
                    fn (array $v): array => ['contentDetails' => ['videoId' => $v['id']]],
                    $videos,
                ),
            ]),
            'https://www.googleapis.com/youtube/v3/videos*' => Http::response([
                'items' => array_map(fn (array $v): array => [
                    'id' => $v['id'],
                    'snippet' => [
                        'title' => $v['title'],
                        'description' => $v['description'] ?? 'Popis videa',
                        'publishedAt' => $v['publishedAt'] ?? '2026-06-07T22:02:39Z',
                        'liveBroadcastContent' => $v['liveBroadcastContent'] ?? 'none',
                        'thumbnails' => [
                            'high' => ['url' => "https://i.ytimg.com/vi/{$v['id']}/hqdefault.jpg"],
                            'maxres' => ['url' => "https://i.ytimg.com/vi/{$v['id']}/maxresdefault.jpg"],
                        ],
                    ],
                    'contentDetails' => ['duration' => $v['duration'] ?? 'PT1H30M'],
                    'liveStreamingDetails' => [
                        'actualStartTime' => $v['startedAt'] ?? '2026-06-07T07:46:35Z',
                    ],
                ], $videos),
            ]),
        ]);
    }

    public function test_creates_sermon_with_parsed_title_speaker_and_series(): void
    {
        Series::factory()->create(['title' => 'Cenzurováno', 'slug' => 'cenzurovano']);

        $this->fakeYoutubeApi([[
            'id' => 'AmeTm94NpgE',
            'title' => '26.4.2026 - Cenzurováno - ZNOVUZROZENÍ - Radek Smetana',
            'startedAt' => '2026-04-26T07:57:13Z',
        ]]);

        $this->artisan('youtube:sync')->assertSuccessful();

        $sermon = Sermon::query()->where('youtube_id', 'AmeTm94NpgE')->firstOrFail();

        $this->assertSame('Znovuzrození', $sermon->title);
        $this->assertSame('cenzurovano-znovuzrozeni-AmeTm94NpgE', $sermon->slug);
        $this->assertSame('Cenzurováno', $sermon->series->title);
        $this->assertSame('Radek Smetana', $sermon->speaker->name);
        $this->assertSame(5400, $sermon->duration_seconds);
        $this->assertSame('https://i.ytimg.com/vi/AmeTm94NpgE/maxresdefault.jpg', $sermon->thumbnail_url);
        $this->assertTrue($sermon->is_published);
        $this->assertSame('2026-04-26 07:57:13', $sermon->published_at->toDateTimeString());
    }

    public function test_uses_streams_playlist_of_channel(): void
    {
        $this->fakeYoutubeApi([]);

        $this->artisan('youtube:sync')->assertSuccessful();

        Http::assertSent(function ($request): bool {
            return str_contains($request->url(), 'playlistItems')
                && $request['playlistId'] === 'UULVnsKOpdlWx4wS0mos_PXfDg';
        });
    }

    public function test_does_not_overwrite_manually_edited_sermons(): void
    {
        $speaker = Speaker::factory()->create(['name' => 'Ida Pencová']);
        $sermon = Sermon::factory()->create([
            'youtube_id' => 'zcUPOHfJNcM',
            'title' => 'Svatost',
            'slug' => 'cenzurovano-svatost-zcUPOHfJNcM',
            'description' => 'Ručně upravený popis',
            'speaker_id' => $speaker->id,
            'thumbnail_url' => null,
            'duration_seconds' => null,
        ]);

        $this->fakeYoutubeApi([[
            'id' => 'zcUPOHfJNcM',
            'title' => '19.4.2026 - Cenzurováno - SVATOST - Ida Pencová',
            'description' => 'Popis z YouTube',
            'duration' => 'PT1H20M17S',
        ]]);

        $this->artisan('youtube:sync')->assertSuccessful();

        $sermon->refresh();

        $this->assertSame('Svatost', $sermon->title);
        $this->assertSame('Ručně upravený popis', $sermon->description);
        $this->assertSame(4817, $sermon->duration_seconds);
        $this->assertSame('https://i.ytimg.com/vi/zcUPOHfJNcM/maxresdefault.jpg', $sermon->thumbnail_url);
        $this->assertSame(1, Sermon::query()->count());
    }

    public function test_skips_live_upcoming_and_short_streams(): void
    {
        $this->fakeYoutubeApi([
            ['id' => 'live0000000', 'title' => 'Právě vysíláme', 'liveBroadcastContent' => 'live', 'duration' => 'PT0S'],
            ['id' => 'upcoming000', 'title' => 'Příští neděle', 'liveBroadcastContent' => 'upcoming', 'duration' => 'PT0S'],
            ['id' => 'short000000', 'title' => '7.6.2026 - Přerušený stream', 'duration' => 'PT3M12S'],
        ]);

        $this->artisan('youtube:sync')->assertSuccessful();

        $this->assertSame(0, Sermon::query()->count());
    }

    public function test_fails_gracefully_on_api_error(): void
    {
        Http::fake([
            'https://www.googleapis.com/youtube/v3/*' => Http::response(['error' => 'quota'], 500),
        ]);

        $this->artisan('youtube:sync')->assertFailed();
    }

    public function test_falls_back_to_scraping_without_api_key(): void
    {
        config(['services.youtube.api_key' => null]);

        $page = '<html><script>var ytInitialData = '.json_encode([
            'contents' => [
                ['lockupViewModel' => ['contentId' => 'ui8fIzZUTfw']],
            ],
        ]).';</script></html>';

        Http::fake([
            'https://www.youtube.com/channel/*/streams' => Http::response($page),
            'https://www.youtube.com/youtubei/v1/player' => Http::response([
                'videoDetails' => [
                    'title' => '7.6.2026 - Hostina s Bohem - Martin Fridrich + dětské chvály',
                    'lengthSeconds' => '5441',
                    'shortDescription' => 'Popis',
                    'isLive' => false,
                    'isUpcoming' => false,
                    'thumbnail' => ['thumbnails' => [
                        ['url' => 'https://i.ytimg.com/vi/ui8fIzZUTfw/maxresdefault.jpg?sqp=abc'],
                    ]],
                ],
                'microformat' => ['playerMicroformatRenderer' => [
                    'liveBroadcastDetails' => ['startTimestamp' => '2026-06-07T07:46:35+00:00'],
                ]],
            ]),
        ]);

        $this->artisan('youtube:sync')->assertSuccessful();

        $sermon = Sermon::query()->where('youtube_id', 'ui8fIzZUTfw')->firstOrFail();

        $this->assertSame('Hostina s Bohem', $sermon->title);
        $this->assertSame('Martin Fridrich', $sermon->speaker->name);
        $this->assertSame(5441, $sermon->duration_seconds);
        $this->assertSame('https://i.ytimg.com/vi/ui8fIzZUTfw/maxresdefault.jpg', $sermon->thumbnail_url);
        $this->assertSame('2026-06-07 07:46:35', $sermon->published_at->toDateTimeString());
    }
}
