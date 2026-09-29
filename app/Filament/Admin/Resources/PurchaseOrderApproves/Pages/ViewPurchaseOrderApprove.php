<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Pages;

use App\Filament\Admin\Resources\PurchaseOrderApproves\PurchaseOrderApproveResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchaseOrderApprove extends ViewRecord
{
    protected static string $resource = PurchaseOrderApproveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
