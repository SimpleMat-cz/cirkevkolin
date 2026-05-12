<?php

namespace App\Filament\Resources\Faqs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort', 'asc')
            ->reorderable('sort')
            ->groups(['page_slug'])
            ->defaultGroup('page_slug')
            ->columns([
                TextColumn::make('question')
                    ->label('Otázka')
                    ->searchable()
                    ->wrap()
                    ->limit(80),
                TextColumn::make('page_slug')
                    ->label('Stránka')
                    ->badge()
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean(),
                TextColumn::make('sort')
                    ->label('Pořadí')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('page_slug')
                    ->label('Stránka')
                    ->options([
                        'jsem-tu-poprve' => 'Jsem tu poprvé',
                        'kontakt' => 'Kontakt',
                        'kdo-jsme' => 'Kdo jsme',
                        'prispet' => 'Přispět',
                        'general' => 'Obecné',
                    ]),
                TernaryFilter::make('is_published')
                    ->label('Publikováno'),
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
