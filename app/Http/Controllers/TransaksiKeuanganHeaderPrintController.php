<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeuanganHeader;

class TransaksiKeuanganHeaderPrintController extends Controller
{
    public function print(TransaksiKeuanganHeader $transaksiKeuanganHeader)
    {
        $transaksiKeuanganHeader->load([
            'ibadah',
            'transaksiKeuangan.kategoriKeuangan',
            'transaksiKeuangan.akun',
            'transaksiKeuangan.jemaat',
        ]);

        return view(
            'transaksi-keuangan-header.print',
            compact('transaksiKeuanganHeader')
        );
    }
}