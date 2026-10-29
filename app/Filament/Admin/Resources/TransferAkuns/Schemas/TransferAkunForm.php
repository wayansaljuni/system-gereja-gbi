<?php

namespace App\Filament\Admin\Resources\TransferAkuns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class TransferAkunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            DateTimePicker::make('tanggal')
                ->label('Tanggal Transfer')
                ->placeholder('Pilih tanggal dan waktu')
                ->required()
                ->default(now())
                ->seconds(false)
                ->native(false)
                ->prefixIcon('heroicon-o-calendar-days')
                ->columnSpan(1),

            Select::make('ibadah_id')
                ->label('Ibadah Terkait')
                ->relationship('ibadah', 'id')
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => 'Ibadah #' . $record->id
                )
                ->searchable()
                ->preload()
                ->nullable()
                ->placeholder('Pilih ibadah (opsional)')
                ->prefixIcon('heroicon-o-building-library')
                ->columnSpan(1),

            Select::make('akun_asal_id')
                ->label('Akun Asal')
                ->relationship(
                    name: 'akunAsal',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn ($query) => $query
                        ->where('aktif', true)
                        ->orderBy('nama')
                )
                ->searchable()
                ->preload()
                ->required()
                ->different('akun_tujuan_id')
                ->validationMessages([
                    'different' => 'Akun asal dan akun tujuan harus berbeda.',
                ])
                ->placeholder('Pilih sumber dana')
                ->prefixIcon('heroicon-o-arrow-up-circle')
                ->helperText('Akun yang saldonya akan berkurang.')
                ->columnSpan(1),

            Select::make('akun_tujuan_id')
                ->label('Akun Tujuan')
                ->relationship(
                    name: 'akunTujuan',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn ($query) => $query
                        ->where('aktif', true)
                        ->orderBy('nama')
                )
                ->searchable()
                ->preload()
                ->required()
                ->different('akun_asal_id')
                ->validationMessages([
                    'different' => 'Akun asal dan akun tujuan harus berbeda.',
                ])
                ->placeholder('Pilih tujuan dana')
                ->prefixIcon('heroicon-o-arrow-down-circle')
                ->helperText('Akun yang saldonya akan bertambah.')
                ->columnSpan(1),

            TextInput::make('jumlah')
                ->label('Jumlah Transfer')
                ->required()
                ->numeric()
                ->minValue(0.01)
                ->prefix('Rp')
                ->placeholder('0')
                ->maxLength(20)
                ->prefixIcon('heroicon-o-banknotes')
                ->helperText('Masukkan nominal tanpa simbol Rp.')
                ->columnSpan(1),

            TextInput::make('no_referensi')
                ->label('Nomor Referensi')
                ->placeholder('Contoh: TRF-2026-001')
                ->maxLength(100)
                ->nullable()
                ->prefixIcon('heroicon-o-hashtag')
                ->helperText('Nomor bukti transfer, jika tersedia.')
                ->columnSpan(1),

            Textarea::make('keterangan')
                ->label('Keterangan / Catatan')
                ->helperText(new HtmlString(
                    'Tuliskan tujuan transfer atau catatan tambahan. '
                    . 'Jika tidak ada, biarkan kosong.'
                ))
                ->placeholder('Tuliskan tujuan atau catatan transfer...')
                ->rows(3)
                ->nullable()
                ->columnSpanFull(),
                
        ])->columns(2);
    }
}
