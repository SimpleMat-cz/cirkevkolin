<?php

namespace App\Filament\Resources\VisitRequests\Pages;

use App\Filament\Resources\VisitRequests\VisitRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisitRequest extends EditRecord
{
    protected static string $resource = VisitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
