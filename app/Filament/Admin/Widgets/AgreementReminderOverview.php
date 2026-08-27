<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\AgreementReminders\AgreementReminderResource;
use App\Models\AgreementReminder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Icons\Heroicon;

class AgreementReminderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAgreementReminders = AgreementReminder::whereBetween('remind_at', [now()->subDays(30)->startOfDay(),
            now()->addDays(30)->endOfDay(),])->count();

        return [

            Stat::make('Total Agreement Reminders', $totalAgreementReminders)
                ->description('Agreement Reminders at 30 days')
                ->descriptionIcon(Heroicon::BellAlert)
                ->color('info')
                ->icon(Heroicon::BellSnooze)
                ->url(AgreementReminderResource::getUrl('index')),

        ];
    }
}