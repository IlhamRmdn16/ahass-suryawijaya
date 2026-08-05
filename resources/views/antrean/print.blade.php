<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Antrean - {{ $antrean->no_polisi }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            width: 320px;
            margin: 20px auto;
            color: #111;
            font-size: 13px;
        }
        .center { text-align: center; }
        .divider { border-top: 1px dashed #333; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; vertical-align: top; }
        td.label { width: 95px; }
        td.sep { width: 10px; }
        h1 { font-size: 16px; margin: 0 0 2px; }
        p { margin: 2px 0; }
        .btn-print {
            display: block;
            width: 100%;
            margin-top: 16px;
            padding: 10px;
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-family: sans-serif;
            font-size: 14px;
            cursor: pointer;
        }
        @media print {
            .btn-print { display: none; }
            body { margin: 0; width: 100%; }
        }
    </style>
</head>
<body>
    <div class="center">
        <h1>AHASS BENGKEL</h1>
        <p>Struk Antrean Servis</p>
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="label">Tanggal</td><td class="sep">:</td>
            <td>{{ $antrean->tanggal->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Jam Masuk</td><td class="sep">:</td>
            <td>{{ $antrean->jam_masuk->format('H:i') }}</td>
        </tr>
        <tr>
            <td class="label">No Polisi</td><td class="sep">:</td>
            <td>{{ $antrean->no_polisi }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Motor</td><td class="sep">:</td>
            <td>{{ $antrean->tipe_motor }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Pekerjaan</td><td class="sep">:</td>
            <td>{{ $antrean->jenisPekerjaan->nama_pekerjaan }}</td>
        </tr>
        <tr>
            <td class="label">Mekanik</td><td class="sep">:</td>
            <td>{{ $antrean->mekanik->nama ?? 'Belum ditugaskan' }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td><td class="sep">:</td>
            <td>{{ $antrean->no_hp ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Daya Auto</td><td class="sep">:</td>
            <td>{{ $antrean->daya_auto ? 'Ya' : 'Tidak' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <p class="center">Mohon simpan struk ini.<br>Terima kasih.</p>

    <button class="btn-print" onclick="window.print()">Cetak Struk</button>
</body>
</html>
