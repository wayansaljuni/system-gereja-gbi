<?php

namespace App\Filament\Admin\Resources\AgreementReminders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgreementReminderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Reminder Information')
                    // ->description('Detail dasar reminder untuk agreement terkait')
                    ->icon('heroicon-o-bell-alert')
                    ->schema([
                        Select::make('agreement_id')
                            ->label('Agreement Name')
                            ->relationship('agreement', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-o-document-text')
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label('Reminder Title')
                            ->required()
                            ->prefixIcon('heroicon-o-tag')
                            ->placeholder('Cth : Renewal Agreement')
                            ->maxLength(255),

                        DatePicker::make('remind_at')
                            ->label('Reminder Date')
                            ->required()
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->minDate(now()),

                        Textarea::make('message')
                            ->label('Message')
                            ->placeholder('Write the message that will be sent in this reminder......')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ])->columns(1);
    }
}
