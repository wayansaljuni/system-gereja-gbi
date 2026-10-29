<?php

namespace App\Filament\Admin\Resources\Absensis\Schemas;

use App\Models\Jemaat;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class AbsensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | INFORMASI ABSENSI
            |--------------------------------------------------------------------------
            */
            Section::make('Informasi Absensi')
                // ->description('Tentukan ibadah dan waktu pelaksanaan absensi jemaat.')
                ->icon('heroicon-o-calendar-days')
                ->iconColor('primary')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 3,
                    ])
                        ->schema([
                            Select::make('ibadah_id')
                                ->label('Nama Ibadah')
                                ->placeholder('Pilih jenis ibadah')
                                ->relationship(
                                    name: 'ibadah',
                                    titleAttribute: 'nama',
                                    modifyQueryUsing: fn ($query) => $query
                                        ->where('aktif', true)
                                        ->orderBy('nama')
                                )
                                ->searchable()
                                ->preload()
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-o-building-library'),

                            DatePicker::make('tanggal')
                                ->label('Tanggal Ibadah')
                                ->default(now())
                                ->required()
                                ->native(false)
                                ->displayFormat('d M Y')
                                ->prefixIcon('heroicon-o-calendar'),

                            // TimePicker::make('jam')
                            //     ->label('Jam Ibadah')
                            //     ->seconds(false)
                            //     ->native(false)
                            //     ->prefixIcon('heroicon-o-clock'),

                            // Textarea::make('keterangan')
                            //     ->label('Catatan / Keterangan')
                            //     ->placeholder('Contoh: Ibadah Minggu sesi pertama')
                            //     ->rows(2)
                            //     ->columnSpanFull(),
                        ]),
                ])
                ->compact()
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | REKAP ABSENSI
            |--------------------------------------------------------------------------
            */
            Section::make('Ringkasan Kehadiran')
                // ->description('Ringkasan status kehadiran jemaat.')
                ->icon('heroicon-o-chart-bar')
                ->iconColor('primary')
                ->schema([
                    Grid::make([
                        'default' => 2,
                        'md' => 3,
                        'xl' => 5,
                    ])
                        ->schema([
                            TextEntry::make('total_jemaat')
                                ->label('Total Jemaat')
                                ->state(fn (Get $get): int =>
                                    count($get('details') ?? [])
                                )
                                ->badge()
                                ->color('success')
                                ->icon('heroicon-o-users'),

                            // TextEntry::make('total_hadir')
                            //     ->label('Hadir')
                            //     ->state(fn (Get $get): int =>
                            //         collect($get('details') ?? [])
                            //             ->where('status', 'hadir')
                            //             ->count()
                            //     )
                            //     ->badge()
                            //     ->color('success')
                            //     ->icon('heroicon-o-check-circle'),

                            // TextEntry::make('total_izin')
                            //     ->label('Izin')
                            //     ->state(fn (Get $get): int =>
                            //         collect($get('details') ?? [])
                            //             ->where('status', 'izin')
                            //             ->count()
                            //     )
                            //     ->badge()
                            //     ->color('warning')
                            //     ->icon('heroicon-o-information-circle'),

                            // TextEntry::make('total_sakit')
                            //     ->label('Sakit')
                            //     ->state(fn (Get $get): int =>
                            //         collect($get('details') ?? [])
                            //             ->where('status', 'sakit')
                            //             ->count()
                            //     )
                            //     ->badge()
                            //     ->color('danger')
                            //     ->icon('heroicon-o-heart'),

                            // TextEntry::make('total_alpha')
                            //     ->label('Alpha')
                            //     ->state(fn (Get $get): int =>
                            //         collect($get('details') ?? [])
                            //             ->where('status', 'alpha')
                            //             ->count()
                            //     )
                            //     ->badge()
                            //     ->color('gray')
                            //     ->icon('heroicon-o-x-circle'),
                        ]),
                ])
                ->compact()
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | DAFTAR JEMAAT
            |--------------------------------------------------------------------------
            */
            Section::make('Daftar Kehadiran Jemaat')
                // ->description('Tambahkan jemaat dan tentukan status kehadirannya.')
                ->icon('heroicon-o-clipboard-document-check')
                ->iconColor('primary')
                ->schema([
                    Repeater::make('details')
                        ->relationship('details')
                        // ->label('Data Kehadiran')
                        ->schema([

                        
                            Select::make('jemaat_id')
                                ->label('Jemaat')
                                ->placeholder('Cari nama / no. jemaat')
                                ->options(
                                    fn () => Jemaat::query()
                                        ->orderBy('no_jemaat')
                                        ->get()
                                        ->mapWithKeys(fn ($jemaat) => [
                                            $jemaat->id => trim(
                                                ($jemaat->no_jemaat ?? '-') . ' - ' .
                                                ($jemaat->nama ?? '')
                                            ),
                                        ])
                                        ->all()
                                )
                                ->searchable()
                                ->required()
                                ->native(false)
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()

                                // Form popup untuk menambahkan jemaat baru
                                ->createOptionForm([
                                    TextInput::make('no_jemaat')
                                        ->label('No. Jemaat')
                                        ->maxLength(30),

                                    TextInput::make('nama')
                                        ->label('Nama Jemaat')
                                        ->required()
                                        ->maxLength(150),
                                ])

                                ->createOptionAction(
                                    fn (Action $action) => $action
                                        ->label('Tambah Jemaat Baru')
                                        ->icon('heroicon-o-user-plus')
                                        ->modalHeading('Daftarkan Jemaat Baru')
                                        ->modalSubmitActionLabel('Simpan Jemaat')
                                )

                                ->createOptionUsing(function (array $data): int {
                                    $jemaat = Jemaat::create([
                                        'no_jemaat' => $data['no_jemaat'] ?? null,
                                        'nama' => $data['nama'],
                                    ]);

                                    return $jemaat->getKey();
                                })

                                ->columnSpan(2),

                            // Select::make('status')
                            //     ->label('Status Kehadiran')
                            //     ->options([
                            //         'hadir' => 'Hadir',
                            //         'izin' => 'Izin',
                            //         'sakit' => 'Sakit',
                            //         'alpha' => 'Alpha',
                            //     ])
                            //     ->default('hadir')
                            //     ->required()
                            //     ->live()
                            //     ->native(false)
                            //     ->selectablePlaceholder(false)
                            //     ->columnSpan(1),

                            // TimePicker::make('jam_hadir')
                            //     ->label('Jam Hadir')
                            //     ->seconds(false)
                            //     ->native(false)
                            //     ->prefixIcon('heroicon-o-clock')
                            //     ->visible(
                            //         fn (Get $get): bool =>
                            //             $get('status') === 'hadir'
                            //     )
                            //     ->columnSpan(1),

                            // Textarea::make('keterangan')
                            //     ->label('Keterangan')
                            //     ->placeholder('Catatan opsional')
                            //     ->rows(1)
                            //     ->columnSpan(1),
                        ])
                        ->columns([
                            'default' => 1,
                            'md' => 2,
                            'xl' => 5,
                        ])
                        ->table([
                            Repeater\TableColumn::make('Jemaat')
                                ->width('100%'),
                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Jemaat')
                        ->addAction(
                            fn (Action $action) => $action
                                ->icon('heroicon-o-user-plus')
                                ->color('primary')
                        )
                        ->reorderable(false)
                        ->collapsible()
                        ->cloneable(false)
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ]);
    }
}
