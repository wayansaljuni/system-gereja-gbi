<?php

namespace App\Filament\Admin\Resources\AgreementReminders\Pages;

use App\Filament\Admin\Resources\AgreementReminders\AgreementReminderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAgreementReminder extends EditRecord
{
    protected static string $resource = AgreementReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
