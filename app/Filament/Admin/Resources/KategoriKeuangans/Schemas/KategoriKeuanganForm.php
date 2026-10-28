<?php

namespace App\Filament\Admin\Resources\KategoriKeuangans\Schemas;

use App\Models\Akun;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class KategoriKeuanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->label('Kode Kategori')
                    ->prefixIcon(Heroicon::OutlinedTag)
                    ->placeholder('Contoh: PEM001')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignoreRecord: true),

                TextInput::make('nama')
                    ->label('Nama Kategori')
                    ->prefixIcon(Heroicon::OutlinedRectangleStack)
                    ->placeholder('Contoh: Persembahan Umum')
                    ->required()
                    ->maxLength(150),

                Select::make('tipe')
                    ->label('Tipe Transaksi')
                    ->prefixIcon(Heroicon::OutlinedArrowsRightLeft)
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                    ])
                    ->required()
                    ->native(false)
                    ->live()
                    ->default('pemasukan'),

                Select::make('akun_default_id')
                    ->label('Akun Default')
                    ->prefixIcon(Heroicon::OutlinedWallet)
                    ->placeholder('Pilih akun kas atau bank')
                    ->options(
                        fn (): array => Akun::query()
                            ->where('aktif', true)
                            ->orderBy('nama')
                            ->get()
                            ->mapWithKeys(fn ($akun): array => [
                                $akun->id => "{$akun->kode} - {$akun->nama}"
                                    . ($akun->jenis === 'bank'
                                        ? " ({$akun->nama_bank})"
                                        : ' (Kas)'),
                            ])
                            ->all()
                    )
                    ->searchable()
                    ->native(false)
                    ->helperText(
                        'Akun awal yang disarankan saat membuat transaksi. '
                        . 'Akun aktual tetap ditentukan pada transaksi.'
                    ),

                Toggle::make('bisa_detail_jemaat')
                    ->label('Detail Per Jemaat')
                    ->default(false)
                    ->inline(false)
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon(Heroicon::OutlinedUserGroup)
                    ->offIcon(Heroicon::OutlinedUsers)
                    ->helperText(
                        'Aktifkan untuk kategori seperti perpuluhan '
                        . 'atau persembahan yang dicatat per jemaat.'
                    ),

                Toggle::make('aktif')
                    ->label('Status Aktif')
                    ->default(true)
                    ->inline(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon(Heroicon::OutlinedCheck)
                    ->offIcon(Heroicon::OutlinedXMark)
                    ->helperText(
                        'Kategori tidak aktif tidak digunakan '
                        . 'untuk transaksi baru.'
                    ),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('Catatan tambahan kategori...')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
                            //
    }
}
