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
        $totalPerluApproval = Hpr::query()
            ->perluApproval(auth()->user()?->kd_cab)->count();

        return [
            Stat::make('Purchase Request Need Approval', $totalPerluApproval)
                ->description('Last 90 days')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(PurchaseRequestApproveResource::getUrl('index')),
        ];                
    }
}