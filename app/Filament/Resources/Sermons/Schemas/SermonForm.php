<?php

namespace App\Filament\Resources\Sermons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SermonForm
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
                        TextInput::make('youtube_id')
                            ->label('YouTube ID')
                            ->placeholder('dQw4w9WgXcQ'),
                        Select::make('speaker_id')
                            ->label('Kazatel')
                            ->relationship('speaker', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('series_id')
                            ->label('Série')
                            ->relationship('series', 'title')
                            ->searchable()
                            ->preload(),
                        DateTimePicker::make('published_at')
                            ->label('Datum publikace'),
                        Toggle::make('is_published')
                            ->label('Publikováno')
                            ->default(false),
                    ]),

                Section::make('Obsah')
                    ->schema([
                        Textarea::make('description')
                            ->label('Popis / shrnutí')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('bible_references')
                            ->label('Biblické verše')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('study_questions')
                            ->label('Otázky pro skupinku')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Média a metadata')
                    ->columns(2)
                    ->schema([
                        TextInput::make('thumbnail_url')
                            ->label('Náhledový obrázek (URL)')
                            ->url(),
                        TextInput::make('audio_url')
                            ->label('Audio (URL)')
                            ->url(),
                        TextInput::make('duration_seconds')
                            ->label('Délka (sekundy)')
                            ->numeric()
                            ->minValue(0),
                        Select::make('topics')
                            ->label('Témata')
                            ->relationship('topics', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ]),
            ]);
    }
}
