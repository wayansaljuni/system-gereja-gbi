<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransaksiKeuanganHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Transaksi')
                ->schema([
                    DateTimePicker::make('tanggal')
                        ->label('Tanggal Transaksi')
                        ->required()
                        ->default(now())
                        ->seconds(false),

                    Select::make('ibadah_id')
                        ->label('Ibadah')
                        ->relationship(
                            name: 'ibadah',
                            titleAttribute: 'nama',
                            modifyQueryUsing: fn ($query) => $query
                                ->where('aktif', true)
                                ->orderBy('nama')
                        )
                        ->searchable()
                        ->preload()
                        ->required(),

                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(1)
                        ->columnSpan(1),
                ])
                ->columns(3)
                ->columnSpanFull(),
        ]);
    }
}