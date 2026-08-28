<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('User Name')
                    ->searchable(isIndividual:true)
                    ->sortable()
                    ->icon('heroicon-o-user-circle')
                    ->weight('medium')
                    ->description(fn ($record): string => $record->email),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable(isIndividual:true)
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->copyMessageDuration(1500),

                TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable(isIndividual:true)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin', 'admin' => 'danger',
                        'manager' => 'warning',
                        default => 'gray',
                    })
                    ->separator(','),

                TextColumn::make('email_verified_at')
                    ->label('Verification Status')
                    ->state(fn ($record): string => $record->email_verified_at ? 'Verified' : 'Unverified')
                    ->badge()
                    ->icon(fn ($record): string => $record->email_verified_at
                        ? 'heroicon-o-check-badge'
                        : 'heroicon-o-exclamation-circle')
                    ->color(fn ($record): string => $record->email_verified_at ? 'success' : 'danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar-days')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-o-pencil-square')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
