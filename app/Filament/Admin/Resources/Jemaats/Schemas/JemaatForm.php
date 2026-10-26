<?php

namespace App\Filament\Admin\Resources\Jemaats\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JemaatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make('Identitas Jemaat')
                ->description('Informasi dasar dan identitas jemaat.')
                ->icon('heroicon-o-identification')
                ->schema([

                    TextInput::make('no_jemaat')
                        ->label('No. Jemaat')
                        ->placeholder('Contoh: JM001')
                        ->prefixIcon('heroicon-o-hashtag')
                        ->maxLength(30)
                        ->unique(ignoreRecord: true)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => $state
                                ? strtoupper(trim($state))
                                : null
                        ),

                    TextInput::make('no_kantong')
                        ->label('No. Kantong')
                        ->placeholder('Contoh: KTG001')
                        ->prefixIcon('heroicon-o-tag')
                        ->maxLength(30)
                        ->unique(ignoreRecord: true)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => $state
                                ? strtoupper(trim($state))
                                : null
                        ),

                    TextInput::make('nama')
                        ->label('Nama Jemaat')
                        ->placeholder('Masukkan nama lengkap')
                        ->prefixIcon('heroicon-o-user')
                        ->required()
                        ->maxLength(150)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => strtoupper(trim($state ?? ''))
                        ),

                    Select::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->placeholder('Pilih jenis kelamin')
                        ->prefixIcon('heroicon-o-user')
                        ->options([
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan',
                        ])
                        ->native(false),

                    DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->placeholder('Pilih tanggal lahir')
                        ->prefixIcon('heroicon-o-calendar')
                        ->displayFormat('d/m/Y')
                        ->native(false)
                        ->maxDate(now()),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Keanggotaan')
                ->description('Hubungan jemaat dengan keluarga, kelompok dan organisasi.')
                ->icon('heroicon-o-user-group')
                ->schema([

                    Select::make('keluarga_id')
                        ->label('Keluarga')
                        ->placeholder('Pilih keluarga')
                        ->prefixIcon('heroicon-o-home')
                        ->relationship(
                            name: 'keluarga',
                            titleAttribute: 'nama_keluarga'
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),

                    Select::make('organisasi_id')
                        ->label('Organisasi')
                        ->placeholder('Pilih organisasi')
                        ->prefixIcon('heroicon-o-building-office-2')
                        ->relationship(
                            name: 'organisasi',
                            titleAttribute: 'nama'
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),

                    Select::make('kelompok_id')
                        ->label('Kelompok')
                        ->placeholder('Pilih kelompok')
                        ->prefixIcon('heroicon-o-user-group')
                        ->relationship(
                            name: 'kelompok',
                            titleAttribute: 'nama'
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(3)
                ->columnSpanFull(),

            Section::make('Kontak & Alamat')
                ->description('Informasi komunikasi dan alamat jemaat.')
                ->icon('heroicon-o-map-pin')
                ->schema([

                    TextInput::make('no_hp')
                        ->label('No. HP')
                        ->placeholder('Contoh: 08123456789')
                        ->prefixIcon('heroicon-o-phone')
                        ->tel()
                        ->maxLength(30),

                    Textarea::make('alamat')
                        ->label('Alamat')
                        ->placeholder('Masukkan alamat lengkap...')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(),

                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Status')
                ->icon('heroicon-o-check-circle')
                ->schema([

                    Toggle::make('aktif')
                        ->label('Jemaat Aktif')
                        ->helperText('Aktifkan jika jemaat masih terdaftar.')
                        ->onIcon('heroicon-o-check-circle')
                        ->offIcon('heroicon-o-x-circle')
                        ->default(true)
                        ->required(),

                ])
                ->columnSpanFull(),
        ]);
    }
}
