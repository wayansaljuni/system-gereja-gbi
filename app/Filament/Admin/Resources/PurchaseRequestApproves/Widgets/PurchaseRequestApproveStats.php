<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\PurchaseRequestApproves\PurchaseRequestApproveResource;
use App\Models\Hpr;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PurchaseRequestApproveStats extends StatsOverviewWidget
{
    // public static function canView(): bool
    // {
    //     return auth()->user()?->hasAnyRoleCustom([
    //         'super_admin',
    //         'approvalpr',
    //     ]) ?? false;
    // }
    protected function getStats(): array
    {
        $total = Hpr::query()
        ->where(function ($query) {
            $query
            ->where('approve', '')
            ->orWhere(function ($query) {
                $query
                    ->where('approve', 'Y')
                    ->where('approve1', '');
                });
            })
            ->whereDate('tgl', '>=', now()->subDays(90))
            ->count();

        return [
            Stat::make('Total Belum Approval', $total)
                ->description('Purchase Request menunggu approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->url(PurchaseRequestApproveResource::getUrl('index')),
        ];
    }
}