<?php

namespace App\Filament\Admin\Resources\PurchaseRequestApproves\Pages;

use App\Filament\Admin\Resources\PurchaseRequestApproves\PurchaseRequestApproveResource;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseRequestApprove extends EditRecord
{
    protected static string $resource = PurchaseRequestApproveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
