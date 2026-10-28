<?php

namespace App\Filament\Admin\Resources\KategoriKeuangans\Pages;

use App\Filament\Admin\Resources\KategoriKeuangans\KategoriKeuanganResource;
use Filament\Resources\Pages\ListRecords;

class ListKategoriKeuangans extends ListRecords
{
    protected static string $resource = KategoriKeuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
