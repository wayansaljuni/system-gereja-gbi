<?php

namespace App\Filament\Admin\Resources\AgreementReminders\Pages;

use App\Filament\Admin\Resources\AgreementReminders\AgreementReminderResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAgreementReminder extends ViewRecord
{
    protected static string $resource = AgreementReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
