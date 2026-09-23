<?php

namespace App\Filament\Widgets;

use App\Filament\Admin\Resources\SpkTeknisis\SpkTeknisiResource;
use App\Models\Spk;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SpkTeknisiStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->hasAnyRole([
            'superadmin',
            'teknisi',
        ]) ?? false;
    }

    protected function getStats(): array
    {
        $totalSpk = Spk::query()
            ->aktif()
            ->whereHas('teknisi')
            ->count();

        // $sudahAdaTeknisi = Spk::query()
        //     ->aktif()
        //     ->whereHas('teknisi')
        //     ->count();

        // $belumAdaTeknisi = Spk::query()
        //     ->aktif()
        //     ->whereDoesntHave('teknisi')
        //     ->count();

        // $totalTeknisi = Spk::query()
        //     ->aktif()
        //     ->withCount('teknisi')
        //     ->get()
        //     ->sum('teknisi_count');

        return [
            Stat::make('Total SPK Teknisi Progress ', $totalSpk)
                ->description('Click untuk melihat SPK sudah ditugaskan')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('primary')
                ->url(SpkTeknisiResource::getUrl('index')),
            // Stat::make('Sudah Ada Teknisi', $sudahAdaTeknisi)
            //     ->description('SPK sudah ditugaskan')
            //     ->icon('heroicon-o-user-group')
            //     ->color('success'),

            // Stat::make('Belum Ada Teknisi', $belumAdaTeknisi)
            //     ->description('SPK belum memiliki teknisi')
            //     ->icon('heroicon-o-exclamation-triangle')
            //     ->color('danger'),

            // Stat::make('Total Penugasan Teknisi', $totalTeknisi)
            //     ->description('Jumlah teknisi pada SPK aktif')
            //     ->icon('heroicon-o-users')
            //     ->color('info'),
        ];
    }
}