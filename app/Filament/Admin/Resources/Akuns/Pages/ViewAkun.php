<?php

namespace App\Filament\Admin\Resources\Akuns\Pages;

use App\Filament\Admin\Resources\Akuns\AkunResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAkun extends ViewRecord
{
    protected static string $resource = AkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
