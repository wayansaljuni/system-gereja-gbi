<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\AgreementReminders\AgreementReminderResource;
use App\Models\AgreementReminder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgreementReminderOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $baseQuery = AgreementReminder::query()
            ->whereBetween('remind_at', [
                now()->subDays(30)->startOfDay(),
                now()->addDays(30)->endOfDay(),
            ]);

        $total = (clone $baseQuery)->count();
        $overdue = (clone $baseQuery)->whereDate('remind_at', '<', now())->where('is_sent', false)->count();
        $today = (clone $baseQuery)->whereDate('remind_at', now())->count();
        $sent = (clone $baseQuery)->where('is_sent', true)->count();

        // Trend 7 hari terakhir untuk sparkline chart
        $trend = collect(range(6, 0))->map(
            fn ($daysAgo) => AgreementReminder::query()
                ->whereDate('remind_at', now()->subDays($daysAgo))
                ->count()
        )->toArray();

        return [
            Stat::make('Total Reminders', $total)
                ->description('Within -30 to +30 days')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->chart($trend)
                ->color('primary')
                ->icon('heroicon-o-bell-alert')
                ->url(AgreementReminderResource::getUrl('index')),

            Stat::make('Overdue', $overdue)
                ->description($overdue > 0 ? 'Needs attention' : 'All caught up')
                ->descriptionIcon($overdue > 0 ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-check-circle')
                ->color($overdue > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-calendar')
                ->url(AgreementReminderResource::getUrl('index')),

            Stat::make('Sent', "{$sent} / {$total}")
                ->description($total > 0 ? round(($sent / max($total, 1)) * 100) . '% completion rate' : 'No data')
                ->descriptionIcon('heroicon-o-paper-airplane')
                ->color('success')
                ->icon('heroicon-o-envelope')
                ->url(AgreementReminderResource::getUrl('index')),
        ];
    }
}