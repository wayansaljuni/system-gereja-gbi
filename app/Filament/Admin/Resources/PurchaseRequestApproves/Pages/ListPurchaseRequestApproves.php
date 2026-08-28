<?php

namespace App\Filament\Admin\Resources\PurchaseRequestApproves\Pages;

use App\Filament\Admin\Resources\PurchaseRequestApproves\PurchaseRequestApproveResource;
use App\Filament\Admin\Widgets\PurchaseRequestApproveStats;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseRequestApproves extends ListRecords
{
    protected static string $resource = PurchaseRequestApproveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            PurchaseRequestApproveStats::class,
        ];
    }
}
