<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DeskripsiKegiatanModel;
use App\Models\PersonelModel;
use App\Models\PresensiModel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\VerticalJc;

class GenerateLaporan extends BaseController
{
    protected PersonelModel $personelModel;
    protected PresensiModel $presensiModel;

    private array $statusAbsensi = [
        'HADIR',
        'DINAS LUAR',
        'LEPAS DINAS',
        'CUTI',
        'SAKIT',
        'IZIN',
        'TERLAMBAT',
        'DIK',
        'BKO',
    ];

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
        $this->presensiModel = new PresensiModel();
    }

    // ========================================================
    // HALAMAN GENERATE LAPORAN
    // ========================================================

    public function index()
    {
        $personel = $this->ambilPersonel();

        return view(
            'admin/generate-laporan/generate-laporan',
            [
                'title' => 'Generate Laporan',
                'ctx' => 'laporan',
                'personel' => $personel,
            ]
        );
    }

    // ========================================================
    // GENERATE LAPORAN
    // ========================================================

    public function generateLaporan()
    {
        $tanggal = trim(
            (string) ($this->request->getPost('tanggal') ?? '')
        );

        $type = strtolower(
            trim((string) ($this->request->getPost('type') ?? 'pdf'))
        );

        $periode = strtolower(
            trim((string) ($this->request->getPost('periode') ?? 'harian'))
        );

        if (!$this->tanggalValid($tanggal)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Tanggal laporan tidak valid.');
        }

        if (!in_array($type, ['pdf', 'doc', 'docx'], true)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Format laporan tidak dikenali.');
        }

        if (!in_array($periode, ['harian', 'mingguan', 'bulanan'], true)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Periode laporan tidak dikenali.');
        }

        if ($periode === 'mingguan' || $periode === 'bulanan') {
            return $this->generateLaporanPeriode(
                $tanggal,
                $periode,
                $type
            );
        }

        return $this->generateLaporanHarian($tanggal, $type);
    }

    // ========================================================
    // VALIDASI TANGGAL
    // ========================================================

    private function tanggalValid(string $tanggal): bool
    {
        $date = \DateTime::createFromFormat('!Y-m-d', $tanggal);

        return $date !== false
            && $date->format('Y-m-d') === $tanggal;
    }

    // ========================================================
    // NORMALISASI STATUS
    // ========================================================

    private function normalisasiStatus(string $status): string
    {
        $status = strtoupper(trim($status));
        $status = preg_replace('/\s+/', ' ', $status) ?? '';

        // Menyamakan penamaan status lama dengan kategori laporan.
        if ($status === 'DINAS') {
            return 'DINAS LUAR';
        }

        return $status;
    }

    // ========================================================
    // REKAP STATUS SELURUH PRESENSI
    // ========================================================

    private function hitungRekapStatus(array $presensi): array
    {
        $rekap = [];

        foreach ($this->statusAbsensi as $status) {
            $rekap[$status] = 0;
        }

        foreach ($presensi as $absen) {
            $status = $this->normalisasiStatus(
                (string) ($absen['status'] ?? '')
            );

            if (array_key_exists($status, $rekap)) {
                $rekap[$status]++;
            }
        }

        return $rekap;
    }

    // ========================================================
    // FORMAT TANGGAL INDONESIA
    // ========================================================

    private function formatTanggalIndonesia(string $tanggal): string
    {
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $timestamp = strtotime($tanggal);

        if ($timestamp === false) {
            return $tanggal;
        }

        return $hari[date('l', $timestamp)] . ', '
            . date('d', $timestamp) . ' '
            . $bulan[(int) date('n', $timestamp)] . ' '
            . date('Y', $timestamp);
    }

    private function formatTanggalPendek(string $tanggal): string
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $timestamp = strtotime($tanggal);

        if ($timestamp === false) {
            return $tanggal;
        }

        return date('d', $timestamp) . ' '
            . $bulan[(int) date('n', $timestamp)] . ' '
            . date('Y', $timestamp);
    }

    // ========================================================
    // RENTANG TANGGAL LAPORAN
    // ========================================================

    private function rentangPeriode(
        string $tanggal,
        string $periode
    ): array {
        $date = new \DateTimeImmutable($tanggal);

        if ($periode === 'mingguan') {
            // Minggu kerja: Senin sampai Jumat.
            $hari = (int) $date->format('N');

            $mulai = $date->modify('-' . ($hari - 1) . ' days');
            $akhir = $mulai->modify('+4 days');
        } else {
            $mulai = $date->modify('first day of this month');
            $akhir = $date->modify('last day of this month');
        }

        return [
            $mulai->format('Y-m-d'),
            $akhir->format('Y-m-d'),
        ];
    }

    // ========================================================
    // AMBIL LOGO
    // ========================================================

    private function ambilLogo(): array
    {
        $logoPoldaPath = FCPATH . 'assets/img/LOGO_POLDA_JATIM.png';

        if (!is_file($logoPoldaPath)) {
            $logoPoldaPath = null;
        }

        $logoBidTikPath = null;
        $folderLogo = FCPATH . 'assets/img/';

        if (is_dir($folderLogo)) {
            $files = glob($folderLogo . '*');

            if ($files !== false) {
                foreach ($files as $file) {
                    if (!is_file($file)) {
                        continue;
                    }

                    $namaFile = strtolower(basename($file));

                    if (
                        strpos($namaFile, 'bid') !== false
                        && strpos($namaFile, 'tik') !== false
                    ) {
                        $logoBidTikPath = $file;
                        break;
                    }
                }
            }
        }

        return [$logoBidTikPath, $logoPoldaPath];
    }

    // ========================================================
    // AMBIL DESKRIPSI KEGIATAN
    // ========================================================

    private function ambilDeskripsi(
        string $tanggalMulai,
        string $tanggalAkhir
    ): string {
        $model = new DeskripsiKegiatanModel();

        $data = $model
            ->where('tanggal >=', $tanggalMulai)
            ->where('tanggal <=', $tanggalAkhir)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $hasil = [];

        foreach ($data as $item) {
            $deskripsi = trim(
                (string) ($item['deskripsi'] ?? '')
            );

            if ($deskripsi === '' || $deskripsi === '-') {
                continue;
            }

            if ($tanggalMulai !== $tanggalAkhir) {
                $hasil[] = $this->formatTanggalPendek(
                    (string) $item['tanggal']
                ) . ': ' . $deskripsi;
            } else {
                $hasil[] = $deskripsi;
            }
        }

        return empty($hasil) ? '-' : implode("\n", $hasil);
    }

    // ========================================================
    // DATA PERSONEL AKTIF
    // ========================================================

    private function ambilPersonel(): array
    {
        return $this->personelModel
            ->where('deleted_at', null)
            ->findAll();
    }

    // ========================================================
    // LAPORAN HARIAN
    // ========================================================

    private function generateLaporanHarian(
        string $tanggal,
        string $type
    ) {
        $personel = $this->ambilPersonel();

        if (empty($personel)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Data personel kosong.');
        }

        $presensi = $this->presensiModel
            ->where('waktu_masuk >=', $tanggal . ' 00:00:00')
            ->where('waktu_masuk <=', $tanggal . ' 23:59:59')
            ->orderBy('waktu_masuk', 'ASC')
            ->findAll();

        $rekapStatus = $this->hitungRekapStatus($presensi);

        /*
         * Jika terdapat beberapa catatan pada hari yang sama,
         * data tabel harian memakai catatan presensi terakhir.
         */
        $presensiByPersonel = [];

        foreach ($presensi as $absen) {
            $id = (string) ($absen['personel_id'] ?? '');

            if ($id !== '') {
                $presensiByPersonel[$id] = $absen;
            }
        }

        $dataAbsensi = [];

        foreach ($personel as $p) {
            $id = (string) ($p['id'] ?? '');
            $absen = $presensiByPersonel[$id] ?? null;

            $dataAbsensi[] = [
                'personel_id' => $p['id'] ?? null,
                'nrp_nip' => $p['nrp_nip'] ?? '-',
                'nama' => $p['nama'] ?? '-',
                'pangkat' => $p['pangkat'] ?? '-',
                'subbid' => $p['subbid'] ?? '-',
                'ur' => $p['ur'] ?? '-',
                'jabatan' => $p['jabatan'] ?? '-',
                'satker' => $p['satker'] ?? '-',
                'jenis_kelamin' => $p['jenis_kelamin'] ?? '-',
                'status' => $absen
                    ? $this->normalisasiStatus(
                        (string) ($absen['status'] ?? '')
                    )
                    : null,
                'waktu_masuk' => $absen['waktu_masuk'] ?? null,
                'keterangan' => $absen['keterangan'] ?? '-',
            ];
        }

        return $this->keluarkanLaporan(
            $tanggal,
            $tanggal,
            'harian',
            $type,
            $dataAbsensi,
            $presensi,
            $rekapStatus
        );
    }

    // ========================================================
    // LAPORAN MINGGUAN DAN BULANAN
    // ========================================================

    private function generateLaporanPeriode(
        string $tanggal,
        string $periode,
        string $type
    ) {
        $personel = $this->ambilPersonel();

        if (empty($personel)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Data personel kosong.');
        }

        [$tanggalMulai, $tanggalAkhir] = $this->rentangPeriode(
            $tanggal,
            $periode
        );

        $presensi = $this->presensiModel
            ->where('waktu_masuk >=', $tanggalMulai . ' 00:00:00')
            ->where('waktu_masuk <=', $tanggalAkhir . ' 23:59:59')
            ->orderBy('waktu_masuk', 'ASC')
            ->findAll();

        /*
         * Rekap keseluruhan dihitung dari semua catatan presensi
         * pada periode yang dipilih.
         */
        $rekapStatus = $this->hitungRekapStatus($presensi);

        $presensiByPersonel = [];

        foreach ($presensi as $absen) {
            $id = (string) ($absen['personel_id'] ?? '');

            if ($id === '') {
                continue;
            }

            $presensiByPersonel[$id][] = $absen;
        }

        $dataAbsensi = [];

        foreach ($personel as $p) {
            $id = (string) ($p['id'] ?? '');
            $daftarPresensi = $presensiByPersonel[$id] ?? [];

            // Jumlah setiap status per personel.
            $jumlahStatus = [];

            // Daftar waktu presensi per personel.
            $waktuPeriode = [];

            // Daftar keterangan unik.
            $keteranganPeriode = [];

            foreach ($daftarPresensi as $absen) {
                $status = $this->normalisasiStatus(
                    (string) ($absen['status'] ?? '')
                );

                if ($status !== '') {
                    if (!isset($jumlahStatus[$status])) {
                        $jumlahStatus[$status] = 0;
                    }

                    $jumlahStatus[$status]++;
                }

                $waktu = trim(
                    (string) ($absen['waktu_masuk'] ?? '')
                );

                if ($waktu !== '') {
                    $timestamp = strtotime($waktu);

                    if ($timestamp !== false) {
                        $waktuPeriode[] =
                            date('d/m', $timestamp)
                            . ' '
                            . date('H:i', $timestamp);
                    }
                }

                $keterangan = trim(
                    (string) ($absen['keterangan'] ?? '')
                );

                if ($keterangan !== '' && $keterangan !== '-') {
                    $keteranganPeriode[] = $keterangan;
                }
            }

            /*
             * Contoh hasil:
             * HADIR: 3
             * SAKIT: 2
             * DINAS LUAR: 1
             */
            $statusRingkas = [];

            // Tampilkan status sesuai urutan kategori laporan.
            foreach ($this->statusAbsensi as $status) {
                $jumlah = $jumlahStatus[$status] ?? 0;

                if ($jumlah > 0) {
                    $statusRingkas[] = $status . ': ' . $jumlah;
                }
            }

            // Status tambahan tetap ditampilkan jika ada di database.
            foreach ($jumlahStatus as $status => $jumlah) {
                if (
                    !in_array($status, $this->statusAbsensi, true)
                    && $jumlah > 0
                ) {
                    $statusRingkas[] = $status . ': ' . $jumlah;
                }
            }

            $dataAbsensi[] = [
                'personel_id' => $p['id'] ?? null,
                'nrp_nip' => $p['nrp_nip'] ?? '-',
                'nama' => $p['nama'] ?? '-',
                'pangkat' => $p['pangkat'] ?? '-',
                'subbid' => $p['subbid'] ?? '-',
                'ur' => $p['ur'] ?? '-',
                'jabatan' => $p['jabatan'] ?? '-',
                'satker' => $p['satker'] ?? '-',
                'jenis_kelamin' => $p['jenis_kelamin'] ?? '-',

                'status' => empty($statusRingkas)
                    ? 'BELUM ADA PRESENSI'
                    : implode("\n", $statusRingkas),

                'waktu_masuk' => empty($waktuPeriode)
                    ? null
                    : implode("\n", $waktuPeriode),

                'keterangan' => empty($keteranganPeriode)
                    ? '-'
                    : implode("\n", array_unique($keteranganPeriode)),
            ];
        }

        return $this->keluarkanLaporan(
            $tanggalMulai,
            $tanggalAkhir,
            $periode,
            $type,
            $dataAbsensi,
            $presensi,
            $rekapStatus
        );
    }

    // ========================================================
    // OUTPUT PDF / WORD
    // ========================================================

    private function keluarkanLaporan(
        string $tanggalMulai,
        string $tanggalAkhir,
        string $periode,
        string $type,
        array $dataAbsensi,
        array $presensi,
        array $rekapStatus
    ) {
        [$logoBidTikPath, $logoPoldaPath] = $this->ambilLogo();

        $tanggalFormat = $periode === 'harian'
            ? $this->formatTanggalIndonesia($tanggalMulai)
            : $this->formatTanggalPendek($tanggalMulai)
                . ' - '
                . $this->formatTanggalPendek($tanggalAkhir);

        $deskripsiKegiatan = $this->ambilDeskripsi(
            $tanggalMulai,
            $tanggalAkhir
        );

        $data = [
            'title' => 'Laporan Kehadiran Personel',
            'tanggal' => $tanggalMulai,
            'tanggalFormat' => $tanggalFormat,
            'tanggalTampil' => $tanggalFormat,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
            'periode' => $periode,
            'personel' => $this->ambilPersonel(),
            'dataAbsensi' => $dataAbsensi,
            'statusAbsensi' => $this->statusAbsensi,
            'rekapStatus' => $rekapStatus,
            'poinApel' => '',
            'deskripsiKegiatan' => $deskripsiKegiatan,
            'logoBidTik' => '',
            'logoPolda' => '',
            'reportType' => $type,
        ];

        if ($type === 'doc' || $type === 'docx') {
            return $this->generateWordDocument(
                $tanggalFormat,
                $periode,
                $dataAbsensi,
                $this->statusAbsensi,
                $rekapStatus,
                $logoBidTikPath,
                $logoPoldaPath,
                $deskripsiKegiatan
            );
        }

        if ($type === 'pdf') {
            if ($logoPoldaPath && is_file($logoPoldaPath)) {
                $logo = file_get_contents($logoPoldaPath);

                if ($logo !== false) {
                    $data['logoPolda'] = base64_encode($logo);
                }
            }

            if ($logoBidTikPath && is_file($logoBidTikPath)) {
                $logo = file_get_contents($logoBidTikPath);

                if ($logo !== false) {
                    $data['logoBidTik'] = base64_encode($logo);
                }
            }

            return view(
                'admin/generate-laporan/laporan-personel',
                $data
            );
        }

        return redirect()
            ->to('/admin/laporan')
            ->with('msg', 'Format laporan tidak dikenali.');
    }

    

