<?php

namespace App\Filament\Admin\Resources\TransferAkuns\Pages;

use App\Filament\Admin\Resources\TransferAkuns\TransferAkunResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTransferAkun extends ViewRecord
{
    protected static string $resource = TransferAkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
