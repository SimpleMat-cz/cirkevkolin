<?php

namespace App\Filament\Resources\VisitRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VisitRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('people_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('note')
                    ->columnSpanFull(),
                DatePicker::make('planned_visit_date'),
                Toggle::make('was_contacted')
                    ->required(),
            ]);
    }
}
