<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Aktivitas')
                    ->columns(3)
                    ->schema([

                        TextEntry::make('created_at')
                            ->label('Waktu')
                            ->dateTime('d M Y H:i:s'),

                        TextEntry::make('causer.name')
                            ->label('User')
                            ->placeholder('System'),

                        TextEntry::make('event')
                            ->label('Event')
                            ->badge(),

                        TextEntry::make('description')
                            ->label('Aktivitas')
                            ->columnSpanFull(),

                        TextEntry::make('subject_type')
                            ->label('Model')
                            ->formatStateUsing(
                                fn ($state) => $state
                                    ? class_basename($state)
                                    : '-'
                            ),

                        TextEntry::make('subject_id')
                            ->label('Record ID')
                            ->placeholder('-'),

                    ]),

                Section::make('Perubahan Data')
                    ->schema([

                        ViewEntry::make('properties')
                            ->label('')
                            ->view('filament.admin.resources.activity-logs.changes'),

                    ]),
                    //
                ]);
    }
}
