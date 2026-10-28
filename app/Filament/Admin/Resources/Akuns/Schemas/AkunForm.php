<?php

namespace App\Filament\Admin\Resources\Akuns\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AkunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->label('Kode Akun')
                    ->prefixIcon(Heroicon::OutlinedTag)
                    ->placeholder('Contoh: KAS001')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),

                TextInput::make('nama')
                    ->label('Nama Akun')
                    ->prefixIcon(Heroicon::OutlinedWallet)
                    ->placeholder('Contoh: Kas Operasional')
                    ->required()
                    ->maxLength(100),

                Select::make('jenis')
                    ->label('Jenis Akun')
                    ->prefixIcon(Heroicon::AcademicCap)
                    ->options([
                        'kas' => 'Kas',
                        'bank' => 'Bank',
                    ])
                    ->required()
                    ->native(false)
                    ->live()
                    ->default('kas')
                    ->afterStateUpdated(function (
                        $state,
                        callable $set
                    ): void {
                        if ($state === 'kas') {
                            $set('nama_bank', null);
                            $set('no_rekening', null);
                            $set('nama_rekening', null);
                        }
                    }),

                TextInput::make('saldo_awal')
                    ->label('Saldo Awal')
                    ->prefix('Rp')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->step('0.01')
                    ->required()
                    ->helperText(
                        'Saldo kas atau bank pada saat sistem mulai digunakan.'
                    ),

                Select::make('nama_bank')
                    ->label('Nama Bank')
                    ->prefixIcon(Heroicon::OutlinedBuildingLibrary)
                    ->placeholder('Pilih atau masukkan nama bank')
                    ->options([
                        'BCA' => 'BCA',
                        'BRI' => 'BRI',
                        'BNI' => 'BNI',
                        'Mandiri' => 'Mandiri',
                        'BSI' => 'BSI',
                        'CIMB Niaga' => 'CIMB Niaga',
                        'Danamon' => 'Danamon',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->searchable()
                    ->native(false)
                    ->visible(fn ($get): bool => $get('jenis') === 'bank')
                    ->required(fn ($get): bool => $get('jenis') === 'bank')
                    ->dehydrated(),

                TextInput::make('no_rekening')
                    ->label('Nomor Rekening')
                    ->prefixIcon(Heroicon::OutlinedCreditCard)
                    ->placeholder('Masukkan nomor rekening')
                    ->maxLength(50)
                    ->visible(fn ($get): bool => $get('jenis') === 'bank')
                    ->required(fn ($get): bool => $get('jenis') === 'bank'),

                TextInput::make('nama_rekening')
                    ->label('Nama Pemilik Rekening')
                    ->prefixIcon(Heroicon::OutlinedUser)
                    ->placeholder('Nama sesuai rekening bank')
                    ->maxLength(150)
                    ->visible(fn ($get): bool => $get('jenis') === 'bank')
                    ->required(fn ($get): bool => $get('jenis') === 'bank'),

                Toggle::make('aktif')
                    ->label('Status Aktif')
                    ->default(true)
                    ->inline(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon(Heroicon::OutlinedCheck)
                    ->offIcon(Heroicon::OutlinedXMark)
                    ->helperText('Akun yang tidak aktif tidak digunakan untuk transaksi baru.'),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('Catatan tambahan tentang akun...')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);                //
    }
}
