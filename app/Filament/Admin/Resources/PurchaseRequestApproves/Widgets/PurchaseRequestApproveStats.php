<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\PurchaseRequestApproves\PurchaseRequestApproveResource;
use App\Models\Hpr;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PurchaseRequestApproveStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->hasAnyRoleCustom([
            'super_admin',
            'approvepr',
            'approvepr2',
        ]) ?? false;
    }
    protected function getStats(): array
    {
        $user = auth()->user();

        $query = Hpr::query()
            ->where(function ($query) {
                $query
                    ->where('approve', '')
                    ->orWhere(function ($query) {
                        $query
                            ->where('approve', 'Y')
                            ->where('approve1', '');
                    });
            })
            ->whereDate('tgl', '>=', now()->subDays(90));

        if (
            ! $user->hasRole('super_admin')
            && $user->kd_cab !== '00'
        ) {
            $query->where('kd_cab', $user->kd_cab);
        }

        $total = $query->count();

        return [
            Stat::make('Purchase Request Need Approval', $total)
                ->description('Last 90 days')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(PurchaseRequestApproveResource::getUrl('index')),
        ];                
    }
}