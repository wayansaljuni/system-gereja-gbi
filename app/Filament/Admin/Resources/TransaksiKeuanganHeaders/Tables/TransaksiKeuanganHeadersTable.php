<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

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
                TextColumn::make('approve')
                        ->label('Status')
                        ->badge()
                        ->formatStateUsing(
                            fn ($state) => $state ? 'Disetujui' : 'Menunggu'
                        )
                        ->color(
                            fn ($state) => $state ? 'success' : 'warning'
                        )
                        ->icon(
                            fn ($state) => $state
                                ? 'heroicon-o-check-circle'
                                : 'heroicon-o-clock'
                        )
                        ->sortable(),
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
                Action::make('approve')
                    ->label('Approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Transaksi Keuangan')
                    ->modalDescription(
                        'Setelah disetujui, transaksi tidak dapat diedit lagi. Lanjutkan?'
                    )
                    ->modalSubmitActionLabel('Ya, Approve')
                    ->visible(fn ($record): bool => ! $record->approve)
                    ->action(function ($record): void {
                        DB::transaction(function () use ($record): void {
                            $transaksi = $record->newQuery()
                                ->whereKey($record->getKey())
                                ->lockForUpdate()
                                ->firstOrFail();

                            if ($transaksi->approve) {
                                return;
                            }

                            $transaksi->update([
                                'approve' => true,
                            ]);
                        });

                        Notification::make()
                            ->title('Transaksi berhasil di-approve')
                            ->success()
                            ->send();
                    }),                
                // ViewAction::make(),
                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->tooltip('Edit Transaksi Keuangan')
                    ->visible(fn ($record): bool => ! $record->approve),
                Action::make('print')
                    ->label('')
                    ->tooltip('Cetak Transaksi Keuangan')
                    ->icon(Heroicon::OutlinedPrinter)
                    ->color('gray')
                    ->url(
                        fn ($record): string => route(
                            'transaksi-keuangan-header.print',
                            ['transaksiKeuanganHeader' => $record->id]
                        )
                    )
                    ->openUrlInNewTab(),
            ]);        
    }

}
