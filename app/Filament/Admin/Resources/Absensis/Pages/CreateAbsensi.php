<?php

namespace App\Filament\Admin\Resources\Absensis\Pages;

use App\Filament\Admin\Resources\Absensis\AbsensiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = AbsensiResource::class;
       protected function getRedirectUrl(): string
    {
        return AbsensiResource::getUrl('index');
    }

    // Hilangkan tombol Create & Create another
    // protected function getCreateAnotherFormAction(): CreateAction
    // {
    //     return parent::getCreateAnotherFormAction()
    //         ->hidden();
    // }
}
