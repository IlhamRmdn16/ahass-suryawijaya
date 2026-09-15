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
            border: 1px solid #000;
            padding: 20px;
            margin: 0;
        }

        /* =========================================
           JUDUL
           ========================================= */

        h1 {
            font-size: 13pt;
            text-align: center;
            margin: -20px -20px 10px -20px;
            padding: 20px 20px 8px 20px;
            border-bottom: 2px solid #000;
            text-transform: uppercase;
            line-height: 1.3;
        }


        /* =========================================
           INFORMASI KONSUMEN
           ========================================= */

        table.info {
            width: 100%;
            margin: 0 0 8px 0;
            border-collapse: collapse;
        }

        table.info td {
            padding: 1px 0;
            vertical-align: top;
        }

        table.info td.label {
            width: 100px;
        }


        /* =========================================
           PARAGRAF
           ========================================= */

        p {
            text-align: justify;
            margin: 0 0 10px;
        }

        p:last-child {
            margin-bottom: 0;
        }


        /* =========================================
           TABEL UTAMA DOKUMEN
           ========================================= */

        table.doc-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.doc-table td {
            padding: 0 0 10px 0;
            vertical-align: top;
        }

        table.doc-table tr:last-child td {
            padding-bottom: 0;
        }


        /* =========================================
           KOLOM CHECKBOX
           ========================================= */

        .col-checkbox {
            width: 20px;
            text-align: left;
            vertical-align: top;
            padding-top: 1px !important;
        }


        /* =========================================
           KOLOM KONTEN
           ========================================= */

        .col-content {
            text-align: justify;
        }


        /* =========================================
           NOMOR UTAMA
           
           Contoh:
           
           1. Memperoleh, mengumpulkan, ...
              menganalisa, mentransfer, ...
           
           2. Memperoleh, mengumpulkan, ...
              menganalisa, mentransfer, ...
           
           ========================================= */

        table.number-item {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        table.number-item td {
            padding: 0 !important;
            vertical-align: top;
        }

        /* Kolom 1. / 2. */
        .number {
            width: 20px;
            padding-right: 3px !important;
            text-align: left;
            white-space: nowrap;
        }

        /* Isi nomor 1 / 2 */
        .number-text {
            text-align: justify;
        }


        /* =========================================
           SUB ITEM a. / b.
           
           Dibuat lebih menjorok dari 1. / 2.
           
           Struktur:
           
           [indent] [a.] [isi]
           
           ========================================= */

        table.sub-number-item {
            width: 100%;
            border-collapse: collapse;

            /*
             * Jarak antara kalimat nomor utama
             * dengan sub-item a / b.
             */
            margin: 5px 0 0 0;
        }

        table.sub-number-item td {
            padding: 0 !important;
            vertical-align: top;
        }

        /*
         * Kolom kosong untuk membuat
         * sub-item lebih menjorok.
         *
         * Nilainya 20px.
         */
        .sub-indent {
            width: 20px;
        }

        /*
         * Kolom a. / b.
         */
        .sub-number {
            width: 20px;
            padding-right: 3px !important;
            text-align: left;
            white-space: nowrap;
        }

        /*
         * Isi dari a. / b.
         */
        .sub-number-text {
            text-align: justify;
        }


        /* =========================================
           CHECKBOX
           ========================================= */

        .check-box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            position: relative;
            box-sizing: border-box;
        }

        .check-box::after {
            content: "";
            position: absolute;
            width: 4px;
            height: 7px;
            border-right: 2px solid #000;
            border-bottom: 2px solid #000;
            transform: rotate(45deg);
            left: 3px;
            top: -1px;
        }


        /* =========================================
           CHECK MARK DI DALAM KALIMAT
           ========================================= */

        .check-mark {
            display: inline-block;
            width: 10px;
            height: 6px;
            border-left: 2px solid #000;
            border-bottom: 2px solid #000;
            transform: rotate(-45deg);
            margin: 0 2px 3px 2px;
        }


        /* =========================================
           TANDA TANGAN
           ========================================= */

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

    <!-- =====================================================
         JUDUL
         ===================================================== -->

    <h1>
        FORMULIR PERSETUJUAN PEMROSESAN DATA PRIBADI
        <br>
        Perintah Kerja Bengkel (PKB)
    </h1>


    <!-- =====================================================
         TABEL UTAMA
         ===================================================== -->

    <table class="doc-table">


        <!-- =================================================
             INFORMASI KONSUMEN
             ================================================= -->

        <tr>

            <td class="col-checkbox" width="20">
            </td>

            <td class="col-content">

                <table class="info">

                    <tr>
                        <td class="label">
                            Nama
                        </td>

                        <td>
                            : {{ $pkb->nama_konsumen }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            No. PKB/WO
                        </td>

                        <td>
                            : {{ $pkb->no_pkb }}
                        </td>
                    </tr>

                </table>

            </td>

        </tr>


        <!-- =================================================
             PARAGRAF PEMBUKA
             ================================================= -->

        <tr>

            <td class="col-checkbox" width="20">
            </td>

            <td class="col-content">

                <p>
                    Untuk memenuhi ketentuan Pelindungan Data Pribadi sesuai dengan peraturan yang berlaku,
                    serta dengan adanya pembelian produk dan/atau penggunaan layanan maka dengan ini saya
                    telah membaca dan memahami kebijakan privasi dari CV Surya Wijaya
                    (<strong>"AHASS"</strong>) dan memberikan persetujuan kepada AHASS,
                    dan PT Daya Adicipta Motora (<strong>"Distributor"</strong>) untuk :
                </p>

            </td>

        </tr>


        <!-- =================================================
             NOMOR 1
             ================================================= -->

        <tr>

            <!-- CHECKBOX -->
            <td class="col-checkbox" width="20">
                <span class="check-box"></span>
            </td>


            <!-- KONTEN NOMOR 1 -->
            <td class="col-content">

                <!-- =========================================
                     NOMOR 1 + ISI
                     ========================================= -->

                <table class="number-item">

                    <tr>

                        <!-- NOMOR 1. -->
                        <td class="number">
                            1.
                        </td>

                        <!-- ISI NOMOR 1 -->
                        <td class="number-text">
                            Memperoleh, mengumpulkan, menyimpan, mengolah, memproses,
                            menganalisa, mentransfer dan memusnahkan data pribadi yang diperlukan
                            dari konsumen untuk kegiatan:
                        </td>

                    </tr>

                </table>


                <!-- =========================================
                     SUB ITEM a.
                     ========================================= -->

                <table class="sub-number-item">

                    <tr>

                        <!-- INDENT TAMBAHAN -->
                        <td class="sub-indent">
                        </td>


                        <!-- NOMOR a. -->
                        <td class="sub-number">
                            a.
                        </td>


                        <!-- ISI a. -->
                        <td class="sub-number-text">
                            Proses reminder perawatan berkala kendaraan, perbaikan kendaraan,
                            garansi kendaraan (pabrikan), pemesanan suku cadang, serta berkomunikasi
                            dengan konsumen melalui berbagai media komunikasi dan melakukan kajian
                            umpan balik untuk memahami preferensi dari konsumen;
                        </td>

                    </tr>

                </table>


                <!-- =========================================
                     SUB ITEM b.
                     ========================================= -->

                <table class="sub-number-item">

                    <tr>

                        <!-- INDENT TAMBAHAN -->
                        <td class="sub-indent">
                        </td>


                        <!-- NOMOR b. -->
                        <td class="sub-number">
                            b.
                        </td>


                        <!-- ISI b. -->
                        <td class="sub-number-text">
                            Menerapkan sistem, prosedur dan perangkat teknis serta mengambil tindakan lain
                            yang diperlukan untuk melindungi data pribadi yang dikumpulkan dan dikelola
                            termasuk dengan cara bekerjasama dengan pihak penyedia layanan teknologi dan
                            informasi dan/atau pihak lainnya yang ditunjuk oleh AHASS dan/atau Distributor
                            dan/atau Manufaktur.
                        </td>

                    </tr>

                </table>

            </td>

        </tr>


        <!-- =================================================
             NOMOR 2
             ================================================= -->

        <tr>

            <!-- CHECKBOX -->
            <td class="col-checkbox" width="20">
                <span class="check-box"></span>
            </td>


            <!-- KONTEN NOMOR 2 -->
            <td class="col-content">

                <table class="number-item">

                    <tr>

                        <!-- NOMOR 2. -->
                        <td class="number">
                            2.
                        </td>


                        <!-- ISI NOMOR 2 -->
                        <td class="number-text">
                            Memperoleh, mengumpulkan, menyimpan, mengolah, memproses,
                            menganalisa, mentransfer dan memusnahkan data pribadi untuk kegiatan
                            promosi dan/atau informasi yang berkaitan dengan produk dan jasa kendaraan.
                        </td>

                    </tr>

                </table>

            </td>

        </tr>


        <!-- =================================================
             PARAGRAF PENUTUP
             ================================================= -->

        <tr>

            <td class="col-checkbox" width="20">
            </td>


            <td class="col-content">

                <p>
                    Apabila terdapat data pribadi selain milik Saya sendiri yang diserahkan kepada AHASS,
                    maka Saya telah mendapatkan persetujuan dan/atau izin dari subjek data pribadi
                    untuk melakukan pencantuman tersebut.
                </p>


                <p>
                    Perbaikan data pribadi, pengakhiran pemrosesan, penarikan persetujuan,
                    pengajuan keberatan, pembatasan atau penundaan pemrosesan data diri secara proporsional,
                    penghapusan, serta pelaksanaan hak lain sesuai dengan Undang-Undang nomor 27 Tahun 2022
                    tentang Pelindungan Data Pribadi, dapat diajukan oleh Pemilik / Pembawa melalui
                    permohonan secara tertulis kepada AHASS melalui alamat email:
                    customercare@astrahonda.com
                </p>


                <p>
                    Formulir ini merupakan satu kesatuan dan tidak terpisahkan dengan lembar PKB/WO
                    yang dikeluarkan secara resmi oleh PT Daya Adicipta Motora.
                </p>


                <p>
                    Demikian Surat Pernyataan ini saya tandatangani dan beri tanda centang
                    (<span class="check-mark"></span>)
                    sesuai dengan kehendak saya pribadi tanpa ada paksaan dari pihak manapun.
                </p>

            </td>

        </tr>

    </table>


    <!-- =====================================================
         TANDA TANGAN
         ===================================================== -->

    <div class="ttd-wrapper">

        <div class="ttd-box">

            <p style="margin: 0 0 4px 0;">
                Garut, {{ $pkb->ditandatangani_pada->translatedFormat('d F Y') }}
            </p>

            <p style="margin: 0;">
                Pemilik Data Pribadi,
            </p>


            @if ($pkb->tanda_tangan)

                <img
                    class="ttd-img"
                    src="{{ storage_path('app/public/' . $pkb->tanda_tangan) }}"
                >

            @else

                <div style="height: 65px; margin: 8px 0;">
                </div>

            @endif


            <p style="margin: 0;">
                <strong>
                    ({{ $pkb->nama_konsumen }})
                </strong>
            </p>

        </div>

    </div>

</body>
</html>