
<?php
/**
 * LAPORAN KEHADIRAN PERSONEL
 * Bidang TIK Polda Jawa Timur
 * Format Word - A4 Portrait
 */

$tanggalTampil = $tanggalFormat ?? $tanggal ?? $tanggalLaporan ?? '-';

$dataAbsensi = $dataAbsensi ?? [];
$rekapStatus = $rekapStatus ?? [];
$deskripsiKegiatan = $deskripsiKegiatan ?? '';
$poinApel = $poinApel ?? '';

/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/

if (!function_exists('wordEscape')) {
    function wordEscape($value): string
    {
        return htmlspecialchars(
            (string) ($value ?? '-'),
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }
}

if (!function_exists('wordImage')) {
    function wordImage(string $path): string
    {
        if (!is_file($path)) {
            return '';
        }

        $mime = function_exists('mime_content_type')
            ? mime_content_type($path)
            : 'image/png';

        $mime = $mime ?: 'image/png';

        return 'data:' . $mime . ';base64,' .
            base64_encode(file_get_contents($path));
    }
}

/*
|--------------------------------------------------------------------------
| Logo
|--------------------------------------------------------------------------
| Sesuaikan nama file dengan logo yang tersedia di folder assets/img.
*/

$logoBidTIKPath = FCPATH . 'assets/img/LOGO_BID_TIK.png';
$logoPoldaPath = FCPATH . 'assets/img/LOGO_POLDA_JATIM.png';

$logoBidTIK = wordImage($logoBidTIKPath);
$logoPolda = wordImage($logoPoldaPath);

/*
|--------------------------------------------------------------------------
| Fungsi pembacaan nilai
|--------------------------------------------------------------------------
*/

$getValue = static function (array $row, array $keys, $default = '-') {
    foreach ($keys as $key) {
        if (array_key_exists($key, $row) && $row[$key] !== null) {
            return $row[$key];
        }
    }

    return $default;
};

$jumlahPersonel = count($dataAbsensi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran Personel Bid TIK Polda Jawa Timur</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm 0.9cm 1.2cm 0.9cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #171717;
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
        }

        /* KOP LAPORAN */

        .kop {
            width: 100%;
            table-layout: fixed;
        }

        .kop td {
            border: none;
            vertical-align: middle;
            text-align: center;
            padding: 2px;
        }

        .kolom-logo {
            width: 17%;
        }

        .kolom-judul {
            width: 66%;
        }

        .logo {
            width: 62px;
            height: 62px;
        }

        .judul-utama {
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.4;
        }

        .judul-instansi {
            font-size: 8.5pt;
            font-weight: bold;
            line-height: 1.5;
        }

        .garis-kop {
            border: none;
            border-top: 2px solid #171717;
            margin: 8px 0 12px;
        }

        /* INFORMASI TANGGAL */

        .tanggal {
            font-size: 9pt;
            font-weight: bold;
            margin: 8px 0 12px;
        }

        /* JUDUL BAGIAN */

        .judul-bagian {
            font-size: 9pt;
            font-weight: bold;
            margin: 12px 0 6px;
        }

        /* TABEL UTAMA: 9 KOLOM */

        .tabel-absensi {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .tabel-absensi th,
        .tabel-absensi td {
            border: 1px solid #444444;
            padding: 4px 2px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 6.8pt;
            line-height: 1.25;
            vertical-align: middle;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .tabel-absensi th {
            background-color: #e6e6e6;
            text-align: center;
            font-weight: bold;
        }

        .tengah {
            text-align: center;
        }

        .kiri {
            text-align: left;
        }

        /* REKAPITULASI */

        .tabel-rekap {
            width: 65%;
            table-layout: fixed;
            margin-top: 4px;
        }

        .tabel-rekap th,
        .tabel-rekap td {
            border: 1px solid #444444;
            padding: 5px 7px;
            font-size: 8pt;
        }

        .tabel-rekap th {
            background-color: #e6e6e6;
            text-align: center;
            font-weight: bold;
        }

        /* DESKRIPSI DAN POIN APEL */

        .kotak-keterangan {
            width: 100%;
            border: 1px solid #444444;
            padding: 8px;
            font-size: 9pt;
            line-height: 1.5;
            white-space: normal;
            overflow-wrap: break-word;
            min-height: 35px;
        }

        /* TANDA TANGAN */

        .tabel-ttd {
            width: 100%;
            margin-top: 20px;
            table-layout: fixed;
            page-break-inside: avoid;
        }

        .tabel-ttd td {
            width: 50%;
            border: none;
            text-align: center;
            vertical-align: top;
            padding: 0 8px;
            font-size: 9pt;
            line-height: 1.5;
        }

        .ruang-ttd {
            height: 55px;
        }

        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }

        .catatan {
            margin-top: 5px;
            font-size: 8pt;
        }
    </style>
</head>

<body>

    <!-- =====================================================
         KOP LAPORAN
    ====================================================== -->

    <table class="kop">
        <tr>
            <td class="kolom-logo">
                <?php if ($logoBidTIK !== ''): ?>
                    <img
                        src="<?= $logoBidTIK ?>"
                        class="logo"
                        alt="Logo Bid TIK"
                    >
                <?php endif; ?>
            </td>

            <td class="kolom-judul">
                <div class="judul-utama">
                    LAPORAN KEHADIRAN PERSONEL
                </div>

                <div class="judul-instansi">
                    BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI<br>
                    POLDA JAWA TIMUR
                </div>
            </td>

            <td class="kolom-logo">
                <?php if ($logoPolda !== ''): ?>
                    <img
                        src="<?= $logoPolda ?>"
                        class="logo"
                        alt="Logo Polda Jawa Timur"
                    >
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <hr class="garis-kop">

    <!-- =====================================================
         TANGGAL LAPORAN
    ====================================================== -->

    <div class="tanggal">
        HARI/TANGGAL: <?= wordEscape($tanggalTampil) ?>
    </div>

    <!-- =====================================================
         A. TABEL KEHADIRAN PERSONEL
         TOTAL 9 KOLOM, MENYESUAIKAN PDF
    ====================================================== -->

    <div class="judul-bagian">
        A. DATA KEHADIRAN PERSONEL
    </div>

    <table class="tabel-absensi">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 14%;">NAMA</th>
                <th style="width: 11%;">PANGKAT</th>
                <th style="width: 12%;">NRP</th>
                <th style="width: 11%;">SUBBID</th>
                <th style="width: 7%;">UR</th>
                <th style="width: 11%;">STATUS</th>
                <th style="width: 17%;">KETERANGAN</th>
                <th style="width: 13%;">WAKTU</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($dataAbsensi)): ?>

                <?php foreach ($dataAbsensi as $index => $row): ?>

                    <tr>
                        <td class="tengah">
                            <?= $index + 1 ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['nama'])
                            ) ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['pangkat'])
                            ) ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['nrp_nip', 'nrp', 'nip'])
                            ) ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['subbid', 'nama_subbid'])
                            ) ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['ur', 'nama_ur'])
                            ) ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['status'])
                            ) ?>
                        </td>

                        <td>
                            <?= wordEscape(
                                $getValue($row, ['keterangan', 'catatan'])
                            ) ?>
                        </td>

                        <td class="tengah">
                            <?= wordEscape(
                                $getValue(
                                    $row,
                                    ['waktu_masuk', 'waktu', 'jam_masuk']
                                )
                            ) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="9" class="tengah">
                        Tidak ada data kehadiran pada tanggal ini.
                    </td>
                </tr>

            <?php endif; ?>
        </tbody>
    </table>

    <div class="catatan">
        Jumlah data personel: <?= $jumlahPersonel ?> orang.
    </div>

    <!-- =====================================================
         B. REKAPITULASI KEHADIRAN
    ====================================================== -->

    <div class="judul-bagian">
        B. REKAPITULASI KEHADIRAN
    </div>

    <table class="tabel-rekap">
        <thead>
            <tr>
                <th style="width: 70%;">STATUS KEHADIRAN</th>
                <th style="width: 30%;">JUMLAH</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($rekapStatus)): ?>

                <?php foreach ($rekapStatus as $status => $jumlah): ?>

                    <tr>
                        <td>
                            <?= wordEscape($status) ?>
                        </td>

                        <td class="tengah">
                            <?= wordEscape($jumlah) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="2" class="tengah">
                        Data rekapitulasi belum tersedia.
                    </td>
                </tr>

            <?php endif; ?>
        </tbody>
    </table>

    <!-- =====================================================
         C. DESKRIPSI KEGIATAN
    ====================================================== -->

    <div class="judul-bagian">
        C. DESKRIPSI KEGIATAN
    </div>

    <div class="kotak-keterangan">
        <?php if (trim((string) $deskripsiKegiatan) !== ''): ?>
            <?= nl2br(wordEscape($deskripsiKegiatan)) ?>
        <?php else: ?>
            -
        <?php endif; ?>
    </div>

    <!-- =====================================================
         D. POIN HASIL APEL
    ====================================================== -->

    <div class="judul-bagian">
        D. POIN HASIL APEL
    </div>

    <div class="kotak-keterangan">
        <?php if (trim((string) $poinApel) !== ''): ?>
            <?= nl2br(wordEscape($poinApel)) ?>
        <?php else: ?>
            -
        <?php endif; ?>
    </div>

    <!-- =====================================================
         TANDA TANGAN
    ====================================================== -->

    <table class="tabel-ttd">
        <tr>
            <td>
                Mengetahui,<br>
                Penanggung Jawab

                <div class="ruang-ttd"></div>

                <div class="nama-pejabat">
                    (........................................)
                </div>

                NRP/NIP. ................................
            </td>

            <td>
                Jawa Timur, <?= wordEscape($tanggalTampil) ?><br>
                Petugas Pelapor

                <div class="ruang-ttd"></div>

                <div class="nama-pejabat">
                    (........................................)
                </div>

                NRP/NIP. ................................
            </td>
        </tr>
    </table>

</body>
</html>
