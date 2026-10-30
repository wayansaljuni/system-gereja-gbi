
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Jemaat</title>
    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header h2 {
            margin: 0 0 5px;
            font-size: 17px;
        }

        .header p {
            margin: 0;
            font-size: 10px;
        }

        .info {
            width: 100%;
            margin-bottom: 15px;
        }

        .info td {
            padding: 4px;
            vertical-align: top;
        }

        .summary {
            width: 100%;
            margin-bottom: 15px;
        }

        .summary td {
            border: 1px solid #999;
            padding: 7px;
            text-align: center;
        }

        .summary strong {
            display: block;
            font-size: 14px;
            margin-top: 3px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #777;
            padding: 6px;
        }

        table.data th {
            background: #eaeaea;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN ABSENSI JEMAAT</h2>
        <p>GEREJA BAPTIS TLOGOMULYO</p>
    </div>

    <table class="info">
        <tr>
            <td width="20%">Nama Ibadah</td>
            <td width="30%">: {{ $absensi->ibadah->nama ?? '-' }}</td>
            <td width="20%">Tanggal</td>
            <td width="30%">: {{ $absensi->tanggal?->format('d/m/Y') }}</td>
            <td width="20%">Total Kehadiran</td>
            <td width="30%">: <strong>{{ $total }}</strong> Orang</td> 

        </tr>
    </table>


    @php
        $half = (int) ceil($details->count() / 2);
        $leftDetails = $details->values()->take($half);
        $rightDetails = $details->values()->skip($half);
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0"
        style="border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr>
                <th width="50%" style="border: 1px solid #777; padding: 7px; background: #eaeaea;">
                    DETAIL KEHADIRAN
                </th>
                <th width="50%" style="border: 1px solid #777; padding: 7px; background: #eaeaea;">
                    DETAIL KEHADIRAN
                </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                {{-- KOLOM KIRI --}}
                <td width="50%" style="border: 1px solid #777; vertical-align: top; padding: 0;">
                    <table width="100%" cellpadding="0" cellspacing="0"
                        style="border-collapse: collapse;">

                        @foreach ($leftDetails as $index => $detail)
                            <tr>
                                <td width="28" style="padding: 7px 4px; text-align: center; vertical-align: top; border-bottom: 1px solid #ddd;">
                                    {{ $index + 1 }}
                                </td>

                                <td style="padding: 7px 5px; vertical-align: top; border-bottom: 1px solid #ddd;">
                                    <strong>
                                        {{ $detail->jemaat->no_jemaat ?? '-' }}
                                        - {{ $detail->jemaat->nama ?? '-' }}
                                    </strong>

                                    @if (filled($detail->keterangan))
                                        <div style="font-size: 9px; color: #555; margin-top: 3px;">
                                            {{ $detail->keterangan }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </td>

                {{-- KOLOM KANAN --}}
                <td width="50%" style="border: 1px solid #777; vertical-align: top; padding: 0;">
                    <table width="100%" cellpadding="0" cellspacing="0"
                        style="border-collapse: collapse;">

                        @foreach ($rightDetails as $index => $detail)
                            <tr>
                                <td width="28" style="padding: 7px 4px; text-align: center; vertical-align: top; border-bottom: 1px solid #ddd;">
                                    {{ $index + 1 }}
                                </td>

                                <td style="padding: 7px 5px; vertical-align: top; border-bottom: 1px solid #ddd;">
                                    <strong>
                                        {{ $detail->jemaat->no_jemaat ?? '-' }}
                                        - {{ $detail->jemaat->nama ?? '-' }}
                                    </strong>

                                    @if (filled($detail->keterangan))
                                        <div style="font-size: 9px; color: #555; margin-top: 3px;">
                                            {{ $detail->keterangan }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </td>
            </tr>
        </tbody>
    </table>


    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
