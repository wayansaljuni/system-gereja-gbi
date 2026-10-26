<?php

namespace App\Filament\Admin\Resources\Kelompoks\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class KelompoksTable
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
                    ->label('Nama KPW')
                    ->icon('heroicon-o-user-group')
                    ->iconColor('primary')
                    ->weight('bold')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->icon('heroicon-o-tag')
                    ->iconColor('info')
                    ->badge()
                    ->color('info')
                    ->placeholder('Belum ditentukan')
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
                    ->label('Status Kelompok')
                    ->placeholder('Semua kelompok')
                    ->trueLabel('Kelompok aktif')
                    ->falseLabel('Kelompok tidak aktif'),
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
            ->defaultSort('nama')
            ->striped()
            ->emptyStateHeading('Belum ada kelompok')
            ->emptyStateDescription(
                'Silakan tambahkan data kelompok baru.'
            )
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
