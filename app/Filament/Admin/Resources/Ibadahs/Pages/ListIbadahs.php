<?php

namespace App\Filament\Admin\Resources\Ibadahs\Pages;

use App\Filament\Admin\Resources\Ibadahs\IbadahResource;
// use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIbadahs extends ListRecords
{
    protected static string $resource = IbadahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
