<?php

namespace App\Filament\Admin\Resources\Organisasis\Pages;

use App\Filament\Admin\Resources\Organisasis\OrganisasiResource;
use App\Filament\Widgets\OrganisasiStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrganisasis extends ListRecords
{
    protected static string $resource = OrganisasiResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            OrganisasiStats::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
