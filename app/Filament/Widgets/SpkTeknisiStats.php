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
        $totalSpk = Spk::aktif()->whereHas('teknisi')->count();
        $totalSpkBulanIni = Spk::bulanIni()->whereHas('teknisi')->count();
        $sudahDikerjakanTeknisi = Spk::DikerjakanBulanIni()
            ->whereHas('teknisi')->count();
        $totalBelumDikerjakan = $totalSpkBulanIni-$sudahDikerjakanTeknisi;

        return [
            Stat::make('Total SPK Belum Dikerjakan', $totalSpk)
                ->description('Click untuk melihat SPK sudah ditugaskan')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('warning')
                ->url(SpkTeknisiResource::getUrl('index')),
            Stat::make('Total SPK Bulan Ini', $totalSpkBulanIni)
                ->description(
                    'Periode ' . now()->translatedFormat('F Y')
                )
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),
            Stat::make('Total SPK Sudah Dikerjakan', $sudahDikerjakanTeknisi)
                ->description(
                    'Periode ' . now()->translatedFormat('F Y')
                )
                ->icon('heroicon-o-clipboard-document-check')
                ->color('success'),
            Stat::make('Total SPK Belum Dikerjakan', $totalBelumDikerjakan)
                ->description(
                    'Periode ' . now()->translatedFormat('F Y')
                )
                ->icon('heroicon-o-clock')
                ->color('warning'),
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