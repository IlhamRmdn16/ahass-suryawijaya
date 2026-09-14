<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Times-Roman', 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.4;
            position: relative;
            
            /* BORDER SEKELILING DOKUMEN */
            border: 1px solid #000;
            padding: 20px;
            margin: 0;
        }
        
        /* JUDUL & GARIS PEMBATAS */
        h1 {
            font-size: 13pt;
            text-align: center;
            margin: 0 0 10px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #000; /* Border tambahan sesudah judul */
            text-transform: uppercase;
            line-height: 1.3;
        }
        
        table.info {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 14px;
        }
        table.info td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.info td.label { width: 100px; }
        
        p { 
            text-align: justify; 
            margin: 0 0 10px; 
        }
        
        .item { 
            margin-bottom: 10px; 
            text-align: justify;
        }
        
        /* CEKLIS DI DALAM KOTAK */
        .check-box {
            display: inline-block;
            width: 13px;
            height: 13px;
            border: 1px solid #000;
            text-align: center;
            line-height: 12px;
            font-size: 10px;
            font-weight: bold;
            margin-right: 6px;
        }

        /* TANDA TANGAN MENTOK KANAN */
        .ttd-wrapper {
            position: relative;
            height: 140px;
            margin-top: 20px;
        }
        .ttd-box {
            position: absolute;
            right: 0;
            top: 0;
            width: 220px;
            text-align: center;
        }
        .ttd-img { 
            height: 65px; 
            margin: 8px 0;
        }
    </style>
</head>
<body>

    <h1>FORMULIR PERSETUJUAN PEMROSESAN DATA PRIBADI
        <br>Perintah Kerja Bengkel (PKB)
    </h1>

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
        <span class="check-box">&#10003;</span> <strong>1.</strong> Memperoleh, mengumpulkan, menyimpan, mengolah, memproses,
        menganalisa, mentransfer dan memusnahkan data pribadi yang diperlukan dari konsumen untuk kegiatan:
        a. Proses reminder perawatan berkala kendaraan, perbaikan kendaraan, garansi kendaraan (pabrikan), pemesanan
        suku cadang, serta berkomunikasi dengan konsumen melalui berbagai media komunikasi dan melakukan kajian
        umpan balik untuk memahami preferensi dari konsumen; b. Menerapkan sistem, prosedur dan perangkat teknis
        serta mengambil tindakan lain yang diperlukan untuk melindungi data pribadi yang dikumpulkan dan dikelola
        termasuk dengan cara bekerjasama dengan pihak penyedia layanan teknologi dan informasi dan/atau pihak
        lainnya yang ditunjuk oleh AHASS dan/atau Distributor dan/atau Manufaktur.
    </div>

    <div class="item">
        <span class="check-box">&#10003;</span> <strong>2.</strong> Memperoleh, mengumpulkan, menyimpan, mengolah, memproses,
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
        Demikian Surat Pernyataan ini saya tandatangani dan beri tanda centang (<span class="check-box">&#10003;</span>) sesuai dengan kehendak
        saya pribadi tanpa ada paksaan dari pihak manapun.
    </p>

    <!-- KOTAK TANDA TANGAN (MENTOK KANAN) -->
    <div class="ttd-wrapper">
        <div class="ttd-box">
            <p style="margin: 0 0 4px 0;">Garut, {{ $pkb->ditandatangani_pada->translatedFormat('d F Y') }}</p>
            <p style="margin: 0;">Pemilik Data Pribadi,</p>
            
            @if ($pkb->tanda_tangan)
                <img class="ttd-img" src="{{ storage_path('app/public/' . $pkb->tanda_tangan) }}">
            @else
                <div style="height: 65px; margin: 8px 0;"></div>
            @endif
            
            <p style="margin: 0;"><strong>({{ $pkb->nama_konsumen }})</strong></p>
        </div>
    </div>

</body>
</html>