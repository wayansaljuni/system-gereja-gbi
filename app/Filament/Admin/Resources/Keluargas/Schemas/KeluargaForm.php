<?php

namespace App\Filament\Admin\Resources\Keluargas\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KeluargaForm
{
    public static function configure(Schema $schema): Schema
    {
    return $schema->components([
        Section::make('Informasi Keluarga')
            ->description('Lengkapi identitas dan informasi keluarga.')
            ->icon('heroicon-o-users')
            ->schema([
                TextInput::make('no_keluarga')
                    ->label('No. Keluarga')
                    ->placeholder('Contoh: KK-001')
                    ->prefixIcon('heroicon-o-identification')
                    ->maxLength(30)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->extraInputAttributes([
                        'style' => 'text-transform: uppercase',
                    ])
                    ->dehydrateStateUsing(
                        fn ($state) => strtoupper($state ?? '')
                    )                    
                    ->helperText('Nomor keluarga harus unik.'),

                TextInput::make('nama_keluarga')
                    ->label('Nama Keluarga')
                    ->placeholder('Contoh: Keluarga Bapak Andi')
                    ->prefixIcon('heroicon-o-user-group')
                    ->required()
                    ->maxLength(150),

                Textarea::make('alamat')
                    ->label('Alamat Lengkap')
                    ->placeholder('Masukkan alamat lengkap keluarga...')
                    ->rows(3)
                    ->autosize()
                    ->columnSpanFull(),

                TextInput::make('no_hp')
                    ->label('Nomor HP')
                    ->placeholder('Contoh: 081234567890')
                    ->prefixIcon('heroicon-o-phone')
                    ->tel()
                    ->maxLength(30),

                Toggle::make('aktif')
                    ->label('Status Keluarga')
                    ->helperText('Aktifkan jika keluarga masih terdaftar.')
                    ->default(true)
                    ->required()
                    ->inline(false),
            ])
            ->columns(2)
            ->columnSpanFull(),
        ]);
    }
}
