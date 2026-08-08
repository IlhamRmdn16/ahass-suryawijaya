<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Unit Entry - {{ $tanggal->translatedFormat('l, d F Y') }}</title>
    <style>
        * { box-sizing: border-box; }
        @page {
            size: A4;
            margin: 15mm 12mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            font-size: 12px;
            margin: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 18px;
            border-bottom: 2px solid #111;
            padding-bottom: 12px;
        }
        .header h1 {
            margin: 0 0 4px;
            font-size: 20px;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 7px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f0f0f0;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            font-size: 11.5px;
        }
        .center { text-align: center; }
        .no-col { width: 28px; }
        .footer {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        .footer div { text-align: center; width: 200px; }
        .footer .line { margin-top: 50px; border-top: 1px solid #333; padding-top: 4px; }

        .btn-print {
            display: block;
            width: 220px;
            margin: 0 auto 20px;
            padding: 10px;
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            cursor: pointer;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Halaman Ini</button>

    <div class="header">
        <h1>UNIT ENTRY</h1>
        <p>Hari/Tanggal: {{ $tanggal->translatedFormat('l, d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th>No Polisi</th>
                <th>Type</th>
                <th>Jam</th>
                <th>Mekanik</th>
                <th>JP</th>
                <th>No. HP</th>
                <th class="center">Daya Auto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($antreans as $i => $antrean)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $antrean->no_polisi }}</td>
                    <td>{{ $antrean->tipe_motor }}</td>
                    <td>
                        {{ $antrean->jam_masuk->format('H:i') }}
                        &ndash;
                        {{ $antrean->jam_selesai ? $antrean->jam_selesai->format('H:i') : '-' }}
                    </td>
                    <td>{{ $antrean->mekanik->nama ?? '-' }}</td>
                    <td>{{ $antrean->jenisPekerjaan->nama_pekerjaan ?? '-' }}</td>
                    <td>{{ $antrean->no_hp ?: '-' }}</td>
                    <td class="center">{{ $antrean->daya_auto ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center">Tidak ada data pada tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
