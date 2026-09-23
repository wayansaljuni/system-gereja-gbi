<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Pages;

use App\Filament\Admin\Resources\ActivityLogs\ActivityLogsResource;
use Filament\Resources\Pages\ViewRecord;

class ViewActivityLogs extends ViewRecord
{
    protected static string $resource = ActivityLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
