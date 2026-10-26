<?php

namespace App\Filament\Admin\Resources\Jemaats\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JemaatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('no_jemaat')
                    ->placeholder('-'),
                TextEntry::make('no_kantong')
                    ->placeholder('-'),
                TextEntry::make('keluarga.id')
                    ->label('Keluarga')
                    ->placeholder('-'),
                TextEntry::make('organisasi.id')
                    ->label('Organisasi')
                    ->placeholder('-'),
                TextEntry::make('kelompok.id')
                    ->label('Kelompok')
                    ->placeholder('-'),
                TextEntry::make('nama'),
                TextEntry::make('jenis_kelamin')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('tanggal_lahir')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('no_hp')
                    ->placeholder('-'),
                TextEntry::make('alamat')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('aktif')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
