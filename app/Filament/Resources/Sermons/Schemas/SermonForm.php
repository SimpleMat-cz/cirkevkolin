<?php

namespace App\Filament\Resources\Sermons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SermonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('youtube_id'),
                TextInput::make('audio_url')
                    ->url(),
                TextInput::make('duration_seconds')
                    ->numeric(),
                TextInput::make('thumbnail_url')
                    ->url(),
                Textarea::make('bible_references')
                    ->columnSpanFull(),
                Textarea::make('study_questions')
                    ->columnSpanFull(),
                Select::make('speaker_id')
                    ->relationship('speaker', 'name'),
                Select::make('series_id')
                    ->relationship('series', 'title'),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
