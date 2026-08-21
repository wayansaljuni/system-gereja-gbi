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
                Section::make('Data Utama Perjanjian')
                    // ->description('Data utama perjanjian')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('agreement_number')
                            ->label('Nomor Perjanjian')
                            ->prefixIcon(Heroicon::OutlinedHashtag)
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->placeholder('cth: AGR/2026/001'),

                        Select::make('agreement_type_id')
                            ->label('Jenis Perjanjian')
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
                            ->label('Nama Dokumen')
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
                            ->label('Sifat Dokumen')
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
                            ->label('Tanggal Mulai')
                            ->prefixIcon(Heroicon::OutlinedCalendar)
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('end_date')
                            ->label('Tanggal Berakhir')
                            ->prefixIcon(Heroicon::OutlinedCalendar)
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->after('start_date'),

                    ])
                    ->columns(2),

                // Section::make('Periode & Durasi')
                //     ->description('Masa berlaku perjanjian')
                //     ->icon(Heroicon::OutlinedCalendarDays)
                //     ->schema([
                //         DatePicker::make('start_date')
                //             ->label('Tanggal Mulai')
                //             ->prefixIcon(Heroicon::OutlinedCalendar)
                //             ->native(false)
                //             ->displayFormat('d/m/Y'),

                //         DatePicker::make('end_date')
                //             ->label('Tanggal Berakhir')
                //             ->prefixIcon(Heroicon::OutlinedCalendar)
                //             ->native(false)
                //             ->displayFormat('d/m/Y')
                //             ->after('start_date'),

                        // TextInput::make('duration_value')
                        //     ->label('Nilai Durasi')
                        //     ->prefixIcon(Heroicon::OutlinedClock)
                        //     ->numeric()
                        //     ->minValue(1),

                        // Select::make('duration_unit')
                        //     ->label('Satuan Durasi')
                        //     ->options([
                        //         'day' => 'Hari',
                        //         'month' => 'Bulan',
                        //         'year' => 'Tahun',
                        //     ])
                        //     ->native(false)
                        //     ->prefixIcon(Heroicon::OutlinedAdjustmentsHorizontal),
                    // ])
                    // ->columns(2),

                // Section::make('Perpanjangan Otomatis')
                //     ->description('Pengaturan auto-renewal perjanjian')
                //     ->icon(Heroicon::OutlinedArrowPath)
                //     ->schema([
                //         Toggle::make('auto_renewal')
                //             ->label('Aktifkan Perpanjangan Otomatis')
                //             ->onIcon(Heroicon::OutlinedArrowPath)
                //             ->offIcon(Heroicon::OutlinedNoSymbol)
                //             ->onColor('info')
                //             ->live()
                //             ->columnSpanFull(),

                //         TextInput::make('renewal_period_value')
                //             ->label('Nilai Periode Perpanjangan')
                //             ->prefixIcon(Heroicon::OutlinedClock)
                //             ->numeric()
                //             ->minValue(1)
                //             ->visible(fn ($get) => $get('auto_renewal')),

                //         Select::make('renewal_period_unit')
                //             ->label('Satuan Periode Perpanjangan')
                //             ->options([
                //                 'day' => 'Hari',
                //                 'month' => 'Bulan',
                //                 'year' => 'Tahun',
                //             ])
                //             ->native(false)
                //             ->prefixIcon(Heroicon::OutlinedAdjustmentsHorizontal)
                //             ->visible(fn ($get) => $get('auto_renewal')),
                //     ])
                //     ->columns(2),

                Section::make('Status & Reminder')
                    ->icon(Heroicon::OutlinedBellAlert)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Aktif',
                                'expiring' => 'Akan Berakhir',
                                'expired' => 'Berakhir',
                                'terminated' => 'Diakhiri',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->native(false)
                            ->prefixIcon(Heroicon::OutlinedFlag)
                            ->default('draft')
                            ->required(),

                        Toggle::make('reminder_enabled')
                            ->label('Aktifkan Reminder')
                            ->onIcon(Heroicon::OutlinedBellAlert)
                            ->offIcon(Heroicon::OutlinedBellSlash)
                            ->onColor('success')
                            ->default(true),
                        Textarea::make('pic')
                            ->label('PIC (Penanggung Jawab)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(2)
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
