<?php

/**
 * View: Laporan Kehadiran Personel
 * File: app/Views/admin/generate-laporan/laporan-personel.php
 */

$logoPoldaSrc = !empty($logoPolda)
    ? 'data:image/png;base64,' . $logoPolda
    : '';

$logoBidTikSrc = !empty($logoBidTik)
    ? 'data:image/png;base64,' . $logoBidTik
    : '';

$tanggalLaporan = $tanggalTampil
    ?? $tanggalFormat
    ?? $tanggal
    ?? '-';

$periode = strtolower(trim((string) ($periode ?? 'harian')));
$isMingguan = $periode === 'mingguan';

$statusAbsensi = is_array($statusAbsensi ?? null)
    ? $statusAbsensi
    : [];

$rekapStatus = is_array($rekapStatus ?? null)
    ? $rekapStatus
    : [];

$dataAbsensi = is_array($dataAbsensi ?? null)
    ? $dataAbsensi
    : [];

$deskripsiKegiatan = trim(
    (string) ($deskripsiKegiatan ?? '')
);

$rekapNormal = [];

foreach ($rekapStatus as $namaStatus => $jumlah) {
    $key = strtoupper(trim((string) $namaStatus));
    $rekapNormal[$key] = (int) $jumlah;
}

$totalKehadiran = 0;

foreach ($statusAbsensi as $status) {
    $key = strtoupper(trim((string) $status));
    $totalKehadiran += (int) ($rekapNormal[$key] ?? 0);
}

$judulPeriode = $isMingguan
    ? 'REKAPITULASI MINGGUAN KEHADIRAN PERSONEL'
    : 'REKAPITULASI HARIAN KEHADIRAN PERSONEL';

