<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Agreement;
use App\Models\AgreementType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Icons\Heroicon;

class AgreementStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTypes = AgreementType::count();
        $activeTypes = AgreementType::where('is_active', true)->count();
        $totalAgreements = Agreement::count();
        $activeAgreements = Agreement::where('status', 'active')->count();
        $expiringAgreements = Agreement::where('status', 'expiring')->count();

        return [
            Stat::make('Agreement Types', $totalTypes)
                ->description($activeTypes . ' Active')
                ->descriptionIcon(Heroicon::OutlinedTag)
                ->color('primary')
                ->icon(Heroicon::OutlinedTag),

            Stat::make('Total Agreement', $totalAgreements)
                ->description('ALL Agreements')
                ->descriptionIcon(Heroicon::OutlinedDocumentText)
                ->color('info')
                ->icon(Heroicon::OutlinedDocumentText),

            Stat::make('Total Agreement Active', $activeAgreements)
                ->description('Agreement Active')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->icon(Heroicon::OutlinedCheckCircle),

            // Stat::make('Akan Berakhir', $expiringAgreements)
            //     ->description('Perlu ditinjau segera')
            //     ->descriptionIcon(Heroicon::OutlinedExclamationTriangle)
            //     ->color('warning')
            //     ->icon(Heroicon::OutlinedExclamationTriangle),
        ];
    }
}