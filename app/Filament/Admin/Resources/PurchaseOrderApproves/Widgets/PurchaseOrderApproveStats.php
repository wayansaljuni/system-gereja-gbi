<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Widgets;

use App\Filament\Admin\Resources\PurchaseOrderApproves\PurchaseOrderApproveResource;
use App\Models\Hpo;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PurchaseOrderApproveStats extends StatsOverviewWidget
{
    
    // protected int|string|array $columnSpan = 10;
    public static function canView(): bool
    {
        return auth()->user()?->hasAnyRoleCustom([
            'super_admin',
            'approvepo',
        ]) ?? false;
    }
    protected function getStats(): array
    {
        $totalPerluApproval = Hpo::query()
            ->PerluApprovalPO(auth()->user()?->kd_cab)->count();

        return [
            Stat::make('Purchase Order Need Approval', $totalPerluApproval)
                ->description('Last 180 days')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(PurchaseOrderApproveResource::getUrl('index')),
        ];                
    }
}
