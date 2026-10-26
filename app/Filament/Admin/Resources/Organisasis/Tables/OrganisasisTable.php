<?php

namespace App\Filament\Admin\Resources\Organisasis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrganisasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode')
                    ->icon('heroicon-o-hashtag')
                    ->iconColor('gray')
                    ->weight('bold')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama Organisasi')
                    ->icon('heroicon-o-building-office-2')
                    ->iconColor('primary')
                    ->weight('bold')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('singkatan')
                    ->label('Singkatan')
                    ->icon('heroicon-o-tag')
                    ->iconColor('info')
                    ->badge()
                    ->color('info')
                    ->placeholder('-')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->icon('heroicon-o-document-text')
                    ->iconColor('gray')
                    ->placeholder('Tidak ada keterangan')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->keterangan)
                    ->searchable(isIndividual: true)
                    ->wrap(),

                TextColumn::make('aktif')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state) => $state ? 'Aktif' : 'Tidak Aktif'
                    )
                    ->color(
                        fn ($state) => $state ? 'success' : 'danger'
                    )
                    ->icon(
                        fn ($state) => $state
                            ? 'heroicon-o-check-circle'
                            : 'heroicon-o-x-circle'
                    )
                    ->sortable(),

            ])

            ->filters([
                TernaryFilter::make('aktif')
                    ->label('Status Organisasi')
                    ->placeholder('Semua organisasi')
                    ->trueLabel('Organisasi aktif')
                    ->falseLabel('Organisasi tidak aktif'),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus yang dipilih'),
                ]),
            ])

            ->defaultSort('nama')

            ->striped()

            ->emptyStateHeading('Belum ada organisasi')

            ->emptyStateDescription(
                'Silakan tambahkan data organisasi baru.'
            )

            ->emptyStateIcon(
                'heroicon-o-building-office-2'
            );
    }
}
