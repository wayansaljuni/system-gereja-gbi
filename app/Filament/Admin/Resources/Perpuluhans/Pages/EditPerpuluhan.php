<?php

namespace App\Filament\Admin\Resources\Perpuluhans\Pages;

use App\Filament\Admin\Resources\Perpuluhans\PerpuluhanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPerpuluhan extends EditRecord
{
    protected static string $resource = PerpuluhanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
