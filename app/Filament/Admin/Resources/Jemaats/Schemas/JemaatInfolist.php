<?php

namespace App\Filament\Admin\Resources\Jemaats\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JemaatInfolist
{
    public static function configure(Schema $schema): Schema
    {
    return $schema->components([

        Section::make('Identitas Jemaat')
            ->description('Informasi identitas dan nomor keanggotaan jemaat.')
            ->icon('heroicon-o-identification')
            ->iconColor('primary')
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('no_jemaat')
                        ->label('Nomor Jemaat')
                        ->icon('heroicon-o-hashtag')
                        ->weight('bold')
                        ->color('primary')
                        ->placeholder('-'),

                    TextEntry::make('no_kantong')
                        ->label('Nomor Kantong')
                        ->icon('heroicon-o-ticket')
                        ->placeholder('-'),

                    TextEntry::make('nama')
                        ->label('Nama Lengkap')
                        ->icon('heroicon-o-user')
                        ->weight('bold')
                        ->placeholder('-'),

                    TextEntry::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->icon('heroicon-o-user-circle')
                        ->badge()
                        ->color(fn (?string $state): string => match ($state) {
                            'L', 'Laki-laki' => 'info',
                            'P', 'Perempuan' => 'danger',
                            default => 'gray',
                        })
                        ->placeholder('-'),

                    TextEntry::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->icon('heroicon-o-cake')
                        ->date('d F Y')
                        ->placeholder('-'),

                    IconEntry::make('aktif')
                        ->label('Status Jemaat')
                        ->boolean()
                        ->trueIcon('heroicon-o-check-circle')
                        ->falseIcon('heroicon-o-x-circle')
                        ->trueColor('success')
                        ->falseColor('danger'),
                ]),
            ])
            ->columns(1)
            ->columnSpanFull(),

        Section::make('Keanggotaan')
            ->description('Informasi keluarga, organisasi, dan kelompok jemaat.')
            ->icon('heroicon-o-user-group')
            ->iconColor('success')
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('keluarga.nama_keluarga')
                        ->label('Keluarga')
                        ->icon('heroicon-o-home')
                        ->placeholder('-'),

                    TextEntry::make('organisasi.nama')
                        ->label('Organisasi')
                        ->icon('heroicon-o-building-office')
                        ->placeholder('-'),

                    TextEntry::make('kelompok.nama')
                        ->label('Kelompok')
                        ->icon('heroicon-o-users')
                        ->placeholder('-'),
                ]),
            ])
            ->columnSpanFull(),

        Section::make('Informasi Kontak')
            ->description('Informasi komunikasi dan alamat tempat tinggal.')
            ->icon('heroicon-o-map-pin')
            ->iconColor('warning')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('no_hp')
                        ->label('Nomor Handphone')
                        ->icon('heroicon-o-phone')
                        ->copyable()
                        ->placeholder('-'),

                    TextEntry::make('alamat')
                        ->label('Alamat Lengkap')
                        ->icon('heroicon-o-map')
                        ->columnSpanFull()
                        ->placeholder('-'),
                ]),
            ])
            ->columnSpanFull(),

        Section::make('Informasi Sistem')
            ->description('Riwayat pencatatan data jemaat.')
            ->icon('heroicon-o-clock')
            ->iconColor('gray')
            ->collapsed()
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('created_at')
                        ->label('Tanggal Dibuat')
                        ->icon('heroicon-o-calendar-days')
                        ->dateTime('d M Y, H:i')
                        ->placeholder('-'),

                    TextEntry::make('updated_at')
                        ->label('Terakhir Diperbarui')
                        ->icon('heroicon-o-pencil-square')
                        ->dateTime('d M Y, H:i')
                        ->placeholder('-'),
                ]),
            ])
            ->columnSpanFull(),

    ]);
    }
}
