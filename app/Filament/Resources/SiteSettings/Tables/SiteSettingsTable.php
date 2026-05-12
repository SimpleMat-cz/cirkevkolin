<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort', 'asc')
            ->groups(['group'])
            ->defaultGroup('group')
            ->columns([
                TextColumn::make('label')
                    ->label('Položka')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('value')
                    ->label('Hodnota')
                    ->limit(60)
                    ->placeholder('—')
                    ->wrap(),
                TextColumn::make('key')
                    ->label('Klíč')
                    ->color('gray')
                    ->size('xs')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('group')
                    ->label('Skupina')
                    ->badge()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Skupina')
                    ->options([
                        'contact' => 'Kontakt',
                        'service' => 'Bohoslužby',
                        'social' => 'Sociální sítě',
                        'meta' => 'Meta / SEO',
                        'general' => 'Obecné',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->paginated(false);
    }
}
