<?php

namespace App\Filament\Admin\Resources\AgreementReminders\Pages;

use App\Filament\Admin\Resources\AgreementReminders\AgreementReminderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgreementReminders extends ListRecords
{
    protected static string $resource = AgreementReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New Reminder'),
        ];
    }
}
