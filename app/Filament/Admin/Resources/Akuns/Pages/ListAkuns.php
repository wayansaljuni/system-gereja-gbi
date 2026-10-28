<?php

namespace App\Filament\Admin\Resources\Akuns\Pages;

use App\Filament\Admin\Resources\Akuns\AkunResource;
use Filament\Resources\Pages\ListRecords;

class ListAkuns extends ListRecords
{
    protected static string $resource = AkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
