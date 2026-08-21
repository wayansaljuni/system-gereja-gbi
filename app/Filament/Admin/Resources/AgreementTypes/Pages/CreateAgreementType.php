<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Pages;

use App\Filament\Admin\Resources\AgreementTypes\AgreementTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAgreementType extends CreateRecord
{
    protected static string $resource = AgreementTypeResource::class;
}
