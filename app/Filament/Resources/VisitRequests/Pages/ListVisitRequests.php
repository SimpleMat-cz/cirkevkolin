<?php

namespace App\Filament\Resources\VisitRequests\Pages;

use App\Filament\Resources\VisitRequests\VisitRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVisitRequests extends ListRecords
{
    protected static string $resource = VisitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
