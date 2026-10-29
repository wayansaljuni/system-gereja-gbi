<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages;

use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\TransaksiKeuanganHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiKeuanganHeaders extends ListRecords
{
    protected static string $resource = TransaksiKeuanganHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Transaksi')
            ->icon('heroicon-o-plus'),
        ];
    }
}
