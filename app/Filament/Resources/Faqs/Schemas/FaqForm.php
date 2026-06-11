<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('page_slug')
                            ->label('Stránka')
                            ->options([
                                'jsem-tu-poprve' => 'Jsem tu poprvé',
                                'kontakt' => 'Kontakt',
                                'kdo-jsme' => 'Kdo jsme',
                                'prispet' => 'Přispět',
                                'general' => 'Obecné (kdekoliv)',
                            ])
                            ->required()
                            ->default('jsem-tu-poprve'),
                        TextInput::make('sort')
                            ->label('Pořadí')
                            ->numeric()
                            ->default(0)
                            ->helperText('Nižší číslo = výše v seznamu'),
                        TextInput::make('question')
                            ->label('Otázka')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('answer')
                            ->label('Odpověď')
                            ->required()
                            ->rows(4)
                            ->autosize()
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label('Publikováno')
                            ->default(true),
                    ]),
            ]);
    }
}
