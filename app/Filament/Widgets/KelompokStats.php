<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KelompokStats extends StatsOverviewWidget
{
    protected int | array | null $columns = 5;
   
    protected function getStats(): array
    {
        $total = Kelompok::count();
        $aktif = Kelompok::where('aktif', true)->count();
        $tidakAktif = Kelompok::where('aktif', false)->count();
        return [
            Stat::make('Total KPW', number_format($total))
                ->description('Seluruh data KPW')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->url('/admin/kelompoks'),

            Stat::make('KPW Aktif', number_format($aktif))
                ->description(
                    $total > 0
                        ? round(($aktif / $total) * 100, 1)
                            . '% dari total KPW'
                        : 'Belum ada data KPW'
                )
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('KPW Tidak Aktif', number_format($tidakAktif))
                ->description(
                    $total > 0
                        ? round(($tidakAktif / $total) * 100, 1)
                            . '% dari total KPW'
                        : 'Belum ada data KPW'
                )
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ]; 
    }
}
