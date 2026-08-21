<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Pages;

use App\Filament\Admin\Resources\AgreementTypes\AgreementTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAgreementType extends ViewRecord
{
    protected static string $resource = AgreementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
