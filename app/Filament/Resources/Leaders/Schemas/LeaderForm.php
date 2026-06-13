<?php

namespace App\Filament\Resources\Leaders\Schemas;

use App\Models\Leader;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Jméno')
                    ->placeholder('Žužu — Zuzana Dibalová')
                    ->required(),
                TextInput::make('role')
                    ->label('Role / popisek')
                    ->placeholder('Vedoucí WyldLife'),
                Select::make('page_slug')
                    ->label('Stránka')
                    ->options(Leader::PAGES)
                    ->required()
                    ->helperText('Na které stránce se vedoucí zobrazí. Vede-li někdo víc aktivit, přidejte ho vícekrát.'),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->tel()
                    ->placeholder('+420 777 123 456'),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email(),
                TextInput::make('sort')
                    ->label('Pořadí')
                    ->numeric()
                    ->default(0)
                    ->helperText('Nižší číslo = dřív. Pořadí jde měnit i přetažením v seznamu.'),
                FileUpload::make('photo_path')
                    ->label('Fotka')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->directory('vedouci')
                    ->disk(Leader::mediaDisk())
                    ->visibility('public')
                    ->maxSize(4096)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Zobrazit na webu')
                    ->default(true),
            ]);
    }
}
