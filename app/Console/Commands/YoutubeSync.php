<?php

namespace App\Console\Commands;

use App\Services\YoutubeSyncService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Throwable;

#[Signature('youtube:sync
    {--channel= : ID YouTube kanálu (přepíše konfiguraci)}
    {--full : Projít celou historii streamů, ne jen poslední stránku}')]
#[Description('Synchronizuje kázání ze záložky „Živé přenosy" YouTube kanálu')]
class YoutubeSync extends Command
{
    public function handle(YoutubeSyncService $sync): int
    {
        $channelId = $this->option('channel') ?: config('services.youtube.channel_id');

        $this->info("Synchronizuji streamy kanálu: {$channelId}");

        try {
            $result = $sync->sync(
                channelId: $channelId,
                full: (bool) $this->option('full'),
                log: fn (string $message) => $this->line($message),
            );
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf(
            'Hotovo (%s): %d videí, %d nových, %d doplněných, %d přeskočených.',
            $result['source'],
            $result['total'],
            $result['created'],
            $result['updated'],
            $result['skipped'],
        ));

        return self::SUCCESS;
    }
}
