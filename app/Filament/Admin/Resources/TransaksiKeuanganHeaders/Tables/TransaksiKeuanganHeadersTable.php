<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Tables;

use Filament\Actions\Action;
// use Filament\Tables\Actions\Action as TableAction;
use Filament\Actions\EditAction;
// use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransaksiKeuanganHeadersTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query
                ->with('ibadah')
                ->withSum([
                    'details as total_pemasukan' => fn ($q) =>
                        $q->whereHas(
                            'kategoriKeuangan',
                            fn ($kategori) => $kategori
                                ->where('tipe', 'pemasukan')
                        ),
                ], 'jumlah')
                ->withSum([
                    'details as total_pengeluaran' => fn ($q) =>
                        $q->whereHas(
                            'kategoriKeuangan',
                            fn ($kategori) => $kategori
                                ->where('tipe', 'pengeluaran')
                        ),
                ], 'jumlah')
            )
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('ibadah.nama')
                    ->label('Ibadah')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(40)
                    ->placeholder('-'),

                TextColumn::make('total_pemasukan')
                    ->label('Total Pemasukan')
                    ->money('IDR', locale: 'id')
                    ->default(0)
                    ->sortable(),

                TextColumn::make('total_pengeluaran')
                    ->label('Total Pengeluaran')
                    ->money('IDR', locale: 'id')
                    ->default(0)
                    ->sortable(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->recordActions([
                Action::make('print')
                    ->label('Print')
                    ->icon(Heroicon::OutlinedPrinter)
                    ->color('gray')
                    ->url(
                        fn ($record): string => route(
                            'transaksi-keuangan-header.print',
                            ['transaksiKeuanganHeader' => $record->id]
                        )
                    )
                    ->openUrlInNewTab(),
                // ViewAction::make(),
                EditAction::make(),
            ]);        
    }

}
