<?php

namespace App\Filament\Admin\Resources\TransferAkuns\Pages;

use App\Filament\Admin\Resources\TransferAkuns\TransferAkunResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransferAkuns extends ListRecords
{
    protected static string $resource = TransferAkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Transfer Akun')
            ->icon('heroicon-o-plus'),
        ];
    }
}
