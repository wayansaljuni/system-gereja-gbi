<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Pages;

use App\Filament\Admin\Resources\SpkTeknisis\SpkTeknisiResource;
use Filament\Resources\Pages\ListRecords;

class ListSpkTeknisis extends ListRecords
{
    protected static string $resource = SpkTeknisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
