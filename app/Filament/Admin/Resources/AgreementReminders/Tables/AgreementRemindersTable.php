<?php

namespace App\Filament\Admin\Resources\AgreementReminders\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgreementRemindersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('agreement.title')
                    ->label('Agreement')
                    ->searchable()
                    ->icon('heroicon-o-document-text')
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('title')
                    ->label('Reminder')
                    ->searchable()
                    ->icon('heroicon-o-tag')
                    ->wrap()
                    ->description(fn ($record): string => $record->remind_at->diffForHumans()),

                TextColumn::make('remind_at')
                    ->label('Reminder Date')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar-days')
                    ->badge()
                    ->color(fn ($record): string => match (true) {
                        $record->remind_at->isPast() => 'danger',
                        $record->remind_at->isToday() => 'warning',
                        $record->remind_at->diffInDays(now()) <= 7 => 'info',
                        default => 'gray',
                    }),

               IconColumn::make('is_sent')
                    ->label('Already Sent')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('warning'),
                // TextColumn::make('is_sent')
                //     ->label('Already Sent')
                //     ->state(fn ($record): string => $record->is_sent ? 'Terkirim' : 'Belum Terkirim')
                //     ->badge()
                //     ->icon(fn ($record): string => $record->is_sent
                //         ? 'heroicon-o-check-circle'
                //         : 'heroicon-o-clock')
                //     ->color(fn ($record): string => $record->is_sent ? 'success' : 'gray'),

                TextColumn::make('sent_at')
                    ->label('Sent At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-o-paper-airplane')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
