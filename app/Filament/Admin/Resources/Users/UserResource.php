<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Schemas\UserInfolist;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Setting';
    protected static ?string $model = User::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if (! $user->hasRole('super_admin')) {
            $query->where('id', $user->id);
        }

        return $query;
    }
    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();

        return $user->hasRole('super_admin')
            || $record->id === $user->id;
    }
    public static function canView(Model $record): bool
    {
        $user = auth()->user();

        return $user->hasRole('super_admin')
            || $record->id === $user->id;
    }
    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
    public static function canCreate(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
}
