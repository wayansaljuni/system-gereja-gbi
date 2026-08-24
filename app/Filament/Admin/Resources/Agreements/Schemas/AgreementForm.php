<?php

namespace App\Filament\Admin\Resources\Agreements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AgreementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
           ->components([
                Section::make('Agreement Details')
                    // ->description('Data utama perjanjian')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('agreement_number')
                            ->label('Agreement Number')
                            ->prefixIcon(Heroicon::OutlinedHashtag)
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->placeholder('cth: AGR/2026/001'),

                        Select::make('agreement_type_id')
                            ->label('Agreement Type')
                            ->required()
                            ->relationship('agreementType', 'name')
                            ->prefixIcon(Heroicon::OutlinedTag)
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('code')->required()->maxLength(30),
                                TextInput::make('name')->required()->maxLength(100),
                            ])
                            ->native(false),

                        Textarea::make('title')
                            ->label('Document Name')
                            // ->prefixIcon(Heroicon::OutlinedBookmark)
                            ->required()
                            ->maxLength(255)
                            ->placeholder('entry detail dokumen')
                            ->columnSpanFull(),

                        TextInput::make('qty')
                            ->label('Qty')
                            ->prefixIcon(Heroicon::OutlinedCube)
                            ->required()
                            ->maxLength(255),

                        Select::make('sifat')
                            ->label('Document Nature')
                            ->options([
                                'Original' => 'Original',
                                'Copy' => 'Copy',
                                'Scan' => 'Scan',
                            ])
                            ->native(false)
                            ->prefixIcon(Heroicon::OutlinedDocumentDuplicate)
                            ->default('Original')
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->prefixIcon(Heroicon::OutlinedCalendar)
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->prefixIcon(Heroicon::OutlinedCalendar)
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->after('start_date'),

                    ])
                    ->columns(2),

                Section::make('Status & Reminder')
                    ->icon(Heroicon::OutlinedBellAlert)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'expired' => 'Expired',
                                'terminated' => 'Terminated',
                                'cancelled' => 'Cancelled',
                            ])
                            ->native(false)
                            ->prefixIcon(Heroicon::OutlinedFlag)
                            ->default('draft')
                            ->required(),

                        Toggle::make('reminder_enabled')
                            ->label('Enable Reminder')
                            ->onIcon(Heroicon::OutlinedBellAlert)
                            ->offIcon(Heroicon::OutlinedBellSlash)
                            ->onColor('success')
                            ->default(true),
                        Textarea::make('pic')
                            ->label('PIC (Person in Charge)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Section::make('Catatan')
                //     ->icon(Heroicon::OutlinedPencilSquare)
                //     ->schema([
                //         Textarea::make('notes')
                //             ->label('Catatan Tambahan')
                //             ->rows(4)
                //             ->columnSpanFull(),
                //     ])
                //     ->collapsible(),
            ]);
    }
}
