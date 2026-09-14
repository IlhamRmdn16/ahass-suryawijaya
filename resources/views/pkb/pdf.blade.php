<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #111;
            line-height: 1.5;
        }
        h1 {
            font-size: 14px;
            text-align: center;
            margin: 0 0 4px;
        }
        h2 {
            font-size: 12px;
            text-align: center;
            margin: 0 0 16px;
            font-weight: normal;
        }
        table.info {
            width: 100%;
            margin-bottom: 14px;
        }
        table.info td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.info td.label { width: 100px; }
        p { text-align: justify; margin: 0 0 10px; }
        .item { margin-bottom: 10px; }
        .item .check {
            display: inline-block;
            width: 16px;
            font-weight: bold;
        }
        .ttd-block {
            width: 250px;
            float: right;
            text-align: center;
            margin-top: 20px;
        }
        .ttd-img { height: 70px; margin: 8px 0; }
        .clearfix { clear: both; }
    </style>
</head>
<body>
    <h1>FORMULIR PERSETUJUAN PEMROSESAN DATA PRIBADI</h1>
    <h2>Perintah Kerja Bengkel (PKB)</h2>

    <table class="info">
        <tr>
            <td class="label">Nama</td>
            <td>: {{ $pkb->nama_konsumen }}</td>
        </tr>
        <tr>
            <td class="label">No. PKB/WO</td>
            <td>: {{ $pkb->no_pkb }}</td>
        </tr>
    </table>

    <p>
        Untuk memenuhi ketentuan Pelindungan Data Pribadi sesuai dengan peraturan yang berlaku, serta dengan adanya
        pembelian produk dan/atau penggunaan layanan maka dengan ini saya telah membaca dan memahami kebijakan
        privasi dari CV Surya Wijaya ("AHASS") dan memberikan persetujuan kepada AHASS, dan PT Daya Adicipta Motora
        ("Distributor") untuk :
    </p>

    <div class="item">
        <span class="check">[&#10003;]</span> 1. Memperoleh, mengumpulkan, menyimpan, mengolah, memproses,
        menganalisa, mentransfer dan memusnahkan data pribadi yang diperlukan dari konsumen untuk kegiatan:
        a. Proses reminder perawatan berkala kendaraan, perbaikan kendaraan, garansi kendaraan (pabrikan), pemesanan
        suku cadang, serta berkomunikasi dengan konsumen melalui berbagai media komunikasi dan melakukan kajian
        umpan balik untuk memahami preferensi dari konsumen; b. Menerapkan sistem, prosedur dan perangkat teknis
        serta mengambil tindakan lain yang diperlukan untuk melindungi data pribadi yang dikumpulkan dan dikelola
        termasuk dengan cara bekerjasama dengan pihak penyedia layanan teknologi dan informasi dan/atau pihak
        lainnya yang ditunjuk oleh AHASS dan/atau Distributor dan/atau Manufaktur.
    </div>

    <div class="item">
        <span class="check">[&#10003;]</span> 2. Memperoleh, mengumpulkan, menyimpan, mengolah, memproses,
        menganalisa, mentransfer dan memusnahkan data pribadi untuk kegiatan promosi dan/atau informasi yang
        berkaitan dengan produk dan jasa kendaraan.
    </div>

    <p>
        Apabila terdapat data pribadi selain milik Saya sendiri yang diserahkan kepada AHASS, maka Saya telah
        mendapatkan persetujuan dan/atau izin dari subjek data pribadi untuk melakukan pencantuman tersebut.
    </p>

    <p>
        Perbaikan data pribadi, pengakhiran pemrosesan, penarikan persetujuan, pengajuan keberatan, pembatasan atau
        penundaan pemrosesan data diri secara proporsional, penghapusan, serta pelaksanaan hak lain sesuai dengan
        Undang-Undang nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi, dapat diajukan oleh Pemilik / Pembawa
        melalui permohonan secara tertulis kepada AHASS melalui alamat email: customercare@astrahonda.com
    </p>

    <p>
        Formulir ini merupakan satu kesatuan dan tidak terpisahkan dengan lembar PKB/WO yang dikeluarkan secara
        resmi oleh PT Daya Adicipta Motora.
    </p>

    <p>
        Demikian Surat Pernyataan ini saya tandatangani dan beri tanda centang (&#10003;) sesuai dengan kehendak
        saya pribadi tanpa ada paksaan dari pihak manapun.
    </p>

    <p style="text-align: right; margin-top: 10px;">
        Garut, {{ $pkb->ditandatangani_pada->translatedFormat('d F Y') }}
    </p>

    <div class="ttd-block">
        <p>Pemilik Data Pribadi,</p>
        @if ($pkb->tanda_tangan)
            <img class="ttd-img" src="{{ storage_path('app/public/' . $pkb->tanda_tangan) }}">
        @endif
        <p><strong>({{ $pkb->nama_konsumen }})</strong></p>
    </div>
    <div class="clearfix"></div>
</body>
</html>
