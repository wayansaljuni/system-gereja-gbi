<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Pages;

use App\Filament\Admin\Resources\PurchaseOrderApproves\PurchaseOrderApproveResource;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseOrderApproves extends ListRecords
{
    protected static string $resource = PurchaseOrderApproveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