private function generateWordDocument(
    string $tanggalFormat,
    string $periode,
    array $dataAbsensi,
    array $statusAbsensi,
    array $rekapStatus,
    ?string $logoBidTikPath,
    ?string $logoPoldaPath,
    string $deskripsiKegiatan = ''
) {
    $phpWord = new PhpWord();
    $phpWord->setDefaultFontName('Times New Roman');
    $phpWord->setDefaultFontSize(9);

    // ==================================================
    // PENGATURAN HALAMAN
    // ==================================================
    $section = $phpWord->addSection([
        'pageSizeW'    => 11906,
        'pageSizeH'    => 16838,
        'marginTop'    => 850,
        'marginBottom' => 680,
        'marginLeft'   => 453,
        'marginRight'  => 453,
    ]);

    $merah = 'B5121B';
    $hitam = '171717';
    $abu   = '555555';
    $putih = 'FFFFFF';

    $normal = [
        'name' => 'Times New Roman',
        'size' => 10,
        'color' => $hitam,
    ];

    $tebal = [
        'name' => 'Times New Roman',
        'size' => 9,
        'bold' => true,
        'color' => $hitam,
    ];

    $paragrafTengah = [
        'alignment' => Jc::CENTER,
        'spaceBefore' => 0,
        'spaceAfter' => 0,
    ];

    $paragrafKiri = [
        'alignment' => Jc::LEFT,
        'spaceBefore' => 0,
        'spaceAfter' => 0,
    ];

    $headerTabel = [
        'name' => 'Times New Roman',
        'size' => 10,
        'bold' => true,
        'color' => $putih,
    ];

    $isiTabel = [
        'name' => 'Times New Roman',
        'size' => 10,
        'color' => $hitam,
    ];

    
    // ==================================================
    // KOP LAPORAN: LOGO KIRI, JUDUL TENGAH, LOGO KANAN
    // Tabel tanpa border khusus untuk tata letak kop
    // ==================================================

    $kop = $section->addTable([
        'borderSize' => 0,
        'borderColor' => 'FFFFFF',
        'cellMargin' => 0,
        'layout' => 'fixed',
        'width' => 11000,
    ]);

    $kop->addRow(1300, [
        'exactHeight' => true,
    ]);

    // Kolom logo kiri
    $cellLogoKiri = $kop->addCell(1300, [
        'valign' => VerticalJc::CENTER,
    ]);

    if (!empty($logoBidTikPath) && is_file($logoBidTikPath)) {
        $cellLogoKiri->addImage($logoBidTikPath, [
            'width' => 55,
            'height' => 55,
            'alignment' => Jc::CENTER,
        ]);
    }

    // Kolom judul tengah
    $cellJudul = $kop->addCell(8400, [
        'valign' => VerticalJc::CENTER,
    ]);

    $cellJudul->addText(
        'LAPORAN KEHADIRAN PERSONEL',
        [
            'name' => 'Times New Roman',
            'size' => 15,
            'bold' => true,
            'color' => $merah,
        ],
        [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 3,
        ]
    );

    $cellJudul->addText(
        'BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI',
        [
            'name' => 'Times New Roman',
            'size' => 9,
            'bold' => true,
            'color' => $hitam,
        ],
        [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 2,
        ]
    );

    $cellJudul->addText(
        'POLDA JAWA TIMUR',
        $tebal,
        [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0,
        ]
    );

    // Kolom logo kanan
    $cellLogoKanan = $kop->addCell(1300, [
        'valign' => VerticalJc::CENTER,
    ]);

    if (!empty($logoPoldaPath) && is_file($logoPoldaPath)) {
        $cellLogoKanan->addImage($logoPoldaPath, [
            'width' => 55,
            'height' => 55,
            'alignment' => Jc::CENTER,
        ]);
    }

    // Garis pemisah kop
    $section->addText(
        str_repeat('_', 105),
        [
            'name' => 'Times New Roman',
            'size' => 7,
            'bold' => true,
            'color' => $merah,
        ],
        [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 2,
            'spaceAfter' => 10,
        ]
    );

    // ==================================================
    // INFORMASI PERIODE TANPA TABEL
    // ==================================================

    $periode = strtolower(trim($periode));
    $isMingguan = $periode === 'mingguan';
    $isBulanan = $periode === 'bulanan';

    $tanggalLabel = $isMingguan ? 'PERIODE' : 'HARI/TANGGAL';

    if ($isMingguan) {
        $judulPeriode = 'REKAPITULASI MINGGUAN KEHADIRAN PERSONEL';
    } elseif ($isBulanan) {
        $judulPeriode = 'REKAPITULASI BULANAN KEHADIRAN PERSONEL';
    } else {
        $judulPeriode = 'REKAPITULASI HARIAN KEHADIRAN PERSONEL';
    }

   
    
    // ==================================================
// INFORMASI LAPORAN
// Tanpa tabel
// ==================================================

$section->addText(
    'HARI/TANGGAL : ' . $tanggalFormat,
    $normal,
    [
        'alignment' => Jc::LEFT,
        'indentation' => ['left' => 100],
        'spaceBefore' => 0,
        'spaceAfter' => 4,
    ]
);

$section->addText(
    'JENIS LAPORAN : ' . $judulPeriode,
    $normal,
    [
        'alignment' => Jc::LEFT,
        'indentation' => ['left' => 100],
        'spaceBefore' => 0,
        'spaceAfter' => 300, // Jarak sebelum judul A
    ]
);
    // ==================================================
    // JUDUL BAGIAN TANPA TABEL
    // ==================================================

    $buatJudulBagian = function (string $teks) use (
        $section,
        $merah,
        $hitam
    ) {
        $section->addText(
            $teks,
            [
                'name' => 'Times New Roman',
                'size' => 9,
                'bold' => true,
                'color' => $merah,
            ],
            [
                'alignment' => Jc::LEFT,
                'spaceBefore' => 8,
                'spaceAfter' => 4,
            ]
        );
    };

    // ==================================================
    // 1. DATA KEHADIRAN PERSONEL
    // Tabel pertama
    // ==================================================

    $buatJudulBagian('A. DATA KEHADIRAN PERSONEL');

    $tabel = $section->addTable([
        'borderSize' => 6,
        'borderColor' => $abu,
        'cellMargin' => 45,
        'layout' => 'fixed',
        'width' => 11000,
    ]);

    // Total lebar kolom = 11000 twips
    $kolom = [
        ['NO', 440],
        ['NAMA', 2090],
        ['PANGKAT', 1320],
        ['NRP/NIP', 1320],
        ['SUBBID', 1210],
        ['UR', 1100],
        ['STATUS', 1210],
        ['KETERANGAN', 1210],
        ['WAKTU', 1100],
    ];

    // Header tabel
    $tabel->addRow();

    foreach ($kolom as [$namaKolom, $lebar]) {
        $tabel->addCell($lebar, [
            'bgColor' => $merah,
            'valign' => VerticalJc::CENTER,
        ])->addText(
            $namaKolom,
            $headerTabel,
            $paragrafTengah
        );
    }

    // Isi tabel kehadiran
    foreach ($dataAbsensi as $i => $row) {
        $tabel->addRow();

        $waktuRaw = trim((string) ($row['waktu_masuk'] ?? ''));
        $waktuTampil = '-';

        if ($waktuRaw !== '') {
            if ($isMingguan || $isBulanan) {
                $waktuTampil = $waktuRaw;
            } else {
                $timestamp = strtotime($waktuRaw);

                $waktuTampil = $timestamp !== false
                    ? date('H:i', $timestamp)
                    : $waktuRaw;
            }
        }

        $statusTampil = trim((string) ($row['status'] ?? ''));

        if ($statusTampil === '') {
            $statusTampil = 'BELUM ABSEN';
        }

        $keterangan = trim((string) ($row['keterangan'] ?? ''));

        if ($keterangan === '') {
            $keterangan = '-';
        }

        $nilaiKolom = [
            (string) ($i + 1),
            (string) ($row['nama'] ?? '-'),
            (string) ($row['pangkat'] ?? '-'),
            (string) ($row['nrp_nip'] ?? '-'),
            (string) ($row['subbid'] ?? '-'),
            (string) ($row['ur'] ?? '-'),
            $statusTampil,
            $keterangan,
            $waktuTampil,
        ];

        foreach ($kolom as $index => [$namaKolom, $lebar]) {
            $tabel->addCell($lebar, [
                'valign' => VerticalJc::CENTER,
            ])->addText(
                $nilaiKolom[$index],
                $isiTabel,
                in_array($index, [0, 6, 8], true)
                    ? $paragrafTengah
                    : $paragrafKiri
            );
        }
    }

    if (empty($dataAbsensi)) {
        $tabel->addRow();

        $tabel->addCell(11000, [
            'gridSpan' => 9,
            'valign' => VerticalJc::CENTER,
        ])->addText(
            'Tidak terdapat data kehadiran.',
            $isiTabel,
            $paragrafTengah
        );
    }

    
    
    // ==================================================
    // 2. REKAPITULASI KEHADIRAN
    // Tabel kedua
    // ==================================================

    // Memberi jarak setelah tabel DATA KEHADIRAN PERSONEL
    $section->addText(
        '',
        [],
        [
            'spaceBefore' => 0,
            'spaceAfter' => 12,
        ]
    );

    // Judul rekapitulasi
    $buatJudulBagian('B. REKAPITULASI KEHADIRAN');

    $rekap = $section->addTable([
        'borderSize' => 6,
        'borderColor' => $abu,
        'cellMargin' => 35,
        'layout' => 'fixed',
        'width' => 11000,
    ]);


    $jumlahKolom = count($statusAbsensi) + 1;
    $jumlahKolom = max(1, $jumlahKolom);
    $lebarKolomRekap = (int) floor(11000 / $jumlahKolom);

    // Header rekapitulasi
    $rekap->addRow();

    foreach ($statusAbsensi as $status) {
        $rekap->addCell($lebarKolomRekap, [
            'bgColor' => $hitam,
            'valign' => VerticalJc::CENTER,
        ])->addText(
            (string) $status,
            [
                'name' => 'Times New Roman',
                'size' => 6,
                'bold' => true,
                'color' => $putih,
            ],
            $paragrafTengah
        );
    }

    $rekap->addCell($lebarKolomRekap, [
        'bgColor' => $merah,
        'valign' => VerticalJc::CENTER,
    ])->addText(
        $isMingguan ? 'TOTAL PRESENSI' : 'TOTAL',
        [
            'name' => 'Times New Roman',
            'size' => 6,
            'bold' => true,
            'color' => $putih,
        ],
        $paragrafTengah
    );

    // Nilai rekapitulasi
    $rekap->addRow();

    $totalKehadiran = 0;

    foreach ($statusAbsensi as $status) {
        $jumlah = (int) ($rekapStatus[$status] ?? 0);
        $totalKehadiran += $jumlah;

        $rekap->addCell($lebarKolomRekap, [
            'valign' => VerticalJc::CENTER,
        ])->addText(
            (string) $jumlah,
            $tebal,
            $paragrafTengah
        );
    }

    $rekap->addCell($lebarKolomRekap, [
        'bgColor' => 'F3F4F6',
        'valign' => VerticalJc::CENTER,
    ])->addText(
        (string) $totalKehadiran,
        $tebal,
        $paragrafTengah
    );

    // ==================================================
    // JARAK SEBELUM DESKRIPSI KEGIATAN
    // ==================================================

    $section->addText(
        '',
        [],
        [
            'spaceBefore' => 0,
            'spaceAfter' => 12,
        ]
    );

    // ==================================================
    // 3. DESKRIPSI KEGIATAN
    // ==================================================

    $buatJudulBagian('C. DESKRIPSI KEGIATAN');


    $kegiatan = $section->addTable([
        'borderSize' => 6,
        'borderColor' => $abu,
        'cellMargin' => 100,
        'layout' => 'fixed',
        'width' => 11000,
    ]);

    $kegiatan->addRow();

    $kegiatan->addCell(11000, [
        'valign' => VerticalJc::TOP,
    ])->addText(
        trim($deskripsiKegiatan) !== ''
            ? trim($deskripsiKegiatan)
            : '-',
        $normal,
        [
            'alignment' => Jc::BOTH,
            'spaceBefore' => 0,
            'spaceAfter' => 0,
        ]
    );

    
    // ==================================================
// TANDA TANGAN
// ==================================================

$section->addTextBreak(2);

$section->addText('Mengetahui,', $normal, [
    'alignment' => Jc::RIGHT,
    'indentation' => ['right' => 500],
    'spaceBefore' => 0,
    'spaceAfter' => 0,
]);

$section->addText('________________________', $tebal, [
    'alignment' => Jc::RIGHT,
    'indentation' => ['right' => 500],
    'spaceBefore' => 500, // Jarak antara "Mengetahui," dan garis
    'spaceAfter' => 0,
]);
    // ==================================================
    // SIMPAN DAN UNDUH WORD
    // ==================================================

    $uploadPath = WRITEPATH . 'uploads/';

    if (
        !is_dir($uploadPath)
        && !mkdir($uploadPath, 0775, true)
        && !is_dir($uploadPath)
    ) {
        log_message(
            'error',
            'Gagal membuat folder penyimpanan Word: ' . $uploadPath
        );

        return redirect()
            ->to('/admin/laporan')
            ->with('msg', 'Folder penyimpanan laporan tidak dapat dibuat.');
    }

    $filename = 'laporan_kehadiran_' . date('Y-m-d_H-i-s') . '.docx';
    $filePath = $uploadPath . $filename;

    try {
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);
    } catch (\Throwable $e) {
        log_message(
            'error',
            'Gagal membuat Word: ' . $e->getMessage()
            . ' | File: ' . $e->getFile()
            . ' | Baris: ' . $e->getLine()
        );

        return redirect()
            ->to('/admin/laporan')
            ->with(
                'msg',
                'Gagal membuat dokumen Word. Periksa log aplikasi.'
            );
    }

    return $this->response
        ->download($filePath, null)
        ->setFileName($filename);
}

    // ========================================================
    // KIRIM WHATSAPP
    // ========================================================

    public function kirimWhatsApp()
    {
        $tanggal = trim(
            (string) ($this->request->getPost('tanggal') ?? '')
        );

        if (!$this->tanggalValid($tanggal)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Tanggal laporan tidak valid.');
        }

        $nomorTujuan = env('WA_TARGET_NUMBER');
        $token = env('FONNTE_TOKEN');

        if (empty($nomorTujuan)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Nomor WhatsApp tujuan belum diatur.');
        }

        if (empty($token)) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Token Fonnte belum diatur.');
        }

        $presensi = $this->presensiModel
            ->where('waktu_masuk >=', $tanggal . ' 00:00:00')
            ->where('waktu_masuk <=', $tanggal . ' 23:59:59')
            ->findAll();

        $rekap = $this->hitungRekapStatus($presensi);
        $tanggalFormat = $this->formatTanggalIndonesia($tanggal);

        $pesan = "LAPORAN KEHADIRAN PERSONEL\n"
            . "POLDA JAWA TIMUR BIDANG TIK\n\n"
            . "Tanggal: " . $tanggalFormat . "\n\n"
            . "REKAPITULASI KEHADIRAN\n";

        foreach ($this->statusAbsensi as $status) {
            $pesan .= $status . ': ' . ($rekap[$status] ?? 0) . "\n";
        }

        $pesan .= "\nTOTAL PRESENSI: " . array_sum($rekap) . "\n\n"
            . "Laporan dibuat melalui Sistem Rekapitulasi dan Pelaporan Data "
            . "Kehadiran Personel Bidang TIK Polda Jawa Timur.";

        $client = \Config\Services::curlrequest([
            'timeout' => 30,
            'http_errors' => false,
        ]);

        try {
            $response = $client->post(
                'https://api.fonnte.com/send',
                [
                    'headers' => [
                        'Authorization' => $token,
                    ],
                    'form_params' => [
                        'target' => $nomorTujuan,
                        'message' => $pesan,
                    ],
                ]
            );

            $statusCode = $response->getStatusCode();
            $hasil = json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            log_message(
                'error',
                'Gagal mengirim WhatsApp: ' . $e->getMessage()
            );

            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Gagal menghubungi layanan WhatsApp.');
        }

        if (
            $statusCode >= 200
            && $statusCode < 300
            && isset($hasil['status'])
            && $hasil['status'] === true
        ) {
            return redirect()
                ->to('/admin/laporan')
                ->with('msg', 'Laporan berhasil dikirim ke WhatsApp.');
        }

        $pesanError = $hasil['reason']
            ?? $hasil['message']
            ?? 'Laporan gagal dikirim ke WhatsApp.';

        return redirect()
            ->to('/admin/laporan')
            ->with('msg', $pesanError);
    }
}