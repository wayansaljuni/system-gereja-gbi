<?php

namespace App\Filament\Admin\Resources\Ibadahs\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class IbadahsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode')
                    ->icon(Heroicon::OutlinedTag)
                    ->iconColor('gray')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama Ibadah')
                    ->icon(Heroicon::OutlinedBuildingLibrary)
                    ->iconColor('primary')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->icon(Heroicon::AcademicCap)
                    ->iconColor('gray')
                    ->badge()
                    ->color('gray')
                    ->searchable(isIndividual: true )
                    ->sortable()
                    ->placeholder('-'),

                IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->iconColor('gray')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->icon(Heroicon::OutlinedClock)
                    ->iconColor('gray')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])

            ->headerActions([
                CreateAction::make()
                    ->label('New Ibadah')
                    ->icon(Heroicon::OutlinedPlus)
                    ->modalHeading('Tambah Ibadah')
                    ->modalDescription(
                        'Tambahkan jenis ibadah baru ke dalam master data.'
                    )
                    ->modalWidth('3xl')
                    ->createAnother(false),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedPencil)
                    ->tooltip('Edit Ibadah')
                    ->modalHeading('Edit Ibadah')
                    ->modalWidth('3xl'),

                DeleteAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Hapus Ibadah'),
            ])

            ->defaultSort('nama', 'desc');     
    }
}
