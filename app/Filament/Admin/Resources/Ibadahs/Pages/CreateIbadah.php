<?php

namespace App\Filament\Admin\Resources\Ibadahs\Pages;

use App\Filament\Admin\Resources\Ibadahs\IbadahResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;

class CreateIbadah extends CreateRecord
{
    protected static string $resource = IbadahResource::class;
    // Setelah berhasil Create, kembali ke List
    protected function getRedirectUrl(): string
    {
        return IbadahResource::getUrl('index');
    }

    // Hilangkan tombol Create & Create another
    // protected function getCreateAnotherFormAction(): CreateAction
    // {
    //     return parent::getCreateAnotherFormAction()
    //         ->hidden();
    // }
}
