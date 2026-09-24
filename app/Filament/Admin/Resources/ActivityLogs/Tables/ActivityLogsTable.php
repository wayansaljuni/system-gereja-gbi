<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                // =====================================================
                // WAKTU
                // =====================================================
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->description(
                        fn ($record) => $record->created_at?->diffForHumans()
                    )
                    ->icon('heroicon-o-clock')
                    ->color('gray')
                    ->sortable(),

                // =====================================================
                // USER
                // =====================================================
                TextColumn::make('causer.name')
                    ->label('User')
                    ->icon('heroicon-o-user-circle')
                    ->weight('medium')
                    ->searchable()
                    ->sortable()
                    ->placeholder('System'),

                // =====================================================
                // EVENT
                // =====================================================
                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->icon(fn (?string $state): string => match ($state) {
                        'created' => 'heroicon-o-plus-circle',
                        'updated' => 'heroicon-o-pencil-square',
                        'deleted' => 'heroicon-o-trash',
                        default   => 'heroicon-o-information-circle',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default   => 'gray',
                    })
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'created' => 'Created',
                            'updated' => 'Updated',
                            'deleted' => 'Deleted',
                            default   => ucfirst($state ?? '-'),
                        }
                    )
                    ->sortable(),

                // =====================================================
                // AKTIVITAS
                // =====================================================
                TextColumn::make('description')
                    ->label('Aktivitas')
                    ->icon('heroicon-o-document-text')
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'created' => 'Data dibuat',
                            'updated' => 'Data diperbarui',
                            'deleted' => 'Data dihapus',
                            default   => ucfirst($state ?? '-'),
                        }
                    ),

                // =====================================================
                // MODEL
                // =====================================================
                TextColumn::make('subject_type')
                    ->label('Modul')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-cube')
                    ->formatStateUsing(
                        fn ($state) => $state
                            ? class_basename($state)
                            : '-'
                    )
                    ->sortable(),

                // =====================================================
                // ID
                // =====================================================
                TextColumn::make('subject_id')
                    ->label('Record ID')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('event')
                    ->label('Event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ])
                    ->native(false),
            ])

            ->recordActions([
                //
            ]);
    }
}