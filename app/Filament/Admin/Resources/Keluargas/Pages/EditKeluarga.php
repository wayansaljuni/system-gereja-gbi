<?php

namespace App\Filament\Admin\Resources\Keluargas\Pages;

use App\Filament\Admin\Resources\Keluargas\KeluargaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditKeluarga extends EditRecord
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
