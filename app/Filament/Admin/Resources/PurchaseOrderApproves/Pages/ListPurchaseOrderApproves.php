<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Pages;

use App\Filament\Admin\Resources\PurchaseOrderApproves\PurchaseOrderApproveResource;
use App\Filament\Admin\Resources\PurchaseOrderApproves\Widgets\PurchaseOrderApproveStats;
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
    protected function getHeaderWidgets(): array
    {
        return [
            PurchaseOrderApproveStats::class,
        ];
    }
}
