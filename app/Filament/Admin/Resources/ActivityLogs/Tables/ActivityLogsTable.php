<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
          ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->placeholder('System'),

                TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->badge(),

                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(
                        fn ($state) => $state ? class_basename($state) : '-'
                    )
                    ->sortable(),

                TextColumn::make('subject_id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                TernaryFilter::make('event')
                    ->label('Event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ]),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ])
            ;
    }
}
