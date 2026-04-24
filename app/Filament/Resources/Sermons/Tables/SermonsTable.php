<?php

namespace App\Filament\Resources\Sermons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SermonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('speaker.name')
                    ->label('Kazatel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('series.title')
                    ->label('Série')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('youtube_id')
                    ->label('YouTube ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Datum')
                    ->date('j. n. Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Vytvořeno')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Publikováno'),
                SelectFilter::make('speaker')
                    ->label('Kazatel')
                    ->relationship('speaker', 'name'),
                SelectFilter::make('series')
                    ->label('Série')
                    ->relationship('series', 'title'),
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
