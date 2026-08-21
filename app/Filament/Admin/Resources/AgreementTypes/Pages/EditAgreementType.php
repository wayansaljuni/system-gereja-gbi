<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Pages;

use App\Filament\Admin\Resources\AgreementTypes\AgreementTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAgreementType extends EditRecord
{
    protected static string $resource = AgreementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
