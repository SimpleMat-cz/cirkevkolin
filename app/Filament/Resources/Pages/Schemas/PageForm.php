<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identifikace')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Název stránky')
                            ->required()
                            ->columnSpanFull(),
                        Placeholder::make('slug_display')
                            ->label('URL')
                            ->content(fn ($record) => new HtmlString('<code class="text-xs text-gray-500">/'.e($record?->slug ?? '').'</code>')),
                        Toggle::make('is_published')
                            ->label('Publikováno')
                            ->default(true),
                    ]),

                Section::make('Hero (úvodní blok stránky)')
                    ->description('První viditelná část stránky – velký nadpis nahoře.')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('hero_eyebrow')
                            ->label('Štítek nad nadpisem')
                            ->helperText('Malý text nad nadpisem (např. „Vítejte", „O nás")')
                            ->maxLength(50),
                        Select::make('hero_accent_color')
                            ->label('Barva zvýraznění')
                            ->options([
                                'coral' => 'Coral (oranžová)',
                                'teal' => 'Teal (tyrkysová)',
                                'primary' => 'Primary (modrá)',
                                'sunny' => 'Sunny (žlutá)',
                            ])
                            ->default('coral'),
                        TextInput::make('hero_title')
                            ->label('Hlavní nadpis')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('hero_title_accent')
                            ->label('Zvýrazněná část nadpisu')
                            ->helperText('Druhá řádka nadpisu, bude barevně odlišena')
                            ->maxLength(100),
                        Textarea::make('hero_description')
                            ->label('Popis pod nadpisem')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO / Meta')
                    ->columns(1)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta titulek')
                            ->maxLength(70)
                            ->helperText('Doporučeno: do 60 znaků. Pokud prázdné, použije se název stránky.'),
                        Textarea::make('meta_description')
                            ->label('Meta popis')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Doporučeno: do 155 znaků.'),
                    ]),
            ]);
    }
}
