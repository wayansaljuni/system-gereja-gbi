<?php

namespace App\Filament\Widgets;

use App\Models\Keluarga;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KeluargaStats extends StatsOverviewWidget
{
    protected int | array | null $columns = 5;

    protected function getStats(): array
    {
        $total = Keluarga::count();
        $aktif = Keluarga::where('aktif', 1)->count();
        $tidakAktif = Keluarga::where('aktif', 0)->count();
        return [
            Stat::make('Total Keluarga', number_format($total))
                ->description('Seluruh data keluarga')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->url('/admin/keluargas'),

            Stat::make('Keluarga Aktif', number_format($aktif))
                ->description(
                    $total > 0
                        ? round(($aktif / $total) * 100, 1) . '% dari total keluarga'
                        : 'Belum ada data keluarga'
                )
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Keluarga Tidak Aktif', number_format($tidakAktif))
                ->description(
                    $total > 0
                        ? round(($tidakAktif / $total) * 100, 1) . '% dari total keluarga'
                        : 'Belum ada data keluarga'
                )
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
