<?php

namespace App\Filament\Widgets;

use App\Models\Jemaat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JemaatStats extends StatsOverviewWidget
{
    protected int | array | null $columns = 5;

    protected function getStats(): array
    {
        $total = Jemaat::count();
        $aktif = Jemaat::where('aktif', true)->count();
        $tidakAktif = Jemaat::where('aktif', false)->count();
        $lakiLaki = Jemaat::where('jenis_kelamin', 'L')->count();
        $perempuan = Jemaat::where('jenis_kelamin', 'P')->count();
        $persentaseAktif = $total > 0
            ? round(($aktif / $total) * 100, 1)
            : 0;
        return [
            Stat::make('Total Jemaat',number_format($total))
                ->description('Seluruh jemaat terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->chart([5, 7, 6, 8, 7, 9, 10])
                ->color('primary')
                ->url('/admin/jemaats'),

            Stat::make('Jemaat Aktif',number_format($aktif))
                ->description("{$persentaseAktif}% dari seluruh jemaat")
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([6, 7, 8, 7, 9, 10, 10])
                ->color('success'),

            Stat::make('Laki-laki',number_format($lakiLaki))
                ->description('Jemaat laki-laki')
                ->descriptionIcon('heroicon-m-user')
                ->chart([4, 5, 4, 6, 5, 7, 6])
                ->color('info'),

            Stat::make('Perempuan',number_format($perempuan))
                ->description('Jemaat perempuan')
                ->descriptionIcon('heroicon-m-user')
                ->chart([5, 6, 5, 7, 6, 8, 7])
                ->color('warning'),

            Stat::make('Tidak Aktif',number_format($tidakAktif))
                ->description('Jemaat yang tidak aktif')
                ->descriptionIcon('heroicon-m-x-circle')
                ->chart([4, 3, 4, 2, 3, 2, 1])
                ->color('danger'),

        ];
    }
}