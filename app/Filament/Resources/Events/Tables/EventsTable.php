<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('starts_at', 'asc')
            ->columns([
                TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('category')
                    ->label('Kategorie')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'neděle' => 'info',
                        'wyldlife' => 'danger',
                        'kidztown' => 'success',
                        'skupinky' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('starts_at')
                    ->label('Začátek')
                    ->dateTime('j. n. Y H:i')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Místo')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('has_registration')
                    ->label('Reg.')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Publikováno'),
                SelectFilter::make('category')
                    ->label('Kategorie')
                    ->options([
                        'neděle' => 'Nedělní setkání',
                        'wyldlife' => 'WyldLife',
                        'kidztown' => 'Kidztown',
                        'skupinky' => 'Skupinky',
                        'akce' => 'Akce',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
