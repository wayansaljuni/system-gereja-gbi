<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Spatie\Activitylog\Models\Activity;

class RecentActivityWidget extends Widget
{
    protected static ?int $sort = 10;
    protected string $view = 'filament.admin.widgets.recent-activity-widget';
    protected int|string|array $columnSpan = 'full';

    public function getActivities()
    {
        return Activity::query()
            ->with('causer')
            ->latest('created_at')
            ->limit(10)
            ->get();
    }
}