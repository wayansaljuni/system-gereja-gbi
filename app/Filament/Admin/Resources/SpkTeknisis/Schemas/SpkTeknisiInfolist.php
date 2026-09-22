<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SpkTeknisiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

            Section::make('Informasi SPK')
                ->description('Informasi Surat Perintah Kerja Teknisi')
                ->icon('heroicon-o-document-text')
                ->iconColor('primary')
                ->columns(4)
                ->schema([

                    TextEntry::make('spk.nospk')
                        ->label('No. SPK')
                        ->icon('heroicon-o-document-text')
                        ->iconColor('primary')
                        ->weight('bold')
                        ->color('primary')
                        ->copyable(),

                    TextEntry::make('spk.tgk')
                        ->label('Tanggal SPK')
                        ->icon('heroicon-o-calendar-days')
                        ->iconColor('info')
                        ->date('d M Y'),

                    TextEntry::make('spk.nosr')
                        ->label('Serial Number')
                        ->icon('heroicon-o-qr-code')
                        ->copyable()
                        ->placeholder('-'),

                    TextEntry::make('spk.nmcust')
                        ->label('Customer')
                        ->icon('heroicon-o-building-office-2')
                        ->iconColor('warning')
                        ->weight('medium')
                        ->placeholder('-'),
                ]),

            Section::make('Teknisi')
                ->description('Teknisi yang bertanggung jawab')
                ->icon('heroicon-o-user-circle')
                ->iconColor('success')
                ->columns(2)
                ->schema([

                    TextEntry::make('nik')
                        ->label('NIK')
                        ->icon('heroicon-o-identification')
                        ->copyable(),

                    TextEntry::make('nama')
                        ->label('Nama Teknisi')
                        ->icon('heroicon-o-user')
                        ->iconColor('success')
                        ->weight('bold'),
                ]),

            Section::make('Produk / Mesin')
                ->description('Informasi produk atau mesin yang dikerjakan')
                ->icon('heroicon-o-cube')
                ->iconColor('primary')
                ->columns(2)
                ->schema([

                    TextEntry::make('spk.produk.kdb')
                        ->label('Kode Barang')
                        ->icon('heroicon-o-tag')
                        ->copyable(),

                    TextEntry::make('spk.produk.nmb')
                        ->label('Nama Barang / Mesin')
                        ->icon('heroicon-o-cube')
                        ->iconColor('primary')
                        ->weight('bold'),
                ]),

            Section::make('Keluhan & Pekerjaan')
                ->description('Detail masalah dan hasil pekerjaan teknisi')
                ->icon('heroicon-o-wrench-screwdriver')
                ->iconColor('warning')
                ->columns(1)
                ->schema([

                    TextEntry::make('spk.produk.klh')
                        ->label('Keluhan Customer')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->iconColor('warning')
                        ->placeholder('-'),

                    TextEntry::make('spk.produk.krskn')
                        ->label('Kerusakan')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->iconColor('danger')
                        ->placeholder('-'),

                    TextEntry::make('spk.produk.solusi')
                        ->label('Solusi / Tindakan')
                        ->icon('heroicon-o-check-circle')
                        ->iconColor('success')
                        ->placeholder('-'),
                ]),

            Section::make('Kunjungan Teknisi')
                ->description('Riwayat waktu datang dan pulang teknisi')
                ->icon('heroicon-o-clock')
                ->iconColor('info')
                ->columns(4)
                ->schema([

                    TextEntry::make('spk.produk.tgldtg1')
                        ->label('Datang 1')
                        ->icon('heroicon-o-arrow-right-circle')
                        ->iconColor('success')
                        ->dateTime('d M Y H:i')
                        ->placeholder('-'),

                    TextEntry::make('spk.produk.tglplg1')
                        ->label('Pulang 1')
                        ->icon('heroicon-o-arrow-left-circle')
                        ->iconColor('danger')
                        ->dateTime('d M Y H:i')
                        ->placeholder('-'),

                    TextEntry::make('spk.produk.tgldtg2')
                        ->label('Datang 2')
                        ->icon('heroicon-o-arrow-right-circle')
                        ->iconColor('success')
                        ->dateTime('d M Y H:i')
                        ->placeholder('-'),

                    TextEntry::make('spk.produk.tglplg2')
                        ->label('Pulang 2')
                        ->icon('heroicon-o-arrow-left-circle')
                        ->iconColor('danger')
                        ->dateTime('d M Y H:i')
                        ->placeholder('-'),
                ]),
        ]);
    }
}
