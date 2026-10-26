<?php

namespace App\Filament\Admin\Resources\Jemaats\Pages;

use App\Filament\Admin\Resources\Jemaats\JemaatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditJemaat extends EditRecord
{
    protected static string $resource = JemaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
