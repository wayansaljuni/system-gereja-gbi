<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

// use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->description('Basic information about the user account.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->placeholder('Enter full name')
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->placeholder('name@company.com')
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->searchable()
                            ->multiple(true)
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-o-shield-check')
                            ->helperText(
                                fn () => auth()->user()->hasRole('super_admin')
                                    ? 'Select the role assigned to this user.'
                                    : 'The role can only be changed by a Super Admin.'
                            )
                            ->disabled(
                                fn () => ! auth()->user()->hasRole('super_admin')
                            )
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Section::make('Account Security')
                    ->description('Manage the password for this user account.')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->placeholder('Enter password')
                            ->prefixIcon('heroicon-o-key')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(
                                fn ($state) => Hash::make($state)
                            )
                            ->required(
                                fn (string $operation): bool =>
                                    $operation === 'create'
                            )
                            ->helperText(
                                fn (string $operation) =>
                                    $operation === 'create'
                                        ? 'Minimum 8 characters.'
                                        : 'Leave blank if you do not want to change the password.'
                            ),
                        Toggle::make('must_change_password')
                            ->label('Require Password Change on First Login')
                            ->helperText('Enable if the user must change their default password on first login.')                            ->default(true) // default true untuk user baru
                            ->inline(false),
                        ])
                    ->columns(1),
            ]);
    }    
}    
