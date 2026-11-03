<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages;

use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\TransaksiKeuanganHeaderResource;
// use App\Models\KategoriKeuangan;
// use App\Models\TransaksiKeuangan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateTransaksiKeuanganHeader extends CreateRecord
{
    protected static string $resource = TransaksiKeuanganHeaderResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {

            /*
             * ==========================================================
             * 1. Ambil informasi HEADER
             * ==========================================================
             */

            $headerData = [
                'tanggal' => $data['tanggal'],
                'ibadah_id' => $data['ibadah_id'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ];

            /*
             * ==========================================================
             * 2. Simpan HEADER
             * ==========================================================
             */

            $header = static::getModel()::create($headerData);

        });
    }    
}
