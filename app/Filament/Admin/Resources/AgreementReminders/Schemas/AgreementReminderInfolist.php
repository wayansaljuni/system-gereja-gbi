<?php

namespace App\Filament\Admin\Resources\AgreementReminders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgreementReminderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Reminder Information')
                    ->icon('heroicon-o-bell-alert')
                    ->schema([
                        TextEntry::make('agreement.title')
                            ->label('Agreement Document Name')
                            ->icon('heroicon-o-document-text')
                            ->weight('medium')
                            ->columnSpanFull(),

                        TextEntry::make('title')
                            ->label('Reminder Title')
                            ->icon('heroicon-o-tag'),

                        TextEntry::make('remind_at')
                            ->label('Reminder Date')
                            ->date('d M Y')
                            ->icon('heroicon-o-calendar-days')
                            ->badge()
                            ->color(fn ($record): string => match (true) {
                                $record->remind_at->isPast() => 'danger',
                                $record->remind_at->isToday() => 'warning',
                                $record->remind_at->diffInDays(now()) <= 7 => 'info',
                                default => 'gray',
                            }),

                        TextEntry::make('message')
                            ->label('Message')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Delivery Status')
                    ->icon('heroicon-o-paper-airplane')
                    ->schema([
                        IconEntry::make('is_sent')
                            ->label('Sent Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        TextEntry::make('sent_at')
                            ->label('Sent Date')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-clock')
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('History')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Reminder Create Date')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-plus-circle')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Reminder Update Date')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-pencil-square')
                            ->placeholder('-'),
                    ])
                    ->columns(2),

        ]);
    }
}
