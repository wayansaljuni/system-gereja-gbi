<?php

namespace App\Filament\Admin\Resources\Absensis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AbsensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ibadah.nama')
                    ->label('Nama Ibadah')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->icon('heroicon-o-building-library')
                    ->iconColor('primary')
                    ->weight('bold')
                    ->description(fn ($record) => 'Kategori Ibadah: ' . $record->kategori),

                TextColumn::make('tanggal')
                    ->label('Tanggal Ibadah')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar-days')
                    ->color('gray'),

                // TextColumn::make('jam')
                //     ->label('Jam')
                //     ->time('H:i')
                //     ->sortable()
                //     ->placeholder('—')
                //     ->icon('heroicon-o-clock'),

                TextColumn::make('total_hadir')
                    ->label('Total Jemaat')
                    ->state(fn ($record): int =>
                        $record->details()->count()
                    )
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-users')
                    ->alignCenter()
                    ->sortable(
                        query: fn ($query, string $direction) =>
                            $query->withCount('details')
                                ->orderBy('details_count', $direction)
                    ),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye'),

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),
            ])
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make()
            //             ->label('Hapus Terpilih'),
            //     ]),
            // ])
            ;
    }
}
