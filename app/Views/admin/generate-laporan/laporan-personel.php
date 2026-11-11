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
$isBulanan = $periode === 'bulanan';
$tanggalBulanan = is_array($tanggalBulanan ?? null) ? $tanggalBulanan : [];
$tanggalGrid = is_array($tanggalGrid ?? null) ? $tanggalGrid : [];

// Kolom laporan mingguan/bulanan hanya hari kerja (Senin-Jumat).
$namaHariIndonesia = [
    1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
    4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
];
$tanggalGridHariKerja = array_values(array_filter(
    $tanggalGrid,
    static function ($kolom): bool {
        $tanggalKolom = (string) ($kolom['tanggal'] ?? '');
        if ($tanggalKolom === '') {
            return false;
        }
        $nomorHari = (int) date('N', strtotime($tanggalKolom));
        return $nomorHari >= 1 && $nomorHari <= 5;
    }
));

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
$kegiatanPeriode = is_array($kegiatanPeriode ?? null)
    ? $kegiatanPeriode
    : (is_array($poinApel ?? null) ? $poinApel : []);

// Total kode bulanan dihitung dari rekap_kode tiap personel agar tidak
// bergantung pada variabel yang belum tentu dikirim oleh Controller.
$totalKodeBulanan = array_fill_keys(['H', 'D', 'LD', 'C', 'I', 'S', 'T', 'DIK', 'BKO'], 0);
foreach ($dataAbsensi as $barisAbsensi) {
    $rekapKodePersonel = is_array($barisAbsensi['rekap_kode'] ?? null)
        ? $barisAbsensi['rekap_kode']
        : [];
    foreach ($totalKodeBulanan as $kode => $nilaiAwal) {
        $totalKodeBulanan[$kode] += (int) ($rekapKodePersonel[$kode] ?? 0);
    }
}

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

$judulPeriode = $isBulanan
    ? 'REKAPITULASI BULANAN KEHADIRAN PERSONEL'
    : ($isMingguan
        ? 'REKAPITULASI MINGGUAN KEHADIRAN PERSONEL'
        : 'REKAPITULASI HARIAN KEHADIRAN PERSONEL');

$tanggalLabel = ($isMingguan || $isBulanan) ? 'PERIODE' : 'HARI/TANGGAL';

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
            width: <?= $isBulanan ? '297mm' : '210mm' ?>;
            min-height: <?= $isBulanan ? '210mm' : '297mm' ?>;
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


/* Khusus tabel laporan harian/personel: SUBBID dan UR rapi,
   membungkus teks pada spasi dan tidak memengaruhi tabel mingguan/bulanan. */
.attendance-table th.col-subbid,
.attendance-table td.col-subbid,
.attendance-table th.col-ur,
.attendance-table td.col-ur {
    white-space: normal !important;
    word-break: normal !important;
    overflow-wrap: break-word !important;
    hyphens: none;
    text-align: center;
    vertical-align: middle;
    padding: 5px 3px;
    line-height: 1.3;
}

