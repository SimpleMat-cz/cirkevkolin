<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Placeholder::make('label_display')
                            ->label('Položka')
                            ->content(fn ($record) => $record?->label ?? '—'),

                        Placeholder::make('key_display')
                            ->label('Klíč (technický)')
                            ->content(fn ($record) => new HtmlString('<code class="text-xs text-gray-500">'.e($record?->key ?? '—').'</code>')),

                        Placeholder::make('help_display')
                            ->label('Nápověda')
                            ->content(fn ($record) => $record?->help ?: '—')
                            ->visible(fn ($record) => filled($record?->help)),

                        Textarea::make('value')
                            ->label('Hodnota')
                            ->rows(3)
                            ->autosize()
                            ->visible(fn ($record) => in_array($record?->type, ['textarea', 'multiline'], true)),

                        TextInput::make('value')
                            ->label('Hodnota')
                            ->maxLength(500)
                            ->visible(fn ($record) => ! in_array($record?->type, ['textarea', 'multiline'], true))
                            ->url(fn ($record) => $record?->type === 'url')
                            ->email(fn ($record) => $record?->type === 'email')
                            ->tel(fn ($record) => $record?->type === 'tel'),
                    ]),
            ]);
    }
}
