<?php

namespace App\Filament\Admin\Resources\Kelompoks\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KelompokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Kelompok')
                ->description('Lengkapi identitas dan informasi kelompok.')
                ->icon('heroicon-o-user-group')
                ->schema([
                    TextInput::make('kode')
                        ->label('Kode KPW')
                        ->placeholder('Contoh: KLP001')
                        ->prefixIcon('heroicon-o-hashtag')
                        ->required()
                        ->maxLength(20)
                        ->unique(ignoreRecord: true)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => strtoupper(trim($state ?? ''))
                        ),

                    TextInput::make('nama')
                        ->label('Nama KPW')
                        ->placeholder('Contoh: Kelompok Smirna')
                        ->prefixIcon('heroicon-o-users')
                        ->required()
                        ->maxLength(100)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => strtoupper(trim($state ?? ''))
                        ),

                    TextInput::make('jenis')
                        ->label('Jenis KPW')
                        ->placeholder('Contoh: Komsel, Wilayah, Pelayanan')
                        ->prefixIcon('heroicon-o-tag')
                        ->maxLength(50),

                    Toggle::make('aktif')
                        ->label('Status KPW')
                        ->helperText('Aktifkan jika KPW masih berjalan.')
                        ->onIcon('heroicon-o-check-circle')
                        ->offIcon('heroicon-o-x-circle')
                        ->default(true)
                        ->required(),

                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->placeholder('Masukkan keterangan KPW...')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ]);
    }
}