.attendance-table td.col-subbid,
.attendance-table td.col-ur {
    font-size: 9px;
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

        .period-grid-table,
        .period-total-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0;
        }

        .period-total-table {
            margin-top: 2px;
        }

        .period-grid-table th,
        .period-grid-table td,
        .period-total-table th,
        .period-total-table td {
            border: 1px solid #555;
            padding: 4px 3px;
            vertical-align: middle;
        }

        .period-grid-table th,
        .period-total-table th {
            background: #b5121b;
            color: #fff;
            text-align: center;
            font-size: 8px;
            font-weight: 700;
            line-height: 1.15;
            white-space: normal;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .period-grid-table td,
        .period-total-table td {
            font-size: 8px;
            line-height: 1.2;
        }

        .period-grid-table .person-name,
        .period-total-table .person-name {
            text-align: left;
            overflow-wrap: anywhere;
        }

        .period-grid-table .center,
        .period-total-table .center {
            text-align: center;
        }

        .period-total-table .grand-total td {
            background: #f3f4f6;
            font-weight: 700;
        }

        .period-legend {
            margin-top: 4px;
            font-size: 9px;
            line-height: 1.35;
        }

        .monthly-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 8px;
        }
        .monthly-table th, .monthly-table td {
            border: 1px solid #333;
            padding: 3px 2px;
            text-align: center;
            font-size: 7px;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }
        .monthly-table th {
            background: #b5121b;
            color: #fff;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .monthly-table .person-name {
            text-align: left;
            width: 120px;
            font-size: 7.5px;
        }
        .monthly-table .person-nrp {
            width: 70px;
            font-size: 7px;
        }
        .monthly-table .day-col { width: 17px; }
        .monthly-summary { margin-top: 10px; }
        .monthly-summary th, .monthly-summary td { font-size: 8px; padding: 4px; }
        /* Tabel kegiatan mingguan/bulanan: garis luar dan garis setiap sel wajib terlihat saat cetak/PDF. */
        table.activity-table {
            width: 100%;
            border-collapse: collapse !important;
            table-layout: fixed;
            margin-top: 8px;
            border: 1px solid #333 !important;
        }
        table.activity-table th,
        table.activity-table td {
            border: 1px solid #333 !important;
            padding: 6px 7px;
            vertical-align: top;
            text-align: left;
            font-size: 9px;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }
        table.activity-table th { text-align: center; }
        table.activity-table th:first-child,
        table.activity-table td:first-child { width: 24%; text-align: center; }
        .code-legend { margin-top: 8px; font-size: 9px; line-height: 1.6; }

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
            size: <?= $isBulanan ? 'A4 landscape' : 'A4 portrait' ?>;
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

        <?php if ($isMingguan): ?>
            <?php
            $jumlahTanggalGrid = count($tanggalGridHariKerja);
            $lebarTanggalGrid = $jumlahTanggalGrid > 0 ? (61.37 / $jumlahTanggalGrid) : 0;

            // Kelompokkan tanggal mingguan ke label minggu keberapa dalam bulan.
            // Minggu kerja dihitung Senin-Jumat, mengikuti kalender bulan.
            $kelompokMingguGrid = [];
            foreach ($tanggalGridHariKerja as $kolomTanggalMinggu) {
                $tanggalMinggu = (string) ($kolomTanggalMinggu['tanggal'] ?? '');
                if ($tanggalMinggu === '') {
                    continue;
                }
                $objTanggalMinggu = new DateTimeImmutable($tanggalMinggu);
                $awalBulanMinggu = $objTanggalMinggu->modify('first day of this month');
                $hariAwalBulanMinggu = (int) $awalBulanMinggu->format('N');
                $hariKerjaPertama = $hariAwalBulanMinggu <= 5
                    ? 1
                    : 1 + (8 - $hariAwalBulanMinggu);
                $nomorMingguTampil = (int) floor(((int) $objTanggalMinggu->format('j') - $hariKerjaPertama) / 7) + 1;
                $nomorMingguTampil = max(1, $nomorMingguTampil);
                $keyMingguTampil = $objTanggalMinggu->format('Y-m') . '-' . $nomorMingguTampil;
                if (!isset($kelompokMingguGrid[$keyMingguTampil])) {
                    $kelompokMingguGrid[$keyMingguTampil] = [
                        'label' => 'MINGGU KE-' . $nomorMingguTampil,
                        'jumlah' => 0,
                    ];
                }
                $kelompokMingguGrid[$keyMingguTampil]['jumlah']++;
            }

            $kodePeriode = ['H', 'D', 'LD', 'C', 'I', 'S', 'T', 'DIK', 'BKO'];
            $totalKodePeriode = array_fill_keys($kodePeriode, 0);
            ?>
            <div class="section-title">A. REKAPITULASI KEHADIRAN MINGGUAN</div>
            <table class="period-grid-table">
                <colgroup>
                    <col style="width:4.09%">
                    <col style="width:21.36%">
                    <col style="width:13.18%">
                    <?php foreach ($tanggalGridHariKerja as $kolomTanggal): ?>
                        <col style="width:<?= number_format($lebarTanggalGrid, 3, '.', '') ?>%">
                    <?php endforeach; ?>
                </colgroup>
                <thead>
                    <tr>
                        <th rowspan="2">NO</th><th rowspan="2">NAMA / PANGKAT</th><th rowspan="2">NRP/NIP</th>
                        <?php foreach ($kelompokMingguGrid as $kelompokMinggu): ?>
                            <th colspan="<?= (int) $kelompokMinggu['jumlah'] ?>"><?= esc($kelompokMinggu['label']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <?php foreach ($tanggalGridHariKerja as $kolomTanggal): ?>
                            <?php
                            $tanggalHeader = (string) ($kolomTanggal['tanggal'] ?? '');
                            $nomorHariHeader = $tanggalHeader !== '' ? (int) date('N', strtotime($tanggalHeader)) : 0;
                            $labelHariHeader = (string) ($kolomTanggal['nama_hari'] ?? ($namaHariIndonesia[$nomorHariHeader] ?? ''));
                            $labelTanggalHeader = (string) ($kolomTanggal['hari'] ?? ($tanggalHeader !== '' ? date('j', strtotime($tanggalHeader)) : ''));
                            ?>
                            <th><?= esc($labelTanggalHeader) ?> (<?= esc($labelHariHeader) ?>)</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataAbsensi)): ?>
                        <?php foreach ($dataAbsensi as $i => $row): ?>
                            <tr>
                                <td class="center"><?= $i + 1 ?></td>
                                <td class="person-name"><?= esc(trim((string) ($row['pangkat'] ?? '') . ' ' . (string) ($row['nama'] ?? '-'))) ?></td>
                                <td class="center"><?= esc($row['nrp_nip'] ?? '-') ?></td>
                                <?php foreach ($tanggalGridHariKerja as $kolomTanggal): ?>
                                    <?php $tanggalGridKey = (string) ($kolomTanggal['tanggal'] ?? ''); ?>
                                    <td class="center"><?= esc($row['status_harian'][$tanggalGridKey] ?? $row['status_harian'][(int) ($kolomTanggal['hari'] ?? ($tanggalGridKey !== '' ? date('j', strtotime($tanggalGridKey)) : 0))] ?? '-') ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="<?= 3 + $jumlahTanggalGrid ?>" class="center">Tidak terdapat data personel.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="section-title">B. TOTAL PRESENSI PER PERSONEL</div>
            <table class="period-total-table">
                <colgroup>
                    <col style="width:3.64%">
                    <col style="width:28.18%">
                    <?php for ($i = 0; $i < count($kodePeriode); $i++): ?>
                        <col style="width:6.9%">
                    <?php endfor; ?>
                    <col style="width:6%">
                </colgroup>
                <thead><tr><th>NO</th><th>NAMA</th>
                    <?php foreach ($kodePeriode as $kode): ?><th><?= esc($kode) ?></th><?php endforeach; ?>
                    <th>JUMLAH HADIR</th>
                </tr></thead>
                <tbody>
                    <?php foreach ($dataAbsensi as $i => $row): ?>
                        <tr>
                            <td class="center"><?= $i + 1 ?></td>
                            <td class="person-name"><?= esc(trim((string) ($row['pangkat'] ?? '') . ' ' . (string) ($row['nama'] ?? '-'))) ?></td>
                            <?php foreach ($kodePeriode as $kode): ?>
                                <?php $jumlahKode = (int) ($row['rekap_kode'][$kode] ?? 0); $totalKodePeriode[$kode] += $jumlahKode; ?>
                                <td class="center"><?= $jumlahKode ?></td>
                            <?php endforeach; ?>
                            <td class="center"><strong><?= (int) ($row['rekap_kode']['H'] ?? 0) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="grand-total">
                        <td colspan="2" class="center">TOTAL SELURUH PERSONEL</td>
                        <?php foreach ($kodePeriode as $kode): ?><td class="center"><?= $totalKodePeriode[$kode] ?></td><?php endforeach; ?>
                        <td class="center"><strong><?= (int) ($totalKodePeriode['H'] ?? 0) ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="section-title">KETERANGAN KODE</div>
            <div class="period-legend">H = Hadir; D = Dinas; LD = Lepas Dinas; C = Cuti; I = Izin; S = Sakit; T = Terlambat; DIK = Pendidikan; BKO = Bawah Kendali Operasi.</div>

        <?php elseif ($isBulanan): ?>
            <?php
            // Bulanan: hanya Senin-Jumat, dikelompokkan menjadi minggu kerja.
            $kolomTanggalBulan = array_values(array_filter($tanggalGridHariKerja, static function ($kolom) {
                $tanggalKolom = (string) ($kolom['tanggal'] ?? '');
                return $tanggalKolom !== '' && (int) date('N', strtotime($tanggalKolom)) <= 5;
            }));
            $jumlahTanggalBulan = count($kolomTanggalBulan);
            $lebarTanggalBulan = $jumlahTanggalBulan > 0 ? (79.667 / $jumlahTanggalBulan) : 0;
            $kelompokMingguBulan = [];
            foreach ($kolomTanggalBulan as $kolomBulan) {
                $nomorMingguBulan = (int) ($kolomBulan['minggu'] ?? 1);
                $kelompokMingguBulan[$nomorMingguBulan] = ($kelompokMingguBulan[$nomorMingguBulan] ?? 0) + 1;
            }
            $kodePeriode = ['H', 'D', 'LD', 'C', 'I', 'S', 'T', 'DIK', 'BKO'];
            $totalKodePeriode = array_fill_keys($kodePeriode, 0);
            ?>
            <div class="section-title">A. REKAPITULASI KEHADIRAN BULANAN</div>
            <table class="period-grid-table" style="width:94.15%">
                <colgroup>
                    <col style="width:2.333%"><col style="width:12%"><col style="width:6%">
                    <?php foreach ($kolomTanggalBulan as $kolomBulan): ?>
                        <col style="width:<?= number_format($lebarTanggalBulan, 3, '.', '') ?>%">
                    <?php endforeach; ?>
                </colgroup>
                <thead>
                    <tr>
                        <th rowspan="2">NO</th><th rowspan="2">NAMA / PANGKAT</th><th rowspan="2">NRP/NIP</th>
                        <?php foreach ($kelompokMingguBulan as $nomorMingguBulan => $jumlahKolomMinggu): ?>
                            <th colspan="<?= (int) $jumlahKolomMinggu ?>">MINGGU KE-<?= (int) $nomorMingguBulan ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <?php foreach ($kolomTanggalBulan as $kolomBulan): ?>
                            <?php
                            $tanggalKolom = (string) ($kolomBulan['tanggal'] ?? '');
                            $namaHariKolom = $kolomBulan['nama_hari'] ?? '';
                            if ($namaHariKolom === '' && $tanggalKolom !== '') {
                                $namaHariIndonesia = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat'];
                                $namaHariKolom = $namaHariIndonesia[(int) date('N', strtotime($tanggalKolom))] ?? '';
                            }
                            ?>
                            <th><?= (int) ($kolomBulan['hari'] ?? 0) ?> (<?= esc((string) $namaHariKolom) ?>)</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataAbsensi)): ?>
                        <?php foreach ($dataAbsensi as $i => $row): ?>
                            <tr>
                                <td class="center"><?= $i + 1 ?></td>
                                <td class="person-name"><?= esc(trim((string) ($row['pangkat'] ?? '') . ' ' . (string) ($row['nama'] ?? '-'))) ?></td>
                                <td class="center"><?= esc($row['nrp_nip'] ?? '-') ?></td>
                                <?php foreach ($kolomTanggalBulan as $kolomBulan): ?>
                                    <?php
                                    $tanggalStatus = (string) ($kolomBulan['tanggal'] ?? '');
                                    $hariStatus = (int) ($kolomBulan['hari'] ?? ($tanggalStatus !== '' ? date('j', strtotime($tanggalStatus)) : 0));
                                    ?>
                                    <td class="center"><?= esc($row['status_harian'][$tanggalStatus] ?? $row['status_harian'][$hariStatus] ?? '-') ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="<?= 3 + $jumlahTanggalBulan ?>" class="center">Tidak terdapat data personel.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="section-title">B. TOTAL PRESENSI PER PERSONEL</div>
            <table class="period-total-table" style="width:94.15%">
                <colgroup>
                    <col style="width:3%"><col style="width:24%">
                    <?php for ($i = 0; $i < count($kodePeriode); $i++): ?><col style="width:7.2%"><?php endfor; ?>
                    <col style="width:6%">
                </colgroup>
                <thead><tr><th>NO</th><th>NAMA</th>
                    <?php foreach ($kodePeriode as $kode): ?><th><?= esc($kode) ?></th><?php endforeach; ?>
                    <th>JUMLAH HADIR</th>
                </tr></thead>
                <tbody>
                    <?php foreach ($dataAbsensi as $i => $row): ?>
                        <tr>
                            <td class="center"><?= $i + 1 ?></td>
                            <td class="person-name"><?= esc(trim((string) ($row['pangkat'] ?? '') . ' ' . (string) ($row['nama'] ?? '-'))) ?></td>
                            <?php foreach ($kodePeriode as $kode): ?>
                                <?php $jumlahKode = (int) ($row['rekap_kode'][$kode] ?? 0); $totalKodePeriode[$kode] += $jumlahKode; ?>
                                <td class="center"><?= $jumlahKode ?></td>
                            <?php endforeach; ?>
                            <td class="center"><strong><?= (int) ($row['rekap_kode']['H'] ?? 0) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="grand-total">
                        <td colspan="2" class="center">TOTAL SELURUH PERSONEL</td>
                        <?php foreach ($kodePeriode as $kode): ?><td class="center"><?= $totalKodePeriode[$kode] ?></td><?php endforeach; ?>
                        <td class="center"><strong><?= (int) ($totalKodePeriode['H'] ?? 0) ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="section-title">KETERANGAN KODE</div>
            <div class="period-legend">H = Hadir; D = Dinas; LD = Lepas Dinas; C = Cuti; I = Izin; S = Sakit; T = Terlambat; DIK = Pendidikan; BKO = Bawah Kendali Operasi.</div>

        <?php else: ?>
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
                    <th class="col-keterangan"<?= (!$isMingguan && !$isBulanan) ? ' style="white-space: nowrap; font-size: 8px; letter-spacing: -0.2px;"' : '' ?>>KETERANGAN</th>
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

                            <td class="col-subbid">
                                <?= esc(trim((string) ($row['subbid'] ?? '-'))) ?>
                            </td>

                            <td class="col-ur">
                                <?= esc(trim((string) ($row['ur'] ?? '-'))) ?>
                            </td>

                            <td class="center multiline">
                                <span class="status">
                                    <?= esc($statusTampil) ?>
                                </span>
                            </td>

                            <td class="multiline">
                                <?= esc($keteranganTampil) ?>
                            </td>

                            <td class="center multiline col-waktu">
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

        <?php endif; ?>

        <?php if (!$isMingguan && !$isBulanan): ?>
        <!-- REKAPITULASI -->
        <div class="section-title">
            REKAPITULASI KEHADIRAN
        </div>

        <table class="rekap-table">
            <thead>
                <tr>
                    <?php foreach ($statusAbsensi as $status): ?>
                        <th><?= esc($status) ?></th>
                    <?php endforeach; ?>
                    <th><?= ($isMingguan || $isBulanan) ? 'TOTAL PRESENSI' : 'TOTAL' ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    // Untuk laporan bulanan, rekap wajib memakai sumber yang sama
                    // dengan tabel harian: kode yang benar-benar tampil per personel.
                    $kodeStatusBulanan = [
                        'HADIR' => 'H',
                        'DINAS LUAR' => 'D',
                        'LEPAS DINAS' => 'LD',
                        'CUTI' => 'C',
                        'IZIN' => 'I',
                        'SAKIT' => 'S',
                        'TERLAMBAT' => 'T',
                        'DIK' => 'DIK',
                        'PENDIDIKAN' => 'DIK',
                        'BKO' => 'BKO',
                    ];
                    $totalRekapBulanan = 0;
                    ?>
                    <?php foreach ($statusAbsensi as $status): ?>
                        <?php
                        $statusKey = strtoupper(trim((string) $status));
                        if ($isBulanan) {
                            $kode = $kodeStatusBulanan[$statusKey] ?? null;
                            $jumlahStatus = $kode !== null
                                ? (int) ($totalKodeBulanan[$kode] ?? 0)
                                : 0;
                        } else {
                            $jumlahStatus = (int) ($rekapNormal[$statusKey] ?? 0);
                        }
                        $totalRekapBulanan += $jumlahStatus;
                        ?>
                        <td><?= $jumlahStatus ?></td>
                    <?php endforeach; ?>
                    <td><?= $isBulanan ? $totalRekapBulanan : $totalKehadiran ?></td>
                </tr>
            </tbody>
        </table>

        <!-- DESKRIPSI KEGIATAN -->
        <div class="section-title">
            DESKRIPSI KEGIATAN
        </div>

        <?php if ($isMingguan || $isBulanan): ?>
            <table class="monthly-total-table activity-table">
                <thead><tr><th style="width: 24%">TANGGAL</th><th>KEGIATAN / POIN APEL</th></tr></thead>
                <tbody>
                <?php if (!empty($kegiatanPeriode)): ?>
                    <?php foreach ($kegiatanPeriode as $itemKegiatan): ?>
                        <tr>
                            <td><?= esc(!empty($itemKegiatan['tanggal']) ? date('d/m/Y', strtotime($itemKegiatan['tanggal'])) : '-') ?></td>
                            <td><?= nl2br(esc(trim((string) ($itemKegiatan['deskripsi'] ?? '-')) ?: '-')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif ($deskripsiKegiatan !== ''): ?>
                    <tr>
                        <td>RANGKUMAN</td>
                        <td><?= nl2br(esc($deskripsiKegiatan)) ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="2">Tidak ada deskripsi kegiatan pada periode ini.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="activity-box"><div class="activity-content">
                <?= $deskripsiKegiatan !== '' ? nl2br(esc($deskripsiKegiatan)) : '-' ?>
            </div></div>
        <?php endif; ?>

        <?php endif; ?>

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