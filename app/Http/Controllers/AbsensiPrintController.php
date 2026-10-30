<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class AbsensiPrintController extends Controller
{
    public function print(Absensi $absensi): Response
    {
        $absensi->load([
            'ibadah',
            'details.jemaat',
        ]);
        $details = $absensi->details;
        $total = $details->count();

        $pdf = Pdf::loadView('absensi.print', compact(
            'absensi',
            'details',
            'total',
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream(
            'Absensi-' . $absensi->id . '.pdf'
        );
    }
}