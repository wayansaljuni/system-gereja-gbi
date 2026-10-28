<?php

namespace App\Filament\Admin\Resources\Ibadahs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class IbadahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->label('Kode Ibadah')
                    ->placeholder('Contoh: IBM')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->autocapitalize('characters'),

                TextInput::make('nama')
                    ->label('Nama Ibadah')
                    ->placeholder('Contoh: Ibadah Raya Minggu')
                    ->required()
                    ->maxLength(100),

                Select::make('kategori')
                    ->label('Kategori')
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
                    ->placeholder('Pilih kategori'),

                Toggle::make('aktif')
                    ->label('Status Aktif')
                    ->helperText('Ibadah aktif dapat digunakan dalam transaksi dan laporan.')
                    ->default(true)
                    ->inline(false),
            ])
            ->columns(2);
    }
}
