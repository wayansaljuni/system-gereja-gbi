<?php

namespace App\Filament\Admin\Resources\Perpuluhans\Pages;

use App\Filament\Admin\Resources\Perpuluhans\PerpuluhanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPerpuluhan extends ViewRecord
{
    protected static string $resource = PerpuluhanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
