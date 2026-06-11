<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Na Vercelu scheduler neběží — tam synchronizaci spouští Vercel Cron
// přes /cron/youtube-sync (viz vercel.json). Tohle platí pro klasický hosting.
Schedule::command('youtube:sync')->dailyAt('12:00');
