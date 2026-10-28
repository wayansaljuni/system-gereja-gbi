<?php

namespace App\Filament\Admin\Resources\Kelompoks\Pages;

use App\Filament\Admin\Resources\Kelompoks\KelompokResource;
use App\Filament\Widgets\KelompokStats;
use Filament\Resources\Pages\ListRecords;

class ListKelompoks extends ListRecords
{
    protected static string $resource = KelompokResource::class;

    public function getHeaderWidgetsColumns(): int | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'xl' => 5,
            '2xl' => 5,
        ];
    }    

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            KelompokStats::class,
        ];
    }
}
