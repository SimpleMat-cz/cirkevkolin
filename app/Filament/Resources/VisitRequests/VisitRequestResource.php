<?php

namespace App\Filament\Resources\VisitRequests;

use App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest;
use App\Filament\Resources\VisitRequests\Pages\EditVisitRequest;
use App\Filament\Resources\VisitRequests\Pages\ListVisitRequests;
use App\Filament\Resources\VisitRequests\Schemas\VisitRequestForm;
use App\Filament\Resources\VisitRequests\Tables\VisitRequestsTable;
use App\Models\VisitRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VisitRequestResource extends Resource
{
    protected static ?string $model = VisitRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return VisitRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVisitRequests::route('/'),
            'create' => CreateVisitRequest::route('/create'),
            'edit' => EditVisitRequest::route('/{record}/edit'),
        ];
    }
}
