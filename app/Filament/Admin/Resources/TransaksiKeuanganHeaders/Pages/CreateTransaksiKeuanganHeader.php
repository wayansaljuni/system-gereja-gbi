<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages;

use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\TransaksiKeuanganHeaderResource;
use App\Models\KategoriKeuangan;
use App\Models\TransaksiKeuangan;
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

            /*
             * ==========================================================
             * 3. Ambil kategori aktif
             * ==========================================================
             */

            $kategori = KategoriKeuangan::query()
                ->where('aktif', true)
                ->orderBy('id')
                ->get();

            /*
             * ==========================================================
             * 4. Simpan DETAIL
             * ==========================================================
             */

            foreach ($kategori as $item) {

                $id = $item->id;

                /*
                 * ======================================================
                 * PEMASUKAN DETAIL JEMAAT
                 * ======================================================
                 */

                if (
                    $item->tipe === 'pemasukan'
                    && (bool) $item->bisa_detail_jemaat
                ) {

                    $rows = $data["jemaat_{$id}"] ?? [];

                    foreach ($rows as $row) {

                        $jumlah = (float) str_replace(
                            ',',
                            '',
                            (string) ($row['jumlah'] ?? 0)
                        );

                        /*
                         * Jangan simpan baris kosong
                         */
                        if ($jumlah <= 0) {
                            continue;
                        }

                        TransaksiKeuangan::create([
                            'transaksi_keuangan_header_id' => $header->id,

                            'tanggal' => $header->tanggal,

                            'ibadah_id' => $header->ibadah_id,

                            'kategori_keuangan_id' => $id,

                            'akun_id' => $row["akun_id_{$id}"] ?? null,

                            'jemaat_id' => $row['jemaat_id'] ?? null,

                            'metode_pembayaran' =>
                                $row['metode_pembayaran'] ?? 'tunai',

                            'jumlah' => $jumlah,

                            'no_referensi' => null,

                            'keterangan' => $header->keterangan,
                        ]);
                    }

                    continue;
                }

                /*
                 * ======================================================
                 * PEMASUKAN / PENGELUARAN UMUM
                 * ======================================================
                 */

                $jumlah = (float) str_replace(
                    ',',
                    '',
                    (string) ($data["jumlah_umum_{$id}"] ?? 0)
                );

                /*
                 * Jangan simpan nominal 0
                 */
                if ($jumlah <= 0) {
                    continue;
                }

                TransaksiKeuangan::create([
                    'transaksi_keuangan_header_id' => $header->id,

                    'tanggal' => $header->tanggal,

                    'ibadah_id' => $header->ibadah_id,

                    'kategori_keuangan_id' => $id,

                    'akun_id' => $data["akun_id_{$id}"] ?? null,

                    'jemaat_id' => null,

                    'metode_pembayaran' =>
                        $data["metode_{$id}"] ?? 'tunai',

                    'jumlah' => $jumlah,

                    'no_referensi' => null,

                    'keterangan' => $header->keterangan,
                ]);
            }

            return $header;
        });
    }    
}
