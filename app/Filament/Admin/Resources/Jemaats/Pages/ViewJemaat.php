<?php

namespace App\Filament\Admin\Resources\Jemaats\Pages;

use App\Filament\Admin\Resources\Jemaats\JemaatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJemaat extends ViewRecord
{
    protected static string $resource = JemaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
