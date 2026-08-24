<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AgreementTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')
                    ->description('Kode dan nama jenis perjanjian')
                    ->icon(Heroicon::OutlinedIdentification)
                    ->schema([
                        TextInput::make('code')
                            ->label('Type Code')
                            ->prefixIcon(Heroicon::OutlinedHashtag)
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->placeholder('cth: NDA, MOU, SPK'),

                        TextInput::make('name')
                            ->label('Agreement Type Name')
                            ->prefixIcon(Heroicon::OutlinedDocumentText)
                            ->required()
                            ->maxLength(255)
                            ->placeholder('cth: Non-Disclosure Agreement'),
                    ])
                    ->columns(2),

                Section::make('Deskripsi')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Jelaskan secara singkat jenis perjanjian ini...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Setting')
                    ->description('Set the behavior and status of the type of agreement')
                    ->icon(Heroicon::OutlinedCog6Tooth)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('has_period')
                                    ->label('Period')
                                    // ->helperText('Aktifkan jika perjanjian ini punya masa berlaku')
                                    ->onIcon(Heroicon::OutlinedCalendarDays)
                                    ->offIcon(Heroicon::OutlinedNoSymbol)
                                    ->onColor('info')
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Status Active')
                                    // ->helperText('Nonaktifkan untuk menyembunyikan dari pilihan')
                                    ->onIcon(Heroicon::OutlinedCheckCircle)
                                    ->offIcon(Heroicon::OutlinedXCircle)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->default(true)
                                    ->required(),
                            ]),
                    ]),
            ]);
        }
}
