<?php

namespace App\Filament\Admin\Resources\Absensis\Schemas;

use App\Models\Jemaat;
use App\Services\JemaatService;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;

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

                            TextEntry::make('total_jemaat')
                                ->label('Total Jemaat Hadir')
                                // ->state(fn (Get $get): int =>
                                //     count($get('details') ?? [])
                                // )
                                ->state(fn (Get $get): int =>
                                    collect($get('details') ?? [])
                                        ->filter(fn ($detail) => filled(data_get($detail, 'jemaat_id')))
                                        ->count()
                                )                                
                                ->badge()
                                ->color('primary')
                                ->icon('heroicon-o-users'),
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
                        // ->extraAttributes(['class' => 'repeater-scroll'])
                        ->extraAttributes([
                            'style' => 'max-height: 450px; overflow: auto;',
                        ])
                        // ->label('Data Kehadiran')
                        ->schema([
                            Select::make('jemaat_id')
                                ->label('Nama Jemaat')
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
                                        // ->default(fn () => Jemaat::generateNoJemaat())
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->prefixIcon('heroicon-o-identification')
                                        ->helperText('Nomor jemaat dibuat otomatis.'),

                                    TextInput::make('nama')
                                        ->label('Nama Jemaat')
                                        ->placeholder('Masukkan nama lengkap jemaat')
                                        ->prefixIcon('heroicon-o-user')
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
                                    // $jemaat = Jemaat::create([
                                    //     'no_jemaat' => Jemaat::generateNoJemaat(),
                                    //     'nama' => $data['nama'],
                                    // ]);
                                    // return $jemaat->getKey();
                                    $jemaat = JemaatService::create([
                                        'nama' => $data['nama'],
                                        // 'no_kantong' => $data['no_kantong'] ?? null,
                                    ]);

                                    return $jemaat->getKey();                                    
                                })
                                ->columnSpan(2),
                            Textarea::make('keterangan')
                                ->label('Keterangan')
                                ->placeholder('Catatan opsional')
                                ->rows(1)
                                ->columnSpan(1),
                        ])
                        
                        ->columns([
                            'default' => 1,
                            'md' => 2,
                            'xl' => 5,
                        ])
                        ->table([
                            Repeater\TableColumn::make('Nama Jemaat')
                                ->width('40%'),
                            // Repeater\TableColumn::make('Keterangan')
                            //     ->width('60%'),
                        ])
                        ->defaultItems(3)
                        ->addActionLabel('Tambah Kehadiran Jemaat')
                        ->addActionAlignment(Alignment::Start)
                        ->addAction(
                            fn (Action $action) => $action
                                ->icon('heroicon-o-user-plus')
                                ->color('success')
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
