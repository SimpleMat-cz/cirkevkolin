<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('title', 'asc')
            ->columns([
                TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('slug')
                    ->label('URL')
                    ->prefix('/')
                    ->color('gray')
                    ->size('sm')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->label('Publikováno')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Upraveno')
                    ->dateTime('j. n. Y H:i')
                    ->sortable()
                    ->since(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->paginated(false);
    }
}
