<?php

namespace App\Filament\Resources\Topics\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TopicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Název')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, ?string $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state ?? '')) : null
                    ),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }
}
