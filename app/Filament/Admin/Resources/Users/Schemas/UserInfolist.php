<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make('User Information')
                ->description('Basic information about this user account.')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    TextEntry::make('name')
                        ->label('Full Name')
                        ->icon('heroicon-o-user')
                        ->weight('bold')
                        ->size('lg'),

                    TextEntry::make('email')
                        ->label('Email Address')
                        ->icon('heroicon-o-envelope')
                        ->copyable()
                        ->copyMessage('Email address copied!')
                        ->copyMessageDuration(1500),

                    TextEntry::make('roles.name')
                        ->label('Role')
                        ->icon('heroicon-o-shield-check')
                        ->badge()
                        ->formatStateUsing(
                            fn ($state) => str($state)
                                ->replace('_', ' ')
                                ->title()
                        ),
                ])
                ->columns(2),

            Section::make('Account Status')
                ->description('Account verification and activity information.')
                ->icon('heroicon-o-check-badge')
                ->schema([
                    TextEntry::make('email_verified_at')
                        ->label('Email Verification')
                        ->icon('heroicon-o-envelope-open')
                        ->formatStateUsing(
                            fn ($state) => $state
                                ? 'Verified'
                                : 'Not Verified'
                        )
                        ->badge()
                        ->color(
                            fn ($state) => $state
                                ? 'success'
                                : 'warning'
                        )
                        ->icon(
                            fn ($state) => $state
                                ? 'heroicon-o-check-circle'
                                : 'heroicon-o-exclamation-circle'
                        ),

                    TextEntry::make('created_at')
                        ->label('Account Created')
                        ->icon('heroicon-o-calendar')
                        ->dateTime('d M Y, H:i'),

                    TextEntry::make('updated_at')
                        ->label('Last Updated')
                        ->icon('heroicon-o-clock')
                        ->dateTime('d M Y, H:i'),
                ])
                ->columns(3),
            ]);
    }
}
