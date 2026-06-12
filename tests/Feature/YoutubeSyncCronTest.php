<?php

namespace Tests\Feature;

use App\Services\YoutubeSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class YoutubeSyncCronTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_503_when_secret_is_not_configured(): void
    {
        config(['services.cron.secret' => null]);

        $this->get('/cron/youtube-sync')->assertStatus(503);
    }

    public function test_rejects_missing_or_wrong_token(): void
    {
        config(['services.cron.secret' => 'tajny-token']);

        $this->get('/cron/youtube-sync')->assertStatus(403);
        $this->get('/cron/youtube-sync?token=spatny')->assertStatus(403);
        $this->withHeader('Authorization', 'Bearer spatny')->get('/cron/youtube-sync')->assertStatus(403);
    }

    public function test_runs_sync_with_valid_bearer_token(): void
    {
        config(['services.cron.secret' => 'tajny-token']);

        $this->mock(YoutubeSyncService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('sync')->once()->andReturn([
                'source' => 'api', 'created' => 2, 'updated' => 1, 'skipped' => 0, 'total' => 3,
            ]);
        });

        $this->withHeader('Authorization', 'Bearer tajny-token')
            ->get('/cron/youtube-sync')
            ->assertOk()
            ->assertJson(['created' => 2, 'updated' => 1, 'total' => 3]);
    }

    public function test_runs_sync_with_valid_query_token(): void
    {
        config(['services.cron.secret' => 'tajny-token']);

        $this->mock(YoutubeSyncService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('sync')->once()->andReturn([
                'source' => 'api', 'created' => 0, 'updated' => 0, 'skipped' => 0, 'total' => 0,
            ]);
        });

        $this->get('/cron/youtube-sync?token=tajny-token')->assertOk();
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
