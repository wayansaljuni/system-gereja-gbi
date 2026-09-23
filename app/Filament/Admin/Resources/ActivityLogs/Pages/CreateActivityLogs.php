<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Pages;

use App\Filament\Admin\Resources\ActivityLogs\ActivityLogsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateActivityLogs extends CreateRecord
{
    protected static string $resource = ActivityLogsResource::class;
}
