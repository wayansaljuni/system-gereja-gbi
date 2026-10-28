<?php

namespace App\Filament\Admin\Resources\Jemaats\Pages;

use App\Filament\Admin\Resources\Jemaats\JemaatResource;
use App\Filament\Widgets\JemaatStats;
use Filament\Resources\Pages\ListRecords;

class ListJemaats extends ListRecords
{
    protected static string $resource = JemaatResource::class;

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
    protected function getHeaderWidgets(): array
    {
        return [
            JemaatStats::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
