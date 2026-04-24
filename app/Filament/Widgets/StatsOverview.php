<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Sermon;
use App\Models\VisitRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Nepublikovaná kázání', Sermon::query()->where('is_published', false)->count())
                ->description('Čekají na publikaci')
                ->color('warning'),

            Stat::make('Nové žádosti o návštěvu', VisitRequest::query()->where('was_contacted', false)->count())
                ->description('Nebyly kontaktovány')
                ->color('danger'),

            Stat::make('Nadcházející akce', Event::query()
                ->where('is_published', true)
                ->where('starts_at', '>=', now())
                ->count())
                ->description('v dalších 30 dnech: '.Event::query()
                    ->where('is_published', true)
                    ->where('starts_at', '>=', now())
                    ->where('starts_at', '<=', now()->addDays(30))
                    ->count())
                ->color('success'),
        ];
    }
}
