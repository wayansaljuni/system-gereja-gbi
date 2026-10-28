<?php

namespace App\Filament\Admin\Resources\KategoriKeuangans\Tables;

use App\Models\KategoriKeuangan;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class KategoriKeuangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode')
                    // ->icon(Heroicon::OutlinedTag)
                    // ->iconColor('gray')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => '　　' . $state)
                    ,

                TextColumn::make('nama')
                    ->label('Nama Kategori')
                    ->icon(Heroicon::OutlinedRectangleStack)
                    ->iconColor('primary')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ,

                TextColumn::make('tipe')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'pemasukan' => 'Pemasukan',
                            'pengeluaran' => 'Pengeluaran',
                            default => ucfirst($state ?? '-'),
                        }
                    )
                    ->color(
                        fn (?string $state): string => match ($state) {
                            'pemasukan' => 'success',
                            'pengeluaran' => 'danger',
                            default => 'gray',
                        }
                    )
                    ->icon(
                        fn (?string $state) => match ($state) {
                            'pemasukan' => Heroicon::OutlinedArrowTrendingUp,
                            'pengeluaran' => Heroicon::OutlinedArrowTrendingDown,
                            default => Heroicon::OutlinedArrowsRightLeft,
                        }
                    )
                    ->sortable(),

                TextColumn::make('akunDefault.nama')
                    ->label('Akun Default')
                    ->icon(Heroicon::OutlinedWallet)
                    ->iconColor('gray')
                    ->description(
                        fn (KategoriKeuangan $record): ?string =>
                            $record->akunDefault?->kode
                    )
                    ->placeholder('-')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ,

                IconColumn::make('bisa_detail_jemaat')
                    ->label('Detail Jemaat')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedMinusCircle)
                    ->trueColor('success')
                    ->falseColor('gray')
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

            // Group berdasarkan tipe, kemudian urutkan nama kategori.
            ->groups([
                Group::make('tipe')
                    ->label('Tipe Transaksi')
                    ->getTitleFromRecordUsing(
                        fn (KategoriKeuangan $record): string =>
                            match ($record->tipe) {
                                'pemasukan' => 'Pemasukan',
                                'pengeluaran' => 'Pengeluaran',
                                default => ucfirst($record->tipe),
                            }
                    )
                    ->collapsible(),
            ])
            ->defaultGroup('tipe')
            ->defaultSort('nama')

            ->filters([
                SelectFilter::make('tipe')
                    ->label('Tipe Transaksi')
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                    ]),

                TernaryFilter::make('bisa_detail_jemaat')
                    ->label('Detail Per Jemaat')
                    ->placeholder('Semua')
                    ->trueLabel('Ya')
                    ->falseLabel('Tidak'),

                TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])

            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Kategori')
                    ->icon(Heroicon::OutlinedPlus)
                    ->modalHeading('Tambah Kategori Keuangan')
                    ->modalDescription(
                        'Atur kategori pemasukan atau pengeluaran gereja.'
                    )
                    ->modalWidth('3xl')
                    ->createAnother(false),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedPencil)
                    ->tooltip('Edit Kategori')
                    ->modalHeading('Edit Kategori Keuangan')
                    ->modalWidth('3xl'),

                DeleteAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Hapus Kategori'),
            ]);
    }
}