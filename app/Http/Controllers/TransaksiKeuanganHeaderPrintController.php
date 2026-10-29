<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeuanganHeader;

class TransaksiKeuanganHeaderPrintController extends Controller
{
    public function print(TransaksiKeuanganHeader $transaksiKeuanganHeader)
    {
        $transaksiKeuanganHeader->load([
            'ibadah',
            'details.kategoriKeuangan',
            'details.akun',
            'details.jemaat',
        ]);

        return view(
            'transaksi-keuangan-header.print',
            compact('transaksiKeuanganHeader')
        );
    }
}