<?php

namespace App\Filament\Admin\Resources\Ibadahs\Pages;

use App\Filament\Admin\Resources\Ibadahs\IbadahResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIbadah extends ViewRecord
{
    protected static string $resource = IbadahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
