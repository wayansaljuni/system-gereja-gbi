<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages;

use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\TransaksiKeuanganHeaderResource;
use App\Models\KategoriKeuangan;
use App\Models\TransaksiKeuangan;
use App\Models\TransaksiKeuanganHeader;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditTransaksiKeuanganHeader extends EditRecord
{
    protected static string $resource = TransaksiKeuanganHeaderResource::class;

    /**
     * Memuat data header dan detail transaksi ke dalam form Edit.
     */
    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     /** @var TransaksiKeuanganHeader $record */
    //     $record = $this->getRecord();

    //     $details = $record->details()->get();

    //     $kategori = KategoriKeuangan::query()
    //         ->where('aktif', true)
    //         ->orderBy('nama')
    //         ->get();

    //     foreach ($kategori as $item) {
    //         $id = $item->id;

    //         $detailKategori = $details
    //             ->where('kategori_keuangan_id', $id)
    //             ->values();

    //         /*
    //          * Kategori pemasukan dengan detail per jemaat.
    //          */
    //         if (
    //             $item->tipe === 'pemasukan'
    //             && (bool) $item->bisa_detail_jemaat
    //         ) {
    //             $data["jemaat_{$id}"] = $detailKategori
    //                 ->map(function ($detail) use ($id) {
    //                     return [
    //                         'jemaat_id' => $detail->jemaat_id,
    //                         "akun_id_{$id}" => $detail->akun_id,
    //                         'metode_pembayaran' =>
    //                             $detail->metode_pembayaran ?? 'tunai',
    //                         'jumlah' => (float) $detail->jumlah,
    //                     ];
    //                 })
    //                 ->all();

    //             $data["jumlah_umum_{$id}"] = (float) $detailKategori
    //                 ->sum('jumlah');

    //             continue;
    //         }

    //         /*
    //          * Kategori umum: satu input jumlah per kategori.
    //          */
    //         $data["jumlah_umum_{$id}"] = (float) $detailKategori
    //             ->sum('jumlah');

    //         $detailPertama = $detailKategori->first();

    //         $data["akun_id_{$id}"] = $detailPertama?->akun_id;

    //         $data["metode_{$id}"] =
    //             $detailPertama?->metode_pembayaran ?? 'tunai';
    //     }

    //     return $data;
    // }
protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var TransaksiKeuanganHeader $record */
        $record = $this->getRecord();

        $details = $record->details()->get();

        // Ambil semua kategori agar transaksi kategori nonaktif tetap dimuat.
        $kategori = KategoriKeuangan::query()
            ->orderBy('nama')
            ->get();

        foreach ($kategori as $item) {
            $id = $item->id;

            $detailKategori = $details
                ->where('kategori_keuangan_id', $id)
                ->values();

            $detailJemaat =
                $item->tipe === 'pemasukan'
                && (bool) $item->bisa_detail_jemaat;

            if ($detailJemaat) {
                $data["jemaat_{$id}"] = $detailKategori
                    ->map(fn ($detail) => [
                        'jemaat_id' => $detail->jemaat_id,
                        "akun_id_{$id}" => $detail->akun_id,
                        'metode_pembayaran' =>
                            $detail->metode_pembayaran ?? 'tunai',
                        'jumlah' => (string) $detail->jumlah,
                    ])
                    ->all();

                $data["jumlah_umum_{$id}"] =
                    (string) $detailKategori->sum('jumlah');

                continue;
            }

            $detailPertama = $detailKategori->first();

            $data["jumlah_umum_{$id}"] =
                (string) $detailKategori->sum('jumlah');

            $data["akun_id_{$id}"] = $detailPertama?->akun_id;

            $data["metode_{$id}"] =
                $detailPertama?->metode_pembayaran ?? 'tunai';
        }

        return $data;
    }
    /**
     * Menyimpan perubahan header dan seluruh detail transaksi.
     */
    protected function handleRecordUpdate(Model $record,array $data): Model {
        return DB::transaction(function () use ($record, $data) {
            /** @var TransaksiKeuanganHeader $record */

            /*
             * 1. Update header transaksi.
             */
            $record->update([
                'tanggal' => $data['tanggal'],
                'ibadah_id' => $data['ibadah_id'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            /*
             * 2. Hapus detail lama milik header ini.
             */
            $record->details()->delete();

            /*
             * 3. Ambil kategori aktif.
             */
            $kategori = KategoriKeuangan::query()
                ->where('aktif', true)
                ->orderBy('nama')
                ->get();

            /*
             * 4. Simpan kembali detail berdasarkan form.
             */
            foreach ($kategori as $item) {
                $id = $item->id;

                /*
                 * A. Pemasukan dengan detail per jemaat.
                 * Satu baris repeater = satu transaksi_keuangan.
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

                        // Abaikan baris dengan jumlah nol atau negatif.
                        if ($jumlah <= 0) {
                            continue;
                        }

                        TransaksiKeuangan::create([
                            'transaksi_keuangan_header_id' => $record->id,
                            'tanggal' => $record->tanggal,
                            'ibadah_id' => $record->ibadah_id,
                            'kategori_keuangan_id' => $id,
                            'akun_id' => $row["akun_id_{$id}"] ?? null,
                            'jemaat_id' => $row['jemaat_id'] ?? null,
                            'metode_pembayaran' =>
                                $row['metode_pembayaran'] ?? 'tunai',
                            'jumlah' => $jumlah,
                            'no_referensi' => null,
                            'keterangan' => $record->keterangan,
                        ]);
                    }

                    continue;
                }

                /*
                 * B. Kategori umum.
                 * Satu input jumlah = satu transaksi_keuangan.
                 */
                $jumlah = (float) str_replace(
                    ',',
                    '',
                    (string) ($data["jumlah_umum_{$id}"] ?? 0)
                );

                if ($jumlah <= 0) {
                    continue;
                }

                TransaksiKeuangan::create([
                    'transaksi_keuangan_header_id' => $record->id,
                    'tanggal' => $record->tanggal,
                    'ibadah_id' => $record->ibadah_id,
                    'kategori_keuangan_id' => $id,
                    'akun_id' => $data["akun_id_{$id}"] ?? null,
                    'jemaat_id' => null,
                    'metode_pembayaran' =>
                        $data["metode_{$id}"] ?? 'tunai',
                    'jumlah' => $jumlah,
                    'no_referensi' => null,
                    'keterangan' => $record->keterangan,
                ]);
            }

            /*
             * 5. Kembalikan record header.
             */
            return $record->refresh();
        });
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->getRecord()->approve) {
            Notification::make()
                ->title('Transaksi sudah di-approve')
                ->body('Transaksi yang sudah disetujui tidak dapat diedit lagi.')
                ->warning()
                ->send();

            $this->redirect(
                static::getResource()::getUrl('index')
            );
        }
    }    
    protected function beforeSave(): void
    {
        if ($this->getRecord()->approve) {
            Notification::make()
                ->title('Transaksi sudah di-approve')
                ->body('Transaksi yang sudah disetujui tidak dapat diedit lagi.')
                ->warning()
                ->send();

            $this->redirect(
                static::getResource()::getUrl('index')
            );
        }        
    }    
}