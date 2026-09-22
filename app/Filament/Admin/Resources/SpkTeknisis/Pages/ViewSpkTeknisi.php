<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Pages;

use App\Filament\Admin\Resources\SpkTeknisis\SpkTeknisiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSpkTeknisi extends ViewRecord
{
    protected static string $resource = SpkTeknisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
