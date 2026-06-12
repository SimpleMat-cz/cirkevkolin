<?php

namespace App\Filament\Resources\Series\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Název')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, ?string $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state ?? '')) : null
                    ),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->label('Popis')
                    ->rows(4)
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Publikováno')
                    ->default(true),
            ]);
    }
}
