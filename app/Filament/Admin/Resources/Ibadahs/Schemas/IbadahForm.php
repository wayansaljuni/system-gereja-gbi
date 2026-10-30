<?php

namespace App\Filament\Admin\Resources\Ibadahs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IbadahForm
{
    public static function configure(Schema $schema): Schema
    {
    return $schema
        ->components([

            Section::make('Informasi Ibadah')
                ->description('Lengkapi identitas dan kategori ibadah gereja.')
                ->icon('heroicon-o-building-library')
                ->iconColor('primary')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'md' => 2,
                    ])->schema([

                        TextInput::make('kode')
                            ->label('Kode Ibadah')
                            ->placeholder('Contoh: IBM')
                            ->prefixIcon('heroicon-o-qr-code')
                            ->helperText('Kode unik untuk identifikasi ibadah.')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->autocapitalize('characters')
                            ->live(onBlur: true),

                        TextInput::make('nama')
                            ->label('Nama Ibadah')
                            ->placeholder('Contoh: Ibadah Raya Minggu')
                            ->prefixIcon('heroicon-o-book-open')
                            ->helperText('Masukkan nama lengkap kegiatan ibadah.')
                            ->required()
                            ->maxLength(100),

                        Select::make('kategori')
                            ->label('Kategori Ibadah')
                            ->options([
                                'Minggu' => 'Ibadah Minggu',
                                'Anak' => 'Sekolah Minggu',
                                'Remaja' => 'Remaja',
                                'Pemuda' => 'Pemuda',
                                'Wanita' => 'Wanita',
                                'Pria' => 'Pria',
                                'Doa' => 'Doa & Pujian',
                                'Perayaan' => 'Perayaan',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->native(false)
                            ->placeholder('Pilih kategori ibadah')
                            ->prefixIcon('heroicon-o-squares-2x2')
                            ->required()
                            ->helperText('Kelompokkan ibadah berdasarkan kategori.'),

                    ]),
                ])
                ->columnSpanFull(),

            Section::make('Pengaturan')
                ->description('Atur ketersediaan ibadah dalam sistem.')
                ->icon('heroicon-o-cog-6-tooth')
                ->iconColor('success')
                ->schema([

                    Toggle::make('aktif')
                        ->label('Status Aktif')
                        ->onColor('success')
                        ->offColor('danger')
                        ->onIcon('heroicon-o-check')
                        ->offIcon('heroicon-o-x-mark')
                        ->default(true)
                        ->inline(false)
                        ->helperText('Ibadah aktif dapat dipilih untuk pencatatan absensi dan laporan.'),

                ])
                ->columnSpanFull(),

        ]);
    }
}
