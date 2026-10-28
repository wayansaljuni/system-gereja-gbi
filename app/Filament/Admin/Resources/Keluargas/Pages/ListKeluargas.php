<?php

namespace App\Filament\Admin\Resources\Keluargas\Pages;

use App\Filament\Admin\Resources\Keluargas\KeluargaResource;
use App\Filament\Widgets\KeluargaStats;
use Filament\Resources\Pages\ListRecords;

class ListKeluargas extends ListRecords
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            KeluargaStats::class,
        ];
    }
    // protected function getHeaderWidgetsColumns(): int | array
    // {
    //     return 3;
    // }    
}
