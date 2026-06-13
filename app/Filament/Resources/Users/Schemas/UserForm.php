<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Resources\Users\UserResource;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Jméno')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Heslo')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->minLength(8)
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->helperText('Při úpravě nechte prázdné, pokud heslo neměníte.'),
                CheckboxList::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(
                        fn ($record): string => UserResource::ROLE_LABELS[$record->name] ?? $record->name,
                    )
                    ->helperText('Bez role admin/editor/kazatel se uživatel do administrace nedostane.')
                    ->columnSpanFull(),
            ]);
    }
}
