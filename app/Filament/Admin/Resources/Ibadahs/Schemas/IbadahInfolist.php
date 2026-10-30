<?php

namespace App\Filament\Admin\Resources\Ibadahs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IbadahInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Detail identitas dan pengaturan kategori.')
                    ->icon('heroicon-o-tag')
                    ->iconColor('primary')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                            'xl' => 3,
                        ])->schema([
                            TextEntry::make('kode')
                                ->label('Kode Kategori')
                                ->icon('heroicon-o-qr-code')
                                ->weight('bold')
                                ->color('primary')
                                ->placeholder('-'),

                            TextEntry::make('nama')
                                ->label('Nama Kategori')
                                ->icon('heroicon-o-tag')
                                ->weight('bold')
                                ->placeholder('-'),

                            TextEntry::make('kategori')
                                ->label('Jenis Kategori')
                                ->icon('heroicon-o-rectangle-stack')
                                ->badge()
                                ->color('info')
                                ->placeholder('-'),

                            IconEntry::make('aktif')
                                ->label('Status')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-x-circle')
                                ->trueColor('success')
                                ->falseColor('danger'),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Informasi Sistem')
                    ->description('Riwayat pembuatan dan perubahan data.')
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('created_at')
                                ->label('Dibuat Pada')
                                ->icon('heroicon-o-calendar-days')
                                ->dateTime('d F Y, H:i')
                                ->placeholder('-'),
                            TextEntry::make('updated_at')
                                ->label('Terakhir Diperbarui')
                                ->icon('heroicon-o-pencil-square')
                                ->dateTime('d F Y, H:i')
                                ->placeholder('-'),
                        ]),
                    ])
                    ->columnSpanFull(),
        ]);
    }
}
