<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Sermon;
use App\Models\VisitRequest;
use App\Services\RruleExpanderService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $upcomingOneTime = Event::query()
            ->where('is_published', true)
            ->whereNull('rrule')
            ->whereBetween('starts_at', [now(), now()->addDays(30)])
            ->count();

        $upcomingRecurring = app(RruleExpanderService::class)
            ->expandAll(now(), now()->addDays(30))
            ->count();

        return [
            Stat::make('Nepublikovaná kázání', Sermon::query()->where('is_published', false)->count())
                ->description('Čekají na publikaci')
                ->color('warning'),

            Stat::make('Nové žádosti o návštěvu', VisitRequest::query()->where('was_contacted', false)->count())
                ->description('Nebyly kontaktovány')
                ->color('danger'),

            Stat::make('Nadcházející akce', $upcomingOneTime + $upcomingRecurring)
                ->description('v dalších 30 dnech, včetně opakovaných')
                ->color('success'),
        ];
    }
}
