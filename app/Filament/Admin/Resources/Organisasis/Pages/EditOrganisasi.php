<?php

namespace App\Filament\Admin\Resources\Organisasis\Pages;

use App\Filament\Admin\Resources\Organisasis\OrganisasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrganisasi extends EditRecord
{
    protected static string $resource = OrganisasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
