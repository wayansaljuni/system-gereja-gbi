<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Pages;

use App\Filament\Admin\Resources\PurchaseOrderApproves\PurchaseOrderApproveResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseOrderApprove extends EditRecord
{
    protected static string $resource = PurchaseOrderApproveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
