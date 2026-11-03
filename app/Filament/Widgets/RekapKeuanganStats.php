<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class RekapKeuanganStats extends StatsOverviewWidget
{
    public ?Model $record = null;
    protected ?string $pollingInterval = '3s';

    protected function getStats(): array
    {
        if (! $this->record) {
            return [];
        }

        $header = $this->record;

        $query = $header->transaksiKeuangan()
            ->where('metode_pembayaran', 'tunai');

        $masuk = (clone $query)
            ->whereHas(
                'kategoriKeuangan',
                fn ($q) => $q->where('tipe', 'pemasukan')
            )
            ->sum('jumlah');

        $keluar = (clone $query)
            ->whereHas(
                'kategoriKeuangan',
                fn ($q) => $q->where('tipe', 'pengeluaran')
            )
            ->sum('jumlah');

        $saldo = $masuk - $keluar;

        return [
            Stat::make(
                'Uang Tunai Masuk',
                'Rp ' . number_format($masuk, 2, ',', '.')
            )
                ->description('Total pemasukan tunai')
                ->descriptionIcon('heroicon-m-arrow-down-left')
                ->color('success'),

            Stat::make(
                'Uang Tunai Keluar',
                'Rp ' . number_format($keluar, 2, ',', '.')
            )
                ->description('Total pengeluaran tunai')
                ->descriptionIcon('heroicon-m-arrow-up-right')
                ->color('danger'),

            Stat::make(
                'Saldo Tunai',
                'Rp ' . number_format($saldo, 2, ',', '.')
            )
                ->description('Pemasukan dikurangi pengeluaran')
                ->descriptionIcon('heroicon-m-wallet')
                ->color($saldo >= 0 ? 'success' : 'danger'),
        ];
    }
}
