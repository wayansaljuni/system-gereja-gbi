<?php

namespace App\Filament\Admin\Resources\Keluargas\Tables;

// use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
// use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class KeluargasTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('no_keluarga')
                ->label('No. Keluarga')
                ->icon('heroicon-o-identification')
                ->placeholder('Belum ada nomor')
                ->searchable(isIndividual: true)
                ->sortable()
                ->copyable()
                ->copyMessage('Nomor keluarga disalin')
                ->weight('medium'),

            TextColumn::make('nama_keluarga')
                ->label('Nama Keluarga')
                ->icon('heroicon-o-user-group')
                ->placeholder('-')
                ->searchable(isIndividual: true)
                ->sortable()
                ->weight('bold')
                ->wrap(),

            TextColumn::make('alamat')
                ->label('Alamat')
                ->icon('heroicon-o-map-pin')
                ->placeholder('Belum ada alamat')
                ->limit(40)
                ->tooltip(fn ($record) => $record->alamat)
                ->searchable(isIndividual: true)
                ->wrap(),

            TextColumn::make('no_hp')
                ->label('No. HP')
                ->icon('heroicon-o-phone')
                ->placeholder('Belum ada nomor HP')
                ->searchable(isIndividual: true)
                ->copyable()
                ->toggleable(),

            IconColumn::make('aktif')
                ->label('Status')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger')
                ->sortable(),
        ])
        ->filters([
            TernaryFilter::make('aktif')
                ->label('Status Keluarga')
                ->placeholder('Semua Status')
                ->trueLabel('Aktif')
                ->falseLabel('Tidak Aktif'),
        ])
        ->recordActions([
            EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->modalWidth('2xl'),

            DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation(),
        ])
        ->defaultSort('nama_keluarga')
        ->striped()
        ->emptyStateHeading('Belum Ada Data Keluarga')
        ->emptyStateDescription(
            'Silakan tambahkan data keluarga untuk mulai mengelola data jemaat.'
        )
        ->emptyStateIcon('heroicon-o-user-group');
    }
}
