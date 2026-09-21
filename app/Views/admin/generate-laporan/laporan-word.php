<?php

/*
|--------------------------------------------------------------------------
| TEMPLATE LAPORAN WORD
|--------------------------------------------------------------------------
| File ini khusus untuk Generate DOC.
| Digunakan sebagai HTML yang akan dibuka oleh Microsoft Word.
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
*/

$logoPoldaSrc = '';

if (!empty($logoPolda)) {
    $logoPoldaSrc = 'data:image/png;base64,' . $logoPolda;
}

$logoBidTikSrc = '';

if (!empty($logoBidTik)) {
    $logoBidTikSrc = 'data:image/png;base64,' . $logoBidTik;
}


/*
|--------------------------------------------------------------------------
| TOTAL SELURUH STATUS
|--------------------------------------------------------------------------
*/

$totalKehadiran = 0;

foreach ($statusAbsensi as $status) {
    $totalKehadiran += (int) (
        $rekapStatus[$status] ?? 0
    );
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Kehadiran Personel
    </title>

    <style>

        /*
        |--------------------------------------------------------------------------
        | HALAMAN
        |--------------------------------------------------------------------------
        */

        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000000;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        |
        | Header menggunakan tabel 3 kolom.
        | Logo berada di dalam cell sehingga lebih stabil ketika dibuka di Word.
        |
        */

        .header-table {
            width: 100%;
            table-layout: fixed;
            border: none;
            margin: 0;
            padding: 0;
        }

        .header-table td {
            border: none;
            padding: 0;
            margin: 0;
            vertical-align: middle;
        }

        /*
        | Kolom logo kiri
        */

        .logo-left {
            width: 18%;
            text-align: left;
            vertical-align: middle;
        }

        /*
        | Kolom judul
        */

        .header-center {
            width: 64%;
            text-align: center;
            vertical-align: middle;
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        /*
        | Kolom logo kanan
        */

        .logo-right {
            width: 18%;
            text-align: right;
            vertical-align: middle;
        }


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        |
        | Tidak menggunakan position:absolute.
        | Tidak menggunakan float.
        | Tidak menggunakan transform.
        |
        | Gambar tetap mengikuti cell tabel.
        |
        */

        .logo-bidtik {
            width: 65px;
            height: 65px;
            display: inline-block;
        }

        .logo-polda {
            width: 60px;
            height: 60px;
            display: inline-block;
        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL HEADER
        |--------------------------------------------------------------------------
        */

        .title-main {
            font-size: 15pt;
            font-weight: bold;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .title-sub {
            font-size: 10pt;
            font-weight: bold;
            line-height: 1.3;
            margin-top: 4px;
        }

        .title-location {
            font-size: 10pt;
            line-height: 1.3;
            margin-top: 2px;
        }


        /*
        |--------------------------------------------------------------------------
        | GARIS HEADER
        |--------------------------------------------------------------------------
        */

        .header-line {
            border-top: 3px solid #b5121b;
            margin-top: 8px;
            margin-bottom: 12px;
            height: 0;
            line-height: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMASI LAPORAN
        |--------------------------------------------------------------------------
        */

        .info-table {
            width: 100%;
            margin-bottom: 12px;
            table-layout: fixed;
        }

        .info-table td {
            border: none;
            padding: 3px 0;
            font-size: 10pt;
            vertical-align: top;
        }

        .info-label {
            width: 18%;
            font-weight: bold;
        }

        .info-colon {
            width: 2%;
            text-align: center;
        }

        .info-value {
            width: 80%;
        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL SECTION
        |--------------------------------------------------------------------------
        */

        .section-title {
            width: 100%;
            background: #171717;
            color: #ffffff;
            font-weight: bold;
            font-size: 10pt;
            padding: 6px 8px;
            margin-top: 12px;
            margin-bottom: 6px;
        }


        /*
        |--------------------------------------------------------------------------
        | TABEL DATA PERSONEL
        |--------------------------------------------------------------------------
        */

        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table th {
            background: #b5121b;
            color: #ffffff;
            border: 1px solid #555555;
            padding: 5px 3px;
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
            vertical-align: middle;
        }

        .data-table td {
            border: 1px solid #555555;
            padding: 5px 3px;
            font-size: 8pt;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .center {
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | LEBAR KOLOM DATA
        |--------------------------------------------------------------------------
        */

        .no {
            width: 5%;
        }

        .nrp {
            width: 14%;
        }

        .nama {
            width: 21%;
        }

        .pangkat {
            width: 13%;
        }

        .unit {
            width: 19%;
        }

        .status {
            width: 15%;
        }

        .waktu {
            width: 13%;
        }


        /*
        |--------------------------------------------------------------------------
        | REKAPITULASI
        |--------------------------------------------------------------------------
        */

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .rekap-table th {
            background: #171717;
            color: #ffffff;
            border: 1px solid #555555;
            padding: 5px 2px;
            text-align: center;
            font-size: 7pt;
            font-weight: bold;
            vertical-align: middle;
        }

        .rekap-table td {
            border: 1px solid #555555;
            padding: 6px 2px;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
        }

        .rekap-total {
            background: #eeeeee;
            font-weight: bold;
        }


        /*
        |--------------------------------------------------------------------------
        | POIN HASIL APEL
        |--------------------------------------------------------------------------
        */

        .apel-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .apel-table td {
            border: 1px solid #555555;
            padding: 8px;
            font-size: 9pt;
            vertical-align: top;
        }

        .apel-label {
            width: 20%;
            font-weight: bold;
        }

        .apel-content {
            width: 80%;
        }


        /*
        |--------------------------------------------------------------------------
        | TANDA TANGAN
        |--------------------------------------------------------------------------
        */

        .signature-table {
            width: 100%;
            margin-top: 30px;
            border: none;
            table-layout: fixed;
        }

        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
        }

        .signature-left {
            width: 50%;
        }

        .signature-right {
            width: 50%;
        }

        .signature-space {
            height: 55px;
            line-height: 55px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

    </style>

</head>


<body>


<!--
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
|
| PENTING:
| Logo berada di dalam tabel.
| Tidak menggunakan position / float.
|
-->

<table class="header-table">

    <tr>

        <!-- =========================================================
             LOGO BID TIK
        ========================================================== -->

        <td class="logo-left">

            <?php if (!empty($logoBidTikSrc)): ?>

                <img
                    src="<?= $logoBidTikSrc ?>"
                    width="65"
                    height="65"
                    class="logo-bidtik"
                    alt="Logo Bid TIK">

            <?php endif; ?>

        </td>


        <!-- =========================================================
             JUDUL
        ========================================================== -->

        <td class="header-center">

            <div class="title-main">
                LAPORAN KEHADIRAN PERSONEL
            </div>

            <div class="title-sub">
                BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI
            </div>

            <div class="title-location">
                POLDA JAWA TIMUR
            </div>

        </td>


        <!-- =========================================================
             LOGO POLDA
        ========================================================== -->

        <td class="logo-right">

            <?php if (!empty($logoPoldaSrc)): ?>

                <img
                    src="<?= $logoPoldaSrc ?>"
                    width="60"
                    height="60"
                    class="logo-polda"
                    alt="Logo Polda Jawa Timur">

            <?php endif; ?>

        </td>

    </tr>

</table>


<!-- GARIS HEADER -->

<div class="header-line"></div>


<!-- ================================================================
     INFORMASI LAPORAN
================================================================ -->

<table class="info-table">

    <tr>

        <td class="info-label">
            Tanggal
        </td>

        <td class="info-colon">
            :
        </td>

        <td class="info-value">

            <?= esc(
                $tanggalFormat ??
                $tanggal ??
                '-'
            ) ?>

        </td>

    </tr>


    <tr>

        <td class="info-label">
            Jenis Laporan
        </td>

        <td class="info-colon">
            :
        </td>

        <td class="info-value">
            Rekapitulasi Kehadiran Personel
        </td>

    </tr>

</table>


<!-- ================================================================
     DATA KEHADIRAN
================================================================ -->

<div class="section-title">
    DATA KEHADIRAN PERSONEL
</div>


<table class="data-table">

    <thead>

        <tr>

            <th class="no">
                No.
            </th>

            <th class="nrp">
                NRP/NIP
            </th>

            <th class="nama">
                Nama
            </th>

            <th class="pangkat">
                Pangkat
            </th>

            <th class="unit">
                Unit Kerja
            </th>

            <th class="status">
                Status
            </th>

            <th class="waktu">
                Waktu
            </th>

        </tr>

    </thead>


    <tbody>

        <?php if (!empty($dataAbsensi)): ?>

            <?php $no = 1; ?>

            <?php foreach ($dataAbsensi as $row): ?>

                <tr>

                    <td class="center">
                        <?= $no++ ?>
                    </td>

                    <td>
                        <?= esc(
                            $row['nrp_nip'] ?? '-'
                        ) ?>
                    </td>

                    <td>
                        <?= esc(
                            $row['nama'] ?? '-'
                        ) ?>
                    </td>

                    <td>
                        <?= esc(
                            $row['pangkat'] ?? '-'
                        ) ?>
                    </td>

                    <td>
                        <?= esc(
                            $row['satker'] ?? '-'
                        ) ?>
                    </td>

                    <td class="center">

                        <?= esc(
                            !empty($row['status'])
                                ? $row['status']
                                : 'BELUM ABSEN'
                        ) ?>

                    </td>

                    <td class="center">

                        <?php if (
                            !empty($row['waktu_masuk'])
                        ): ?>

                            <?php

                            try {

                                echo date(
                                    'H:i',
                                    strtotime(
                                        $row['waktu_masuk']
                                    )
                                );

                            } catch (\Throwable $e) {

                                echo '-';

                            }

                            ?>

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td
                    colspan="7"
                    class="center">

                    Tidak terdapat data kehadiran.

                </td>

            </tr>

        <?php endif; ?>

    </tbody>

</table>


<!-- ================================================================
     REKAPITULASI
================================================================ -->

<div class="section-title">
    REKAPITULASI KEHADIRAN
</div>


<table class="rekap-table">

    <thead>

        <tr>

            <?php foreach (
                $statusAbsensi
                as $status
            ): ?>

                <th>
                    <?= esc($status) ?>
                </th>

            <?php endforeach; ?>

            <th>
                TOTAL
            </th>

        </tr>

    </thead>


    <tbody>

        <tr>

            <?php foreach (
                $statusAbsensi
                as $status
            ): ?>

                <td>

                    <?= (int) (
                        $rekapStatus[$status]
                        ?? 0
                    ) ?>

                </td>

            <?php endforeach; ?>


            <td class="rekap-total">

                <?= $totalKehadiran ?>

            </td>

        </tr>

    </tbody>

</table>


<!-- ================================================================
     POIN HASIL APEL
================================================================ -->

<div class="section-title">
    POIN HASIL APEL
</div>


<table class="apel-table">

    <tr>

        <td class="apel-label">
            Hasil/Poin Apel
        </td>

        <td class="apel-content">

            <?php if (!empty($poinApel)): ?>

                <?= nl2br(
                    esc($poinApel)
                ) ?>

            <?php else: ?>

                -

            <?php endif; ?>

        </td>

    </tr>

</table>


<!-- ================================================================
     TANDA TANGAN
================================================================ -->

<table class="signature-table">

    <tr>

        <td class="signature-left">
            &nbsp;
        </td>

        <td class="signature-right">

            Mengetahui,

            <div class="signature-space">
                &nbsp;
            </div>

            <div class="signature-name">
                __________________________
            </div>

        </td>

    </tr>

</table>


</body>

</html>