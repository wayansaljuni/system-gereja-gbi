<?php

namespace App\Filament\Admin\Resources\KategoriKeuangans\Pages;

use App\Filament\Admin\Resources\KategoriKeuangans\KategoriKeuanganResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriKeuangan extends EditRecord
{
    protected static string $resource = KategoriKeuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
