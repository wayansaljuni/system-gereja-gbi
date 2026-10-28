<?php

namespace App\Filament\Admin\Resources\KategoriKeuangans\Pages;

use App\Filament\Admin\Resources\KategoriKeuangans\KategoriKeuanganResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKategoriKeuangan extends ViewRecord
{
    protected static string $resource = KategoriKeuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
