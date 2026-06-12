<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Uživatelé';

    protected static ?string $modelLabel = 'Uživatel';

    protected static ?string $pluralModelLabel = 'Uživatelé';

    protected static ?int $navigationSort = 99;

    /** Popisky rolí pro výběr v administraci. */
    public const ROLE_LABELS = [
        'admin' => 'Administrátor — plný přístup včetně uživatelů',
        'editor' => 'Editor — správa obsahu webu',
        'preacher' => 'Kazatel — přístup do administrace',
        'broadcaster' => 'Vysílání — ovládání živého překladu',
    ];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Systém';
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
