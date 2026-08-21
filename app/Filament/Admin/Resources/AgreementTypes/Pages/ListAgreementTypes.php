<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Pages;

use App\Filament\Admin\Resources\AgreementTypes\AgreementTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgreementTypes extends ListRecords
{
    protected static string $resource = AgreementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
