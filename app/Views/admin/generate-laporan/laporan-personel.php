
<?php
/**
 * View: Laporan Kehadiran Personel
 * Fungsi:
 * - Menampilkan laporan dalam ukuran A4
 * - Otomatis membuka dialog Print
 * - Mendukung Print / Save as PDF / Cancel
 * - Menampilkan total seluruh jumlah status kehadiran
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
        <?= esc($title ?? 'Laporan Kehadiran Personel') ?>
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #e5e7eb;
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
        }

        body {
            font-size: 12px;
        }

        /* =========================
           AREA LAPORAN
        ========================== */

        .report-page {
            width: 210mm;
            min-height: 297mm;
            margin: 15px auto;
            padding: 15mm 15mm 18mm 15mm;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        /* =========================
           ACTION BAR
        ========================== */

        .action-bar {
            width: 210mm;
            margin: 15px auto 0;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-print {
            border: none;
            background: #b5121b;
            color: #fff;
            padding: 9px 18px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-print:hover {
            background: #850c13;
        }

        /* =========================
           HEADER
        ========================== */

        .header {
            width: 100%;
            display: grid;
            grid-template-columns: 90px 1fr 90px;
            align-items: center;
            column-gap: 15px;
            padding-bottom: 10px;
            border-bottom: 3px solid #b5121b;
        }

        .header-left {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .header-center {
            text-align: center;
        }

        .header-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .logo-bidtik {
            width: 75px;
            height: 75px;
            object-fit: contain;
        }

        .logo-polda {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .header-title {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: #171717;
        }

        .header-subtitle {
            margin-top: 5px;
            font-size: 13px;
            font-weight: bold;
            color: #b5121b;
        }

        .header-description {
            margin-top: 3px;
            font-size: 11px;
            color: #555;
        }

        /* =========================
           INFORMASI LAPORAN
        ========================== */

        .report-info {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }

        .report-info strong {
            color: #171717;
        }

        /* =========================
           JUDUL SECTION
        ========================== */

        .section-title {
            margin-top: 18px;
            margin-bottom: 8px;
            padding: 7px 10px;
            background: #171717;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
        }

        /* =========================
           TABEL DATA
        ========================== */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 6px 5px;
            vertical-align: middle;
        }

        th {
            background: #b5121b;
            color: #fff;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }

        td {
            font-size: 10px;
        }

        td.center {
            text-align: center;
        }

        .col-no {
            width: 5%;
        }

        .col-nrp {
            width: 14%;
        }

        .col-nama {
            width: 21%;
        }

        .col-pangkat {
            width: 13%;
        }

        .col-unit {
            width: 19%;
        }

        .col-status {
            width: 15%;
        }

        .col-waktu {
            width: 13%;
        }

        /* =========================
           STATUS
        ========================== */

        .status {
            display: inline-block;
            font-weight: bold;
            text-align: center;
        }

        /* =========================
           REKAP
        ========================== */

        .rekap-table th {
            background: #171717;
            font-size: 9px;
            padding: 6px 3px;
        }

        .rekap-table td {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            padding: 7px 3px;
        }

        /*
         * Kolom TOTAL dibuat sedikit lebih tegas
         * tetapi tetap mengikuti desain laporan.
         */

        .rekap-table th:last-child {
            background: #b5121b;
        }

        .rekap-table td:last-child {
            background: #f3f4f6;
            font-size: 12px;
            font-weight: bold;
        }

        /* =========================
           POIN APEL
        ========================== */

        .apel-box {
            margin-top: 15px;
            border: 1px solid #555;
            padding: 10px;
            min-height: 55px;
        }

        .apel-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .apel-content {
            line-height: 1.5;
        }

        /* =========================
           FOOTER
        ========================== */

        .footer {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 10px;
        }

        .footer-left {
            color: #555;
        }

        .footer-right {
            text-align: center;
            min-width: 170px;
        }

        .signature-space {
            height: 55px;
        }

        /* =========================
           PRINT
        ========================== */

        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            .action-bar {
                display: none !important;
            }

            .report-page {
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 15mm 15mm 18mm 15mm;
                box-shadow: none;
            }

            .section-title,
            th,
            .rekap-table td:last-child {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

    </style>

</head>

<body>

    <!-- =========================
         TOMBOL PRINT
    ========================== -->

    <div class="action-bar">

        <button
            type="button"
            class="btn-print"
            onclick="window.print()">

            🖨 Print

        </button>

    </div>


    <!-- =========================
         HALAMAN LAPORAN
    ========================== -->

    <div class="report-page">


        <!-- =========================
             HEADER
        ========================== -->

        <div class="header">

            <div class="header-left">

                <?php if (!empty($logoBidTikSrc)): ?>

                    <img
                        src="<?= $logoBidTikSrc ?>"
                        class="logo-bidtik"
                        alt="Logo Bid TIK">

                <?php endif; ?>

            </div>


            <div class="header-center">

                <h1 class="header-title">
                    LAPORAN KEHADIRAN PERSONEL
                </h1>

                <div class="header-subtitle">
                    BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI
                </div>

               <div class="subtitle">
    <strong>POLDA JAWA TIMUR</strong>
</div>

            </div>


            <div class="header-right">

                <?php if (!empty($logoPoldaSrc)): ?>

                    <img
                        src="<?= $logoPoldaSrc ?>"
                        class="logo-polda"
                        alt="Logo Polda Jawa Timur">

                <?php endif; ?>

            </div>

        </div>


        <!-- =========================
             INFORMASI LAPORAN
        ========================== -->

        <div class="report-info">

            <div>

                <strong>Tanggal:</strong>

                <?= esc(
                    $tanggalFormat ??
                    $tanggal ??
                    '-'
                ) ?>

            </div>


            <div>

                <strong>Jenis Laporan:</strong>

                Rekapitulasi Kehadiran Personel

            </div>

        </div>


        <!-- =========================
             DATA KEHADIRAN
        ========================== -->

        <div class="section-title">
            DATA KEHADIRAN PERSONEL
        </div>


        <table>

            <thead>

                <tr>

                    <th class="col-no">
                        No.
                    </th>

                    <th class="col-nrp">
                        NRP/NIP
                    </th>

                    <th class="col-nama">
                        Nama
                    </th>

                    <th class="col-pangkat">
                        Pangkat
                    </th>

                    <th class="col-unit">
                        Unit Kerja
                    </th>

                    <th class="col-status">
                        Status
                    </th>

                    <th class="col-waktu">
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

                                <span class="status">

                                    <?= esc(
                                        $row['status']
                                        ?? 'BELUM ABSEN'
                                    ) ?>

                                </span>

                            </td>


                            <td class="center">

                                <?php if (
                                    !empty(
                                        $row['waktu_masuk']
                                    )
                                ): ?>

                                    <?php

                                    try {

                                        echo date(
                                            'H:i',
                                            strtotime(
                                                $row['waktu_masuk']
                                            )
                                        );

                                    } catch (
                                        \Throwable $e
                                    ) {

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


        <!-- =========================
             REKAPITULASI
        ========================== -->

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


                    <!-- TOTAL -->

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


                    <!-- TOTAL JUMLAH -->

                    <td>

                        <?= $totalKehadiran ?>

                    </td>

                </tr>

            </tbody>

        </table>


        <!-- =========================
             POIN APEL
        ========================== -->

        <div class="section-title">
            POIN HASIL APEL
        </div>


        <div class="apel-box">

            <div class="apel-title">
                Hasil/Poin Apel:
            </div>


            <div class="apel-content">

                <?php if (!empty($poinApel)): ?>

                    <?= nl2br(
                        esc($poinApel)
                    ) ?>

                <?php else: ?>

                    -

                <?php endif; ?>

            </div>

        </div>


        <!-- =========================
             FOOTER
        ========================== -->

        <div class="footer">

            <div class="footer-left">

                Sistem Rekapitulasi dan Pelaporan Data
                Kehadiran Personel Bidang TIK
                Polda Jawa Timur

            </div>


            <div class="footer-right">

                Mengetahui,

                <div class="signature-space"></div>

                <strong>
                    __________________________
                </strong>

            </div>

        </div>

    </div>


    <!-- =========================
         OTOMATIS BUKA PRINT
    ========================== -->

    <script>

        window.addEventListener(
            'load',
            function () {

                setTimeout(
                    function () {

                        window.print();

                    },
                    500
                );

            }
        );

    </script>

</body>

</html>
```