$tanggalLabel = $isMingguan
    ? 'PERIODE'
    : 'HARI/TANGGAL';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= esc($title ?? 'Laporan Kehadiran Personel') ?></title>

    <style>
        /* =====================================================
           RESET DAN PENGATURAN UMUM
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
            background: #e5e7eb;
        }

        body {
            font-size: 12px;
            line-height: 1.5;
        }

        img {
            max-width: 100%;
        }

        /* =====================================================
           TOMBOL CETAK
        ===================================================== */

        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            width: 210mm;
            max-width: calc(100% - 24px);
            margin: 15px auto 0;
        }

        .btn-print {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            background: #b5121b;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-print:hover {
            background: #850c13;
        }

        /* =====================================================
           HALAMAN LAPORAN A4 PORTRAIT
        ===================================================== */

        .report-page {
            width: 210mm;
            min-height: 297mm;
            margin: 15px auto;
            padding: 10mm;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        /* =====================================================
           KOP LAPORAN
        ===================================================== */

        .header {
            display: grid;
            grid-template-columns: 65px minmax(0, 1fr) 65px;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 3px solid #b5121b;
        }

        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-bidtik,
        .logo-polda {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .header-center {
            min-width: 0;
            text-align: center;
        }

        .header-title {
            margin: 0;
            color: #171717;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .header-subtitle {
            margin-top: 5px;
            color: #b5121b;
            font-size: 13px;
            font-weight: 700;
        }

        .header-description {
            margin-top: 4px;
            color: #171717;
            font-size: 13px;
            font-weight: 700;
        }

        /* =====================================================
           INFORMASI LAPORAN
        ===================================================== */

        .report-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-top: 15px;
            font-size: 11px;
        }

        .report-info-item {
            min-width: 0;
            flex: 1;
        }

        .report-info strong {
            color: #171717;
        }

        /* =====================================================
           JUDUL BAGIAN
        ===================================================== */

        .section-title {
            margin-top: 16px;
            margin-bottom: 8px;
            padding: 8px 10px;
            background: #171717;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.3px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* =====================================================
           TABEL KEHADIRAN
        ===================================================== */

        .attendance-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #555;
            padding: 6px 4px;
            vertical-align: top;
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .attendance-table th {
            background: #b5121b;
            color: #fff;
            text-align: center;
            font-size: 9.5px;
            font-weight: 700;
            line-height: 1.3;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .attendance-table td {
            font-size: 10px;
            line-height: 1.45;
        }

        .center {
            text-align: center;
        }

        /* Total lebar kolom = 100% */

.col-no {
    width: 4%;
}

.col-nama {
    width: 19%;
}

.col-pangkat {
    width: 12%;
}

.col-nrp {
    width: 12%;
}

.col-subbid {
    width: 11%;
}

.col-ur {
    width: 10%;
}

.col-status {
    width: 11%;
}

.col-keterangan {
    width: 11%;
}

.col-waktu {
    width: 10%;
}

.status {
    display: inline-block;
    max-width: 100%;
    font-weight: 700;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.multiline {
    white-space: pre-line;
    overflow-wrap: anywhere;
    line-height: 1.5;
}

.empty-data {
    padding: 16px !important;
    text-align: center;
    font-style: italic;
    font-size: 11px !important;
}
        /* =====================================================
           TABEL REKAPITULASI
        ===================================================== */

        .rekap-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .rekap-table th,
        .rekap-table td {
            border: 1px solid #555;
            padding: 7px 4px;
            text-align: center;
            overflow-wrap: anywhere;
        }

        .rekap-table th {
            background: #171717;
            color: #fff;
            font-size: 9.5px;
            font-weight: 700;
            line-height: 1.4;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .rekap-table td {
            font-size: 11px;
            font-weight: 700;
        }

        .rekap-table th:last-child {
            background: #b5121b;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .rekap-table td:last-child {
            background: #f3f4f6;
            font-size: 12px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* =====================================================
           DESKRIPSI KEGIATAN
        ===================================================== */

        .activity-box {
            min-height: 55px;
            margin-top: 10px;
            padding: 12px;
            border: 1px solid #555;
        }

        .activity-content {
            font-size: 11px;
            line-height: 1.6;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        /* =====================================================
           TANDA TANGAN
        ===================================================== */

        .footer {
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            width: 100%;
            margin-top: 24px;
            font-size: 11px;
            page-break-inside: avoid;
        }

        .footer-signature {
            width: 230px;
            text-align: center;
            color: #555;
            line-height: 1.6;
        }

        .signature-space {
            height: 50px;
        }

        /* =====================================================
           RESPONSIVE UNTUK LAYAR KECIL
        ===================================================== */

        @media screen and (max-width: 900px) {
            .report-page {
                width: 100%;
                min-height: auto;
                margin: 10px 0;
                padding: 12px;
                overflow-x: auto;
            }

            .attendance-table {
                min-width: 900px;
            }

            .rekap-table {
                min-width: 700px;
            }

            .report-info {
                flex-wrap: wrap;
            }

            .header {
                grid-template-columns: 48px minmax(0, 1fr) 48px;
                gap: 6px;
            }

            .logo-bidtik,
            .logo-polda {
                width: 45px;
                height: 45px;
            }

            .header-title {
                font-size: 14px;
            }

            .header-subtitle,
            .header-description {
                font-size: 10px;
            }

            .footer {
                flex-wrap: wrap;
            }
        }

        /* =====================================================
           CETAK A4 PORTRAIT
        ===================================================== */

        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        @media print {
            html,
            body {
                width: 100%;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            body {
                font-size: 11px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .action-bar {
                display: none !important;
            }

            .report-page {
                width: 100%;
                min-height: 281mm;
                margin: 0 auto;
                padding: 0;
                box-shadow: none;
                overflow: visible;
            }

            .header {
                grid-template-columns: 55px minmax(0, 1fr) 55px;
                gap: 8px;
                padding-bottom: 8px;
            }

            .logo-bidtik,
            .logo-polda {
                width: 50px;
                height: 50px;
            }

            .header-title {
                font-size: 17px;
            }

            .header-subtitle,
            .header-description {
                font-size: 11px;
            }

            .report-info {
                font-size: 10.5px;
            }

            .section-title {
                margin-top: 12px;
                margin-bottom: 6px;
                padding: 6px 8px;
                font-size: 11px;
            }

            .attendance-table th {
                font-size: 8.5px;
            }

            .attendance-table td {
                font-size: 9.5px;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 5px 3px;
            }

            .rekap-table th {
                font-size: 8.5px;
            }

            .rekap-table td {
                font-size: 10.5px;
            }

            .activity-content {
                font-size: 10.5px;
            }

            .section-title,
            .attendance-table th,
            .rekap-table th,
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

            .header,
            .report-info,
            .activity-box,
            .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <!-- Tombol hanya tampil di layar -->
    <div class="action-bar">
        <button
            type="button"
            class="btn-print"
            onclick="window.print()"
        >
            Cetak / Simpan PDF
        </button>
    </div>

    <main class="report-page">

        <!-- KOP LAPORAN -->
        <header class="header">

            <div class="header-left">
                <?php if ($logoBidTikSrc !== ''): ?>
                    <img
                        src="<?= esc($logoBidTikSrc) ?>"
                        class="logo-bidtik"
                        alt="Logo Bid TIK"
                    >
                <?php endif; ?>
            </div>

            <div class="header-center">
                <h1 class="header-title">
                    LAPORAN KEHADIRAN PERSONEL
                </h1>

                <div class="header-subtitle">
                    BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI
                </div>

                <div class="header-description">
                    POLDA JAWA TIMUR
                </div>
            </div>

            <div class="header-right">
                <?php if ($logoPoldaSrc !== ''): ?>
                    <img
                        src="<?= esc($logoPoldaSrc) ?>"
                        class="logo-polda"
                        alt="Logo Polda Jawa Timur"
                    >
                <?php endif; ?>
            </div>

        </header>

        <!-- INFORMASI PERIODE -->
        <div class="report-info">

            <div class="report-info-item">
                <strong><?= esc($tanggalLabel) ?>:</strong>
                <?= esc($tanggalFormat ?? $tanggalLaporan) ?>
            </div>

            <div class="report-info-item">
                <strong>Jenis Laporan:</strong>
                <?= esc($judulPeriode) ?>
            </div>

        </div>

        <!-- DATA KEHADIRAN -->
        <div class="section-title">
            DATA KEHADIRAN PERSONEL
        </div>

        <table class="attendance-table">
            <thead>
                <tr>
                    <th class="col-no">NO</th>
                    <th class="col-nama">NAMA</th>
                    <th class="col-pangkat">PANGKAT</th>
                    <th class="col-nrp">NRP/NIP</th>
                    <th class="col-subbid">SUBBID</th>
                    <th class="col-ur">UR</th>
                    <th class="col-status">STATUS</th>
                    <th class="col-keterangan">KETERANGAN</th>
                    <th class="col-waktu">WAKTU</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dataAbsensi)): ?>

                    <?php foreach ($dataAbsensi as $index => $row): ?>

                        <?php
                        $waktuRaw = trim(
                            (string) ($row['waktu_masuk'] ?? '')
                        );

                        $waktuTampil = '-';

                        if ($waktuRaw !== '') {
                            if ($isMingguan) {
                                $waktuTampil = $waktuRaw;
                            } else {
                                $timestamp = strtotime($waktuRaw);

                                if ($timestamp !== false) {
                                    $waktuTampil = date(
                                        'H:i',
                                        $timestamp
                                    );
                                } else {
                                    $waktuTampil = $waktuRaw;
                                }
                            }
                        }

                        $statusTampil = trim(
                            (string) ($row['status'] ?? '')
                        );

                        if ($statusTampil === '') {
                            $statusTampil = 'BELUM ABSEN';
                        }

                        $keteranganTampil = trim(
                            (string) ($row['keterangan'] ?? '')
                        );

                        if ($keteranganTampil === '') {
                            $keteranganTampil = '-';
                        }
                        ?>

                        <tr>
                            <td class="center">
                                <?= $index + 1 ?>
                            </td>

                            <td>
                                <?= esc($row['nama'] ?? '-') ?>
                            </td>

                            <td>
                                <?= esc($row['pangkat'] ?? '-') ?>
                            </td>

                            <td>
                                <?= esc($row['nrp_nip'] ?? '-') ?>
                            </td>

                            <td>
                                <?= esc($row['subbid'] ?? '-') ?>
                            </td>

                            <td>
                                <?= esc($row['ur'] ?? '-') ?>
                            </td>

                            <td class="center multiline">
                                <span class="status">
                                    <?= esc($statusTampil) ?>
                                </span>
                            </td>

                            <td class="multiline">
                                <?= esc($keteranganTampil) ?>
                            </td>

                            <td class="center multiline">
                                <?= esc($waktuTampil) ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="9" class="empty-data">
                            Tidak terdapat data kehadiran.
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>

        <!-- REKAPITULASI -->
        <div class="section-title">
            REKAPITULASI KEHADIRAN
        </div>

        <table class="rekap-table">
            <thead>
                <tr>
                    <?php foreach ($statusAbsensi as $status): ?>
                        <th>
                            <?= esc($status) ?>
                        </th>
                    <?php endforeach; ?>

                    <th>
                        <?= $isMingguan ? 'TOTAL PRESENSI' : 'TOTAL' ?>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <?php foreach ($statusAbsensi as $status): ?>

                        <?php
                        $statusKey = strtoupper(
                            trim((string) $status)
                        );

                        $jumlahStatus = (int) (
                            $rekapNormal[$statusKey] ?? 0
                        );
                        ?>

                        <td>
                            <?= $jumlahStatus ?>
                        </td>

                    <?php endforeach; ?>

                    <td>
                        <?= $totalKehadiran ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- DESKRIPSI KEGIATAN -->
        <div class="section-title">
            DESKRIPSI KEGIATAN
        </div>

        <div class="activity-box">
            <div class="activity-content">
                <?php if ($deskripsiKegiatan !== ''): ?>
                    <?= nl2br(esc($deskripsiKegiatan)) ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </div>
        </div>

        <!-- TANDA TANGAN -->
        <footer class="footer">
            <div class="footer-signature">
                Mengetahui,

                <div class="signature-space"></div>

                <strong>________________________</strong>
            </div>
        </footer>

    </main>

</body>
</html>