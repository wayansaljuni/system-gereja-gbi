<?php

namespace App\Filament\Admin\Resources\Ibadahs\Pages;

use App\Filament\Admin\Resources\Ibadahs\IbadahResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditIbadah extends EditRecord
{
    protected static string $resource = IbadahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
