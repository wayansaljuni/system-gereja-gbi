<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Pages;

use App\Filament\Admin\Resources\SpkTeknisis\SpkTeknisiResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSpkTeknisi extends EditRecord
{
    protected static string $resource = SpkTeknisiResource::class;

    private function normalizeDate($value)
    {
        if (
            blank($value) ||
            $value === '0000-00-00' ||
            $value === '0000-00-00 00:00:00'
        ) {
            return null;
        }

        return $value;
    }    

    public int $currentVisit = 1;
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->load([
            'spk',
            'spk.produk',
        ]);
        $spk = $this->record->spk;
        $produk = $spk?->produk;
        $datang1 = $produk?->getRawOriginal('tgldtg1');
        $pulang1 = $produk?->getRawOriginal('tglplg1');
        $datang2 = $produk?->getRawOriginal('tgldtg2');
        $pulang2 = $produk?->getRawOriginal('tglplg2');
        $datang3 = $produk?->getRawOriginal('tgldtg3');
        $pulang3 = $produk?->getRawOriginal('tglplg3');
        // SPK
        if (
            $this->normalizeDate($datang1) === null ||
            $this->normalizeDate($pulang1) === null
        ) {
            $this->currentVisit = 1;
        } elseif (
            $this->normalizeDate($datang2) === null ||
            $this->normalizeDate($pulang2) === null
        ) {
            $this->currentVisit = 2;
        } elseif (
            $this->normalizeDate($datang3) === null ||
            $this->normalizeDate($pulang3) === null
        ) {
            $this->currentVisit = 3;
        } else {
            $this->currentVisit = 3;
        }
        // dd($produk = $spk?->produk);
        // dd($spk?->komplain->customer->nmcomercial);
        // dd($this->currentVisit);

        $data['spk_nospk'] = $spk?->nospk;
        $data['spk_tgk'] = $spk?->tgk;
        $data['spk_nosr'] = $spk?->nosr;
        $data['spk_nmcust'] = $spk?->nmcust;
        // Produk
        $data['produk_kdb'] = $produk?->kdb;
        $data['produk_nmb'] = $produk?->nmb;
        $data['produk_sts'] = $produk?->sts;
        $data['produk_part_kembali'] = $produk?->part_kembali;

        $data['produk_klh'] = $produk?->klh;
        $data['produk_krskn'] = $produk?->krskn;
        $data['produk_solusi'] = $produk?->solusi;

        $data['produk_tgldtg1'] = $this->normalizeDate($datang1);
        $data['produk_tglplg1'] = $this->normalizeDate($pulang1);

        $data['produk_tgldtg2'] = $this->normalizeDate($datang2);
        $data['produk_tglplg2'] = $this->normalizeDate($pulang2);

        $data['produk_tgldtg3'] = $this->normalizeDate($datang3);
        $data['produk_tglplg3'] = $this->normalizeDate($pulang3);

        $data['produk_foto_produk'] = $produk?->foto_produk ?? [];
        $data['produk_video_produk'] = $produk?->video_produk ?? [];

        $data['produk_yvolt'] = $produk?->yvolt ?? '';
        $data['produk_yampere'] = $produk?->yampere ?? '';
        $data['produk_ymbar'] = $produk?->ymbar ?? '';
        $data['produk_ybar'] = $produk?->ybar ?? '';
        $data['produk_ycelcius'] = $produk?->ycelcius ?? '';    
        
        return $data;
    }

    // Untuk menampung data produk sebelum disimpan
    protected array $produkData = [];
    /**
     * ==========================================
     * 1. SAAT FORM EDIT DIBUKA
     * ==========================================
     */
    /**
     * ==========================================
     * 2. SEBELUM TOMBOL SAVE MENYIMPAN
     * ==========================================
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ambil field yang sebenarnya milik tabel PRODUK
        $this->produkData = [
            'sts' => $data['produk_sts'] ?? '',
            'krskn' => $data['produk_krskn'] ?? '',
            'solusi' => $data['produk_solusi'] ?? '',
            'yvolt' => $data['produk_yvolt'] ?? '',
            'yampere' => $data['produk_yampere'] ?? '',
            'ymbar' => $data['produk_ymbar'] ?? '',
            'ybar' => $data['produk_ybar'] ?? '',
            'ycelcius' => $data['produk_ycelcius'] ?? '',
        ];

        if ($this->currentVisit === 1) {
            $this->produkData['tgldtg1'] = $data['produk_tgldtg1'];
            $this->produkData['tglplg1'] = $data['produk_tglplg1'];
        }
        elseif ($this->currentVisit === 2) {
            $this->produkData['tgldtg2'] = $data['produk_tgldtg2'];
            $this->produkData['tglplg2'] = $data['produk_tglplg2'];
        }
        elseif ($this->currentVisit === 3) {
            $this->produkData['tgldtg3'] = $data['produk_tgldtg3'];
            $this->produkData['tglplg3'] = $data['produk_tglplg3'];
        }
        if (array_key_exists('produk_foto_produk', $data)) {
            $this->produkData['foto_produk'] =
                $data['produk_foto_produk'] ?? [];
        }

        if (array_key_exists('produk_video_produk', $data)) {
            $this->produkData['video_produk'] =
                $data['produk_video_produk'] ?? [];
        }
        /*
         * Hapus field virtual produk.
         *
         * Ini penting supaya Filament TIDAK mencoba menyimpan
         * produk_sts, produk_krskn, dll ke tabel `teknisi`.
         */
        unset(
            $data['produk_sts'],
            $data['produk_krskn'],
            $data['produk_solusi'],
            $data['produk_part_kembali'],

            $data['produk_yvolt'],
            $data['produk_yampere'],
            $data['produk_ymbar'],
            $data['produk_ybar'],
            $data['produk_ycelcius'],

            $data['produk_tgldtg1'],
            $data['produk_tglplg1'],
            $data['produk_tgldtg2'],
            $data['produk_tglplg2'],
            $data['produk_tgldtg3'],
            $data['produk_tglplg3'],

            $data['produk_foto_produk'],
            $data['produk_video_produk'],
        );

        return $data;
    }
    /**
     * ==========================================
     * 3. SETELAH TEKNISI DISIMPAN
     * UPDATE TABEL PRODUK
     * ==========================================
     */
    protected function afterSave(): void
    {
        $produk = $this->record->spk?->produk;
        if (! $produk) {
            return;
        }
        $produk->update($this->produkData);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }    
}
