<?php

namespace App\Filament\Admin\Resources\Perpuluhans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PerpuluhanForm
{
    public static function configure(Schema $schema): Schema
    {
return $schema
    ->components([
        Section::make('Informasi Kantong Jemaat')
            ->description('Lengkapi nomor kantong dan data jemaat yang terdaftar.')
            ->icon('heroicon-o-identification')
            ->schema([
                TextInput::make('no_kantong')
                    ->label('Nomor Kantong')
                    ->placeholder('Contoh: 001, 002, 003')
                    ->prefixIcon('heroicon-o-hashtag')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),

                Select::make('jemaat_id')
                    ->label('Nama Jemaat')
                    ->relationship('jemaat', 'nama')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih atau cari nama jemaat')
                    ->prefixIcon('heroicon-o-user')
                    ->required()
                    ->native(false),
            ])
            ->columns(2),
    ]);    }
}
