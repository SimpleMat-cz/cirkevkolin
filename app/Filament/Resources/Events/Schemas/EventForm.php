<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Základní informace')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Název')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, ?string $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state ?? '')) : null
                            )
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('category')
                            ->label('Kategorie')
                            ->options([
                                'neděle' => 'Nedělní setkání',
                                'wyldlife' => 'WyldLife',
                                'kidztown' => 'Kidztown',
                                'skupinky' => 'Skupinky',
                                'akce' => 'Akce',
                            ]),
                        TextInput::make('location')
                            ->label('Místo konání')
                            ->placeholder('V Zídkách 402, Kolín'),
                        DateTimePicker::make('starts_at')
                            ->label('Začátek')
                            ->required(),
                        DateTimePicker::make('ends_at')
                            ->label('Konec'),
                        Toggle::make('has_registration')
                            ->label('Registrace')
                            ->helperText('Bude zobrazeno registrační tlačítko'),
                        Toggle::make('is_published')
                            ->label('Publikováno')
                            ->default(false),
                    ]),

                Section::make('Obsah')
                    ->schema([
                        Textarea::make('description')
                            ->label('Popis')
                            ->rows(5)
                            ->columnSpanFull(),
                        TextInput::make('image_url')
                            ->label('Obrázek (URL)')
                            ->url()
                            ->columnSpanFull(),
                    ]),

                Section::make('Opakování (RRULE)')
                    ->collapsed()
                    ->schema([
                        TextInput::make('rrule')
                            ->label('RRULE')
                            ->placeholder('FREQ=WEEKLY;BYDAY=SU')
                            ->helperText('RFC 5545 RRULE pro opakující se události. Prázdné = jednorázová akce.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
