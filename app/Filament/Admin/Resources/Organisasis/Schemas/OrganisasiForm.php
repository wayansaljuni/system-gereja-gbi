<?php

namespace App\Filament\Admin\Resources\Organisasis\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganisasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Organisasi')
                ->description('Lengkapi identitas dan informasi organisasi.')
                ->icon('heroicon-o-building-office-2')
                ->schema([

                    TextInput::make('kode')
                        ->label('Kode Organisasi')
                        ->placeholder('Contoh: ORG001')
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
                        ->label('Nama Organisasi')
                        ->placeholder('Contoh: Gereja Bethel Indonesia')
                        ->prefixIcon('heroicon-o-building-office-2')
                        ->required()
                        ->maxLength(100)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => strtoupper(trim($state ?? ''))
                        ),

                    TextInput::make('singkatan')
                        ->label('Singkatan')
                        ->placeholder('Contoh: GBI')
                        ->prefixIcon('heroicon-o-tag')
                        ->maxLength(50)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase',
                        ])
                        ->dehydrateStateUsing(
                            fn ($state) => strtoupper(trim($state ?? ''))
                        ),

                    Toggle::make('aktif')
                        ->label('Status Organisasi')
                        ->helperText('Aktifkan jika organisasi masih digunakan.')
                        ->onIcon('heroicon-o-check-circle')
                        ->offIcon('heroicon-o-x-circle')
                        ->default(true)
                        ->required(),

                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->placeholder('Masukkan keterangan organisasi...')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(),

                ])
                ->columns(2)
                ->columnSpanFull(),
        ]);
    }
}
