<?php

namespace App\Filament\Admin\Resources\Akuns\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AkunsTable
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
                    ->label('Nama Akun')
                    ->icon(Heroicon::OutlinedWallet)
                    ->iconColor('primary')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'kas' => 'Kas',
                            'bank' => 'Bank',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'kas' => 'success',
                            'bank' => 'info',
                            default => 'gray',
                        }
                    )
                    ->icon(
                        fn (string $state) => match ($state) {
                            'kas' => Heroicon::OutlinedBanknotes,
                            'bank' => Heroicon::OutlinedBuildingLibrary,
                            default => Heroicon::OutlinedWallet,
                        }
                    )
                    ->sortable(),

                TextColumn::make('nama_bank')
                    ->label('Bank')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('no_rekening')
                    ->label('No. Rekening')
                    ->searchable(isIndividual: true)
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('saldo_awal')
                    ->label('Saldo Awal')
                    ->alignEnd()
                    ->formatStateUsing(
                        fn ($state): string => 'Rp ' . number_format(
                            (float) $state,
                            2,
                            ',',
                            '.'
                        )
                    )
                    ->sortable(),

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
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis')
                    ->label('Jenis Akun')
                    ->options([
                        'kas' => 'Kas',
                        'bank' => 'Bank',
                    ]),

                TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Akun')
                    ->icon(Heroicon::OutlinedPlus)
                    ->modalHeading('Tambah Akun Kas & Bank')
                    ->modalDescription(
                        'Daftarkan akun kas atau rekening bank gereja.'
                    )
                    ->modalWidth('3xl')
                    ->createAnother(false),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedPencil)
                    ->tooltip('Edit Akun')
                    ->modalHeading('Edit Akun Kas & Bank')
                    ->modalWidth('3xl'),

                DeleteAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Hapus Akun'),
            ])
            ->defaultSort('kode');
    }
}
