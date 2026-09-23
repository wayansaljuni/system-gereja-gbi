<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Pages;

use App\Filament\Admin\Resources\ActivityLogs\ActivityLogsResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditActivityLogs extends EditRecord
{
    protected static string $resource = ActivityLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
