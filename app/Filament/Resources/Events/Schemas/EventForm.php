<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DateTimePicker::make('starts_at')
                    ->required(),
                DateTimePicker::make('ends_at'),
                TextInput::make('rrule'),
                TextInput::make('category'),
                TextInput::make('location'),
                FileUpload::make('image_url')
                    ->image(),
                Toggle::make('has_registration')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
