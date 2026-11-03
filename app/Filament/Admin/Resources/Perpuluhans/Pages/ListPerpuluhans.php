<?php

namespace App\Filament\Admin\Resources\Perpuluhans\Pages;

use App\Filament\Admin\Resources\Perpuluhans\PerpuluhanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPerpuluhans extends ListRecords
{
    protected static string $resource = PerpuluhanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
