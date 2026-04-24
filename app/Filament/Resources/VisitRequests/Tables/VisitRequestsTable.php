<?php

namespace App\Filament\Resources\VisitRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VisitRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Jméno')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('people_count')
                    ->label('Počet osob')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('planned_visit_date')
                    ->label('Plánovaná návštěva')
                    ->date('j. n. Y')
                    ->sortable(),
                IconColumn::make('was_contacted')
                    ->label('Kontaktováno')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Přišlo')
                    ->dateTime('j. n. Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('was_contacted')
                    ->label('Kontaktováno'),
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
