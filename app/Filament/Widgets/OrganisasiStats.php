<?php

namespace App\Filament\Widgets;

use App\Models\Organisasi;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrganisasiStats extends StatsOverviewWidget
{
    protected int | array | null $columns = 5;

    protected function getStats(): array
    {
        $total = Organisasi::count();
        $aktif = Organisasi::where('aktif', true)->count();
        $tidakAktif = Organisasi::where('aktif', false)->count();
        $persentaseAktif = $total > 0
            ? round(($aktif / $total) * 100, 1)
            : 0;
        return [
            Stat::make('Total Organisasi',number_format($total))
                ->description('Seluruh organisasi terdaftar')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->chart([2, 4, 3, 6, 5, 8, 7])
                ->color('primary')
                ->url('/admin/organisasis'),

            Stat::make('Organisasi Aktif',number_format($aktif))
                ->description(
                    "{$persentaseAktif}% dari seluruh organisasi"
                )
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([3, 5, 4, 7, 6, 8, 9])
                ->color('success'),

            Stat::make(
                'Tidak Aktif',
                number_format($tidakAktif)
            )
                ->description('Organisasi yang tidak aktif')
                ->descriptionIcon('heroicon-m-x-circle')
                ->chart([8, 6, 7, 4, 5, 3, 2])
                ->color('danger'),

        ];
    }
}
