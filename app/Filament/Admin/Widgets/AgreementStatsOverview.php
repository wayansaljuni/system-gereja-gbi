<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\Agreements\AgreementResource;
use App\Filament\Admin\Resources\AgreementTypes\AgreementTypeResource;
use App\Helpers\RoleHelper;
use App\Models\Agreement;
use App\Models\AgreementType;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgreementStatsOverview extends BaseWidget
{
    protected static ?int $sort = 4;

    public static function canView(): bool
    {
        return RoleHelper::isSuperadminOrLegal() ?? false;
    }    

    protected function getStats(): array
    {
        $totalTypes = AgreementType::count();
        $activeTypes = AgreementType::where('is_active', true)->count();
        $totalAgreements = Agreement::count();
        $activeAgreements = Agreement::where('status', 'active')->count();

        return [
            Stat::make('Agreement Types', $totalTypes)
                ->description($activeTypes . ' Active')
                ->descriptionIcon(Heroicon::OutlinedTag)
                ->color('primary')
                ->icon(Heroicon::OutlinedTag)
                ->url(AgreementTypeResource::getUrl('index')),

            Stat::make('Total Agreement', $totalAgreements)
                ->description('ALL Agreements')
                ->descriptionIcon(Heroicon::OutlinedDocumentText)
                ->color('info')
                ->icon(Heroicon::OutlinedDocumentText)
                ->url(AgreementResource::getUrl('index')),

            Stat::make('Total Agreement Active', $activeAgreements)
                ->description('Agreement Active')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->url(AgreementResource::getUrl('index')),
                
        ];
    }
}