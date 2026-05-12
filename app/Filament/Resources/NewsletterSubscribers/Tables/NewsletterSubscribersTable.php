<?php

namespace App\Filament\Resources\NewsletterSubscribers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NewsletterSubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->copyable(),
                IconColumn::make('confirmed_at')
                    ->label('Potvrzeno')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->confirmed_at !== null),
                TextColumn::make('created_at')
                    ->label('Přihlášeno')
                    ->dateTime('j. n. Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('confirmed_at')
                    ->label('Potvrzeno')
                    ->queries(
                        true: fn ($q) => $q->whereNotNull('confirmed_at'),
                        false: fn ($q) => $q->whereNull('confirmed_at'),
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
