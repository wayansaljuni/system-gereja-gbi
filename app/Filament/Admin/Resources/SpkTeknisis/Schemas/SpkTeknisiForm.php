<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
// use Illuminate\Support\HtmlString;

class SpkTeknisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi SPK & Product')
                    ->description('Informasi Surat Perintah Kerja Teknisi')
                    ->icon('heroicon-o-document-text')->iconColor('warning')->columnSpanFull()
                    ->columns(4)
                    ->schema([
                        TextInput::make('teknisi_nama')
                            ->label('Nama Teknisi')
                            ->prefixIcon('heroicon-o-user')
                            ->disabled(),
                        TextInput::make('spk_nospk')
                            ->label('No. SPK')
                            ->prefixIcon('heroicon-o-document-text')
                            ->disabled()
                            ->dehydrated(false),
                        DateTimePicker::make('spk_tgk')
                            ->label('Tanggal SPK')
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->seconds(false)->native(false)
                            ->displayFormat('d M Y')
                            ->disabled()
                            ->dehydrated(false),

                        // TextInput::make('spk_tgk')
                        //     ->label('Tanggal SPK')
                        //     ->prefixIcon('heroicon-o-calendar-days')
                        //     ->disabled()->displayFormat('d m Y')
                        //     ->dehydrated(false),
                        TextInput::make('spk_nmcust')
                            ->label('Customer')
                            ->prefixIcon('heroicon-o-building-office-2')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('spk_nosr')
                            ->label('Serial Number')
                            ->prefixIcon('heroicon-o-qr-code')
                            ->disabled()->dehydrated(false),
                        TextInput::make('produk_kdb')
                            ->label('Kode Barang')
                            ->prefixIcon('heroicon-o-tag')
                            ->disabled()->dehydrated(false),
                        TextInput::make('produk_nmb')
                            ->label('Nama Barang')
                            ->prefixIcon('heroicon-o-cube')
                            ->disabled()->dehydrated(false),
                        TextInput::make('commercial_name')
                            ->label('Commercial Name')
                            ->formatStateUsing(
                                fn ($record) => $record?->komplain?->customer?->nmcomercial
                            )
                            ->prefixIcon('heroicon-o-building-office')
                            ->disabled()->dehydrated(false),
                    ]),

                Section::make('Keluhan & Pekerjaan')
                    ->description('Detail pekerjaan service')
                    ->icon('heroicon-o-wrench-screwdriver')->iconColor('warning')->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        Textarea::make('produk_klh')
                            ->label('Keluhan Customer')
                            // ->label(new HtmlString(
                            //     '<div class="flex items-center gap-2">
                            //         <x-heroicon-o-pencil-square class="w-5 h-5" />
                            //         <span>Remark</span>
                            //     </div>'
                            // ))
                            ->rows(3)->disabled()->dehydrated(false),
                        // Bisa diedit
                        Textarea::make('produk_krskn')
                            ->label('Kerusakan')->required()
                            ->placeholder('Masukkan hasil pemeriksaan / kerusakan...')
                            ->rows(3),
                        // Bisa diedit
                        Textarea::make('produk_solusi')
                            ->label('Solusi / Tindakan')->required()
                            ->placeholder('Masukkan solusi atau tindakan yang dilakukan...')
                            ->rows(3),
                        FileUpload::make('produk_foto_produk')
                            ->label('Foto Produk / Pekerjaan')
                            ->image()->multiple()->imagePreviewHeight('180')->panelLayout('grid')
                            ->directory('spk-teknisi/foto')
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(3000)
                            ->maxFiles(3)
                            ->downloadable()->openable()->reorderable()->appendFiles()
                            ->helperText('Maksimal 3 foto. JPG, PNG atau WEBP (Max 3 MB)'),

                        FileUpload::make('produk_video_produk')
                            ->label('Video Produk / Pekerjaan')
                            ->multiple()
                            ->directory('spk-teknisi/video')
                            ->acceptedFileTypes([
                                'video/mp4',
                                'video/quicktime',
                                'video/webm',
                            ])
                            ->maxSize(3000)
                            ->maxFiles(1)->downloadable()->openable()->reorderable()->appendFiles()
                            ->helperText('Maksimal 1 video. MP4, MOV atau WEBM (Max 3 MB)'),                            

                        Select::make('produk_sts')
                            ->label('Status')->prefixIcon('heroicon-o-arrow-path')
                            ->options([
                                'Process' => 'Process',
                                'Closed' => 'Closed',
                            ])
                            ->native(false)->live()->required(),
                        Select::make('produk_part_kembali')
                            ->label('Part Bekas Kembali')->prefixIcon('heroicon-o-check-badge')
                            ->options([
                                'Yes' => 'Yes',
                                'No' => 'No',
                            ])
                            ->native(false)->live()->required(),
                    ]),

                Section::make('Kunjungan Teknisi')
                    ->description('Waktu kedatangan dan kepulangan teknisi')
                    ->icon('heroicon-o-clock')->iconColor('info')->columnSpanFull()
                    ->columns(4)
                    ->schema([
                        // ==============================
                        // KUNJUNGAN 1
                        // ==============================
                        DateTimePicker::make('produk_tgldtg1')
                            ->label('Kedatangan -1')
                            ->prefixIcon('heroicon-o-arrow-right-circle')
                            ->seconds(false)->minDate(fn ($get) => $get('spk_tgk'))
                            ->displayFormat('d M Y H:i')->native(false)
                            ->required(fn ($livewire): bool =>$livewire->currentVisit === 1)
                            ->disabled(fn ($livewire): bool =>$livewire->currentVisit !== 1),

                        DateTimePicker::make('produk_tglplg1')
                            ->label('Kepulangan -1')
                            ->prefixIcon('heroicon-o-arrow-left-circle')
                            ->seconds(false)->minDate(fn ($get) => $get('produk_tgldtg1'))
                            ->displayFormat('d M Y H:i')->native(false)
                            ->required(fn ($livewire): bool =>$livewire->currentVisit === 1)
                            ->disabled(fn ($livewire): bool =>$livewire->currentVisit !== 1),

                        // ==============================
                        // KUNJUNGAN 2
                        // ==============================

                        DateTimePicker::make('produk_tgldtg2')
                            ->label('Kedatangan -2')
                            ->prefixIcon('heroicon-o-arrow-right-circle')
                            ->seconds(false)->minDate(fn ($get) => $get('spk_tgk'))
                            ->displayFormat('d M Y H:i')->native(false)
                            ->required(fn ($livewire): bool =>$livewire->currentVisit === 2)
                            ->disabled(fn ($livewire): bool =>$livewire->currentVisit !== 2),

                        DateTimePicker::make('produk_tglplg2')
                            ->label('Kepulangan -2')
                            ->prefixIcon('heroicon-o-arrow-left-circle')
                            ->seconds(false)->minDate(fn ($get) => $get('produk_tgldtg2'))
                            ->displayFormat('d M Y H:i')->native(false)
                            ->required(fn ($livewire): bool =>$livewire->currentVisit === 2)
                            ->disabled(fn ($livewire): bool =>$livewire->currentVisit !== 2),

                        // ==============================
                        // KUNJUNGAN 3
                        // ==============================

                        DateTimePicker::make('produk_tgldtg3')
                            ->label('Kedatangan -3')
                            ->prefixIcon('heroicon-o-arrow-right-circle')
                            ->seconds(false)->minDate(fn ($get) => $get('spk_tgk'))
                            ->displayFormat('d M Y H:i')->native(false)
                            ->required(fn ($livewire): bool =>$livewire->currentVisit === 3)
                            ->disabled(fn ($livewire): bool =>$livewire->currentVisit !== 3),

                        DateTimePicker::make('produk_tglplg3')
                            ->label('Kepulangan -3')
                            ->prefixIcon('heroicon-o-arrow-left-circle')
                            ->seconds(false)->minDate(fn ($get) => $get('produk_tgldtg3'))
                            ->displayFormat('d M Y H:i')->native(false)
                            ->required(fn ($livewire): bool =>$livewire->currentVisit === 3 )
                            ->disabled(fn ($livewire): bool =>$livewire->currentVisit !== 3 ),
                ]),
                Section::make('Hasil Pengukuran')
                    ->description('Hasil pengukuran teknis pada produk / mesin')
                    ->icon('heroicon-o-chart-bar')
                    ->iconColor('info')
                    ->columnSpanFull()
                    ->columns(5)
                    ->schema([

                        TextInput::make('produk_yvolt')
                            ->label('Voltage')
                            ->prefixIcon('heroicon-o-bolt')
                            ->suffix('V')
                            ->numeric()
                            ->placeholder('0'),

                        TextInput::make('produk_yampere')
                            ->label('Ampere')
                            ->prefixIcon('heroicon-o-bolt')
                            ->suffix('A')
                            ->numeric()
                            ->placeholder('0'),

                        TextInput::make('produk_ymbar')
                            ->label('Pressure mbar')
                            ->prefixIcon('heroicon-o-adjustments-horizontal')
                            ->suffix('mbar')
                            ->numeric()
                            ->placeholder('0'),

                        TextInput::make('produk_ybar')
                            ->label('Pressure Bar')
                            ->prefixIcon('heroicon-o-adjustments-horizontal')
                            ->suffix('bar')
                            ->numeric()
                            ->placeholder('0'),

                        TextInput::make('produk_ycelcius')
                            ->label('Temperature')
                            ->prefixIcon('heroicon-o-fire')
                            ->suffix('°C')
                            ->numeric()
                            ->placeholder('0'),
                    ]),
                    
          ]);                //
           
    }
}
