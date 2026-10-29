<?php

namespace App\Filament\Admin\Resources\TransferAkuns\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransferAkunInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Transfer')
                    ->description('Detail pemindahan dana antar akun gereja.')
                    ->icon('heroicon-o-arrows-right-left')
                    ->schema([
                        TextEntry::make('tanggal')
                            ->label('Tanggal Transfer')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-calendar-days')
                            ->color('primary'),

                        TextEntry::make('ibadah.id')
                            ->label('Ibadah Terkait')
                            ->formatStateUsing(
                                fn ($state) => $state ? 'Ibadah #' . $state : null
                            )
                            ->placeholder('Tidak terkait ibadah')
                            ->icon('heroicon-o-building-library'),

                        TextEntry::make('no_referensi')
                            ->label('Nomor Referensi')
                            ->icon('heroicon-o-hashtag')
                            ->placeholder('Tidak ada referensi')
                            ->copyable(),

                        TextEntry::make('jumlah')
                            ->label('Jumlah Transfer')
                            ->money('IDR', locale: 'id')
                            ->icon('heroicon-o-banknotes')
                            ->color('success')
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Perpindahan Dana')
                    ->description('Informasi akun sumber dan tujuan transfer.')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        TextEntry::make('akunAsal.nama')
                            ->label('Akun Asal')
                            ->icon('heroicon-o-arrow-up-circle')
                            ->color('danger')
                            ->weight('bold')
                            ->placeholder('-'),

                        TextEntry::make('akunTujuan.nama')
                            ->label('Akun Tujuan')
                            ->icon('heroicon-o-arrow-down-circle')
                            ->color('success')
                            ->weight('bold')
                            ->placeholder('-'),

                        TextEntry::make('keterangan')
                            ->label('Keterangan Transfer')
                            ->icon('heroicon-o-document-text')
                            ->placeholder('Tidak ada keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Informasi Sistem')
                    ->description('Riwayat pencatatan data transfer.')
                    ->icon('heroicon-o-clock')
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y, H:i:s')
                            ->icon('heroicon-o-plus-circle')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diperbarui')
                            ->dateTime('d F Y, H:i:s')
                            ->icon('heroicon-o-pencil-square')
                            ->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }
}
