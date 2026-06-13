<?php

namespace App\Filament\Resources\Leaders\Tables;

use App\Models\Leader;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Fotka')
                    ->disk(Leader::mediaDisk())
                    ->circular()
                    ->defaultImageUrl(fn (Leader $record): string => 'https://ui-avatars.com/api/?background=ff8c69&color=fff&name='.urlencode($record->name)),
                TextColumn::make('name')
                    ->label('Jméno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('page_slug')
                    ->label('Stránka')
                    ->formatStateUsing(fn (string $state): string => Leader::PAGES[$state] ?? $state)
                    ->badge(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->placeholder('—'),
                ToggleColumn::make('is_active')
                    ->label('Na webu'),
            ])
            ->filters([
                SelectFilter::make('page_slug')
                    ->label('Stránka')
                    ->options(Leader::PAGES),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort')
            ->defaultSort('sort');
    }
}
