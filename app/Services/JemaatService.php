<?php

namespace App\Services;

use App\Models\Jemaat;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class JemaatService
{
    public static function create(array $data): Jemaat
    {
        return DB::transaction(function () use ($data) {
            // Kunci baris sequence sampai transaksi selesai.
            $sequence = DB::table('nomor_urut')
                ->where('kode', 'jemaat')
                ->lockForUpdate()
                ->first();
            if (! $sequence) {
                throw new RuntimeException(
                    'Sequence nomor jemaat belum tersedia.'
                );
            }
            // Tambahkan nomor urut.
            $nextNumber = $sequence->nilai + 1;
            DB::table('nomor_urut')
                ->where('kode', 'jemaat')
                ->update([
                    'nilai' => $nextNumber,
                    'updated_at' => now(),
                ]);

            // Format nomor NIJ-0001.
            $nomorJemaat = 'NIJ-' . str_pad(
                $nextNumber,
                4,
                '0',
                STR_PAD_LEFT
            );

            // Simpan jemaat dalam transaksi yang sama.
            // return Jemaat::create([
            //     ...$data,
            //     'no_jemaat' => $nomorJemaat,
            // ]);
            $data['no_jemaat'] = $nomorJemaat;
            return Jemaat::create($data);            
        });
    }
}