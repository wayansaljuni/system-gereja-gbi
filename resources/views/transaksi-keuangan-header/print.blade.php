<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Transaksi Keuangan #{{ $transaksiKeuanganHeader->id }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f3f4f6;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111827;
        }

        /* =====================================================
           TOOLBAR
        ===================================================== */

        .print-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;

            height: 55px;

            background: #ffffff;
            border-bottom: 1px solid #d1d5db;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            z-index: 100;
        }

        .btn {
            border: 0;
            border-radius: 5px;

            padding: 8px 18px;

            cursor: pointer;

            font-size: 12px;
        }

        .btn-print {
            background: #2563eb;
            color: white;
        }

        .btn-close {
            background: #e5e7eb;
            color: #111827;
        }


        /* =====================================================
           KERTAS
        ===================================================== */

        .paper {

            width: 210mm;
            min-height: 297mm;

            margin: 75px auto 20px;

            padding: 12mm 14mm;

            background: white;

            box-shadow:
                0 0 8px rgba(0, 0, 0, .15);
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .title {
            text-align: center;

            margin-bottom: 20px;
        }

        .title h1 {
            margin: 0;

            font-size: 18px;

            font-weight: bold;
        }

        .title h2 {
            margin: 4px 0 0;

            font-size: 12px;

            font-weight: normal;
        }


        /* =====================================================
           INFORMASI TRANSAKSI
        ===================================================== */

        .info-table {

            width: 100%;

            border-collapse: collapse;

            margin-bottom: 18px;
        }

        .info-table td {

            padding: 3px 2px;

            vertical-align: top;
        }

        .info-label {

            width: 90px;

            font-weight: bold;
        }

        .info-separator {

            width: 10px;

            text-align: center;
        }


        /* =====================================================
           TIPE TRANSAKSI
        ===================================================== */

        .transaction-type {

            margin-top: 15px;
            margin-bottom: 8px;

            padding: 7px 10px;

            font-size: 13px;

            font-weight: bold;

            border-bottom: 2px solid #111827;
        }


        /* =====================================================
           KATEGORI
        ===================================================== */

        .category {

            margin-bottom: 18px;
        }

        .category-title {

            padding: 6px 8px;

            background: #f3f4f6;

            border: 1px solid #d1d5db;

            font-weight: bold;

            font-size: 11px;
        }


        /* =====================================================
           DETAIL TABLE
        ===================================================== */

        .detail-table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 0;
        }

        .detail-table th,
        .detail-table td {

            border: 1px solid #9ca3af;

            padding: 5px 6px;
        }

        .detail-table th {

            background: #f9fafb;

            text-align: center;

            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }


        /* =====================================================
           SUBTOTAL
        ===================================================== */

        .subtotal td {

            background: #f9fafb;

            font-weight: bold;
        }


        /* =====================================================
           REKAP
        ===================================================== */

        .rekap {

            margin-top: 25px;

            width: 100%;
        }

        .rekap-title {

            font-weight: bold;

            font-size: 13px;

            margin-bottom: 7px;
        }

        .rekap-table {

            width: 100%;

            border-collapse: collapse;
        }

        .rekap-table th,
        .rekap-table td {

            border: 1px solid #9ca3af;

            padding: 5px 7px;
        }

        .rekap-table th {

            background: #f3f4f6;

            text-align: center;
        }

        .rekap-total td {

            font-weight: bold;

            background: #f3f4f6;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .signature {

            width: 220px;

            margin-left: auto;

            margin-top: 35px;

            text-align: center;
        }

        .signature-space {

            height: 55px;
        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            @page {

                size: A4 portrait;

                margin: 10mm;
            }

            body {

                background: white;
            }

            .print-toolbar {

                display: none;
            }

            .paper {

                width: 100%;

                min-height: auto;

                margin: 0;

                padding: 0;

                box-shadow: none;
            }

        }

    </style>

</head>


<body>


    {{-- =====================================================
         TOOLBAR
    ====================================================== --}}

    <div class="print-toolbar">

        <button
            class="btn btn-print"
            onclick="window.print()"
        >
            🖨 Print
        </button>

        <button
            class="btn btn-close"
            onclick="window.close()"
        >
            Tutup
        </button>

    </div>


    {{-- =====================================================
         KERTAS
    ====================================================== --}}

    <div class="paper">


        {{-- =================================================
             JUDUL
        ================================================== --}}

        <div class="title">

            <h1>
                TRANSAKSI KEUANGAN
            </h1>

            {{-- <h2>
                {{ $transaksiKeuanganHeader->id }}
            </h2> --}}

        </div>


        {{-- =================================================
             INFORMASI TRANSAKSI
        ================================================== --}}

        <table class="info-table">

            <tr>

                <td class="info-label">
                    Tanggal
                </td>

                <td class="info-separator">
                    :
                </td>

                <td>
                    @if ($transaksiKeuanganHeader->tanggal)
                        {{ \Carbon\Carbon::parse(
                            $transaksiKeuanganHeader->tanggal
                        )->translatedFormat('d F Y H:i') }}
                    @else
                        -
                    @endif
                </td>

            </tr>


            <tr>

                <td class="info-label">
                    Ibadah
                </td>

                <td class="info-separator">
                    :
                </td>

                <td>
                    {{ $transaksiKeuanganHeader->ibadah?->nama ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="info-label">
                    Keterangan
                </td>

                <td class="info-separator">
                    :
                </td>

                <td>
                    {{ $transaksiKeuanganHeader->keterangan ?? '-' }}
                </td>

            </tr>

        </table>


        {{-- =================================================
             PEMASUKAN
        ================================================== --}}

        @php

            $pemasukan = $transaksiKeuanganHeader->details
                ->filter(
                    fn ($detail) =>
                        $detail->kategoriKeuangan?->tipe === 'pemasukan'
                )
                ->groupBy('kategori_keuangan_id');

            $pengeluaran = $transaksiKeuanganHeader->details
                ->filter(
                    fn ($detail) =>
                        $detail->kategoriKeuangan?->tipe === 'pengeluaran'
                )
                ->groupBy('kategori_keuangan_id');

        @endphp


        {{-- =================================================
             PEMASUKAN
        ================================================== --}}

        @if ($pemasukan->isNotEmpty())

            <div class="transaction-type">
                PEMASUKAN
            </div>


            @foreach ($pemasukan as $kategoriId => $details)

                @php

                    $kategori =
                        $details->first()->kategoriKeuangan;

                    $subtotal =
                        $details->sum('jumlah');

                    $detailJemaat =
                        (bool) ($kategori?->bisa_detail_jemaat);

                @endphp


                <div class="category">

                    <div class="category-title">

                        {{ $kategori?->nama ?? '-' }}

                    </div>


                    <table class="detail-table">

                        <thead>

                            <tr>

                                @if ($detailJemaat)

                                    <th width="20%">
                                        No. Kantong
                                    </th>

                                @endif

                                <th width="{{ $detailJemaat ? '35%' : '40%' }}">
                                    Akun Kas / Bank
                                </th>

                                <th width="20%">
                                    Metode
                                </th>

                                <th width="25%">
                                    Jumlah
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($details as $detail)

                                <tr>

                                    @if ($detailJemaat)

                                        <td>
                                            {{ $detail->jemaat?->no_kantong ?? '-' }}
                                        </td>

                                    @endif


                                    <td>
                                        {{ $detail->akun?->nama ?? '-' }}
                                    </td>


                                    <td class="center">

                                        {{ ucfirst(
                                            $detail->metode_pembayaran ?? '-'
                                        ) }}

                                    </td>


                                    <td class="right">

                                        Rp
                                        {{ number_format(
                                            $detail->jumlah,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                </tr>

                            @endforeach


                            <tr class="subtotal">

                                <td
                                    colspan="{{ $detailJemaat ? 3 : 2 }}"
                                    class="right"
                                >
                                    Subtotal
                                </td>

                                <td class="right">

                                    Rp
                                    {{ number_format(
                                        $subtotal,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            @endforeach

        @endif



        {{-- =================================================
             PENGELUARAN
        ================================================== --}}

        @if ($pengeluaran->isNotEmpty())

            <div class="transaction-type">
                PENGELUARAN
            </div>


            @foreach ($pengeluaran as $kategoriId => $details)

                @php

                    $kategori =
                        $details->first()->kategoriKeuangan;

                    $subtotal =
                        $details->sum('jumlah');

                @endphp


                <div class="category">

                    <div class="category-title">

                        {{ $kategori?->nama ?? '-' }}

                    </div>


                    <table class="detail-table">

                        <thead>

                            <tr>

                                <th width="40%">
                                    Akun Kas / Bank
                                </th>

                                <th width="20%">
                                    Metode
                                </th>

                                <th width="40%">
                                    Jumlah
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($details as $detail)

                                <tr>

                                    <td>
                                        {{ $detail->akun?->nama ?? '-' }}
                                    </td>


                                    <td class="center">

                                        {{ ucfirst(
                                            $detail->metode_pembayaran ?? '-'
                                        ) }}

                                    </td>


                                    <td class="right">

                                        Rp
                                        {{ number_format(
                                            $detail->jumlah,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                </tr>

                            @endforeach


                            <tr class="subtotal">

                                <td
                                    colspan="2"
                                    class="right"
                                >
                                    Subtotal
                                </td>

                                <td class="right">

                                    Rp
                                    {{ number_format(
                                        $subtotal,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            @endforeach

        @endif



        {{-- =================================================
             REKAP
        ================================================== --}}

        @php

            $pemasukanTunai =
                $transaksiKeuanganHeader->details
                    ->filter(
                        fn ($detail) =>
                            $detail->kategoriKeuangan?->tipe === 'pemasukan'
                            && $detail->metode_pembayaran === 'tunai'
                    )
                    ->sum('jumlah');


            $pemasukanTransfer =
                $transaksiKeuanganHeader->details
                    ->filter(
                        fn ($detail) =>
                            $detail->kategoriKeuangan?->tipe === 'pemasukan'
                            && $detail->metode_pembayaran === 'transfer'
                    )
                    ->sum('jumlah');


            $pengeluaranTunai =
                $transaksiKeuanganHeader->details
                    ->filter(
                        fn ($detail) =>
                            $detail->kategoriKeuangan?->tipe === 'pengeluaran'
                            && $detail->metode_pembayaran === 'tunai'
                    )
                    ->sum('jumlah');


            $pengeluaranTransfer =
                $transaksiKeuanganHeader->details
                    ->filter(
                        fn ($detail) =>
                            $detail->kategoriKeuangan?->tipe === 'pengeluaran'
                            && $detail->metode_pembayaran === 'transfer'
                    )
                    ->sum('jumlah');


            $totalPemasukan =
                $pemasukanTunai +
                $pemasukanTransfer;


            $totalPengeluaran =
                $pengeluaranTunai +
                $pengeluaranTransfer;


            $saldoTunai =
                $pemasukanTunai -
                $pengeluaranTunai;


            $saldoTransfer =
                $pemasukanTransfer -
                $pengeluaranTransfer;


            $saldoTotal =
                $totalPemasukan -
                $totalPengeluaran;

        @endphp


        <div class="rekap">

            <div class="rekap-title">
                REKAP KEUANGAN
            </div>


            <table class="rekap-table">

                <thead>

                    <tr>

                        <th>
                            Keterangan
                        </th>

                        <th>
                            Tunai
                        </th>

                        <th>
                            Transfer
                        </th>

                        <th>
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>
                            Pemasukan
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $pemasukanTunai,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $pemasukanTransfer,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $totalPemasukan,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>


                    <tr>

                        <td>
                            Pengeluaran
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $pengeluaranTunai,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $pengeluaranTransfer,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $totalPengeluaran,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>


                    <tr class="rekap-total">

                        <td>
                            SALDO
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $saldoTunai,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $saldoTransfer,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="right">
                            Rp
                            {{ number_format(
                                $saldoTotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>



        {{-- =================================================
             TANDA TANGAN
        ================================================== --}}

        <div class="signature">

            Dibuat,

            <div class="signature-space"></div>

            <strong>
                __________________________
            </strong>

        </div>


    </div>


</body>

</html>