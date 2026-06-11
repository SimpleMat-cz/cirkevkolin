<?php

namespace App\Filament\Resources\VisitRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VisitRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Jméno')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->tel(),
                TextInput::make('people_count')
                    ->label('Počet osob')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('note')
                    ->label('Poznámka')
                    ->columnSpanFull(),
                DatePicker::make('planned_visit_date')
                    ->label('Plánovaný termín návštěvy'),
                Toggle::make('was_contacted')
                    ->label('Kontaktováno'),
            ]);
    }
}
