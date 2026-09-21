<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use App\Models\PresensiModel;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\VerticalJc;

class GenerateLaporan extends BaseController
{
    protected PersonelModel $personelModel;
    protected PresensiModel $presensiModel;

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
        $personel = $this->personelModel
            ->where('deleted_at', null)
            ->findAll();

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
        $tanggal = $this->request->getPost('tanggal');
        $type = $this->request->getPost('type') ?? 'pdf';

        // Validasi tanggal
        if (empty($tanggal)) {
            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Tanggal laporan belum dipilih!'
                );
        }

        $tanggalValid = \DateTime::createFromFormat(
            'Y-m-d',
            $tanggal
        );

        if (
            !$tanggalValid ||
            $tanggalValid->format('Y-m-d') !== $tanggal
        ) {
            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Format tanggal laporan tidak valid!'
                );
        }

        // Ambil seluruh personel aktif
        $personel = $this->personelModel
            ->where('deleted_at', null)
            ->findAll();

        if (empty($personel)) {
            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Data personel kosong!'
                );
        }

        // Status absensi yang digunakan sistem
        $statusAbsensi = [
            'HADIR',
            'DINAS',
            'LEPAS DINAS',
            'CUTI',
            'SAKIT',
            'IZIN',
            'TERLAMBAT',
            'DIK',
            'BKO',
        ];

        // Ambil data presensi berdasarkan tanggal
        $presensi = $this->presensiModel
            ->where(
                'waktu_masuk >=',
                $tanggal . ' 00:00:00'
            )
            ->where(
                'waktu_masuk <=',
                $tanggal . ' 23:59:59'
            )
            ->findAll();

        // ====================================================
        // REKAP STATUS
        // ====================================================

        $rekapStatus = [];

        foreach ($statusAbsensi as $status) {
            $rekapStatus[$status] = 0;
        }

        foreach ($presensi as $absen) {
            $statusDatabase = strtoupper(
                trim($absen['status'] ?? '')
            );

            if (isset($rekapStatus[$statusDatabase])) {
                $rekapStatus[$statusDatabase]++;
            }
        }

        // ====================================================
        // GABUNGKAN DATA PERSONEL + PRESENSI
        // ====================================================

        $dataAbsensi = [];

        foreach ($personel as $p) {

            $dataPersonel = [
                'personel_id' => $p['id'] ?? null,
                'nrp_nip' => $p['nrp_nip'] ?? '-',
                'nama' => $p['nama'] ?? '-',
                'pangkat' => $p['pangkat'] ?? '-',
                'jabatan' => $p['jabatan'] ?? '-',
                'satker' => $p['satker'] ?? '-',
                'jenis_kelamin' => $p['jenis_kelamin'] ?? '-',
                'status' => null,
                'waktu_masuk' => null,
            ];

            foreach ($presensi as $absen) {

                if (
                    isset($absen['personel_id']) &&
                    $absen['personel_id'] == ($p['id'] ?? null)
                ) {
                    $dataPersonel['status'] = strtoupper(
                        trim($absen['status'] ?? '')
                    );

                    $dataPersonel['waktu_masuk'] =
                        $absen['waktu_masuk'] ?? null;

                    break;
                }
            }

            $dataAbsensi[] = $dataPersonel;
        }

        // ====================================================
        // FORMAT TANGGAL
        // ====================================================

        try {
            $tanggalFormat = Time::parse(
                $tanggal,
                locale: 'id'
            )->toLocalizedString(
                'dd MMMM yyyy'
            );
        } catch (\Throwable $e) {
            $tanggalFormat = $tanggal;
        }

        // ====================================================
        // LOGO POLDA
        // ====================================================

        $logoPoldaPath =
            FCPATH .
            'assets/img/LOGO_POLDA_JATIM.png';

        if (!is_file($logoPoldaPath)) {
            $logoPoldaPath = null;
        }

        // ====================================================
        // LOGO BID TIK
        // ====================================================

        $logoBidTikPath = null;

        $folderLogo =
            FCPATH .
            'assets/img/';

        if (is_dir($folderLogo)) {

            $files = glob(
                $folderLogo . '*'
            );

            if ($files !== false) {

                foreach ($files as $file) {

                    if (!is_file($file)) {
                        continue;
                    }

                    $namaFile =
                        strtolower(
                            basename($file)
                        );

                    if (
                        strpos($namaFile, 'bid') !== false &&
                        strpos($namaFile, 'tik') !== false
                    ) {
                        $logoBidTikPath = $file;
                        break;
                    }
                }
            }
        }

        // ====================================================
        // DATA LAPORAN
        // ====================================================

        $data = [
            'title' => 'Laporan Kehadiran Personel',
            'tanggal' => $tanggal,
            'tanggalFormat' => $tanggalFormat,
            'personel' => $personel,
            'dataAbsensi' => $dataAbsensi,
            'statusAbsensi' => $statusAbsensi,
            'rekapStatus' => $rekapStatus,

            // Tetap tersedia untuk kompatibilitas,
            // tetapi tidak ditampilkan pada DOC.
            'poinApel' => '',

            'logoBidTik' => '',
            'logoPolda' => '',
            'reportType' => $type,
        ];

        // ====================================================
        // GENERATE WORD
        // ====================================================

        if ($type === 'doc') {

            return $this->generateWordDocument(
                $tanggal,
                $tanggalFormat,
                $dataAbsensi,
                $statusAbsensi,
                $rekapStatus,
                $logoBidTikPath,
                $logoPoldaPath,
                $data['poinApel']
            );
        }

        // ====================================================
        // GENERATE PDF
        // ====================================================

        if ($type === 'pdf') {

            $logoPolda = '';

            if (
                !empty($logoPoldaPath) &&
                is_file($logoPoldaPath)
            ) {

                $logoPoldaData =
                    file_get_contents(
                        $logoPoldaPath
                    );

                if ($logoPoldaData !== false) {
                    $logoPolda =
                        base64_encode(
                            $logoPoldaData
                        );
                }
            }

            $logoBidTik = '';

            if (
                !empty($logoBidTikPath) &&
                is_file($logoBidTikPath)
            ) {

                $logoBidTikData =
                    file_get_contents(
                        $logoBidTikPath
                    );

                if ($logoBidTikData !== false) {
                    $logoBidTik =
                        base64_encode(
                            $logoBidTikData
                        );
                }
            }

            $data['logoPolda'] = $logoPolda;
            $data['logoBidTik'] = $logoBidTik;

            return view(
                'admin/generate-laporan/laporan-personel',
                $data
            );
        }

        // ====================================================
        // TYPE TIDAK DIKENALI
        // ====================================================

        return redirect()
            ->to('/admin/laporan')
            ->with(
                'msg',
                'Format laporan tidak dikenali.'
            );
    }

    // ========================================================
    // GENERATE WORD DOCUMENT
    // ========================================================

    private function generateWordDocument(
        string $tanggal,
        string $tanggalFormat,
        array $dataAbsensi,
        array $statusAbsensi,
        array $rekapStatus,
        ?string $logoBidTikPath,
        ?string $logoPoldaPath,
        string $poinApel = ''
    ) {
        // ====================================================
        // TOTAL KEHADIRAN
        // ====================================================

        $totalKehadiran = 0;

        foreach ($statusAbsensi as $status) {

            $totalKehadiran += (int) (
                $rekapStatus[$status] ?? 0
            );
        }

        // ====================================================
        // PHPWORD
        // ====================================================

        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(9);

        $section = $phpWord->addSection([
            'pageSizeW' => 11906,
            'pageSizeH' => 16838,
            'marginTop' => 900,
            'marginBottom' => 900,
            'marginLeft' => 1134,
            'marginRight' => 1134,
        ]);

        // ====================================================
        // FONT
        // ====================================================

        $fontNormal = [
            'name' => 'Arial',
            'size' => 9,
        ];

        $fontBold = [
            'name' => 'Arial',
            'size' => 9,
            'bold' => true,
        ];

        $fontTitle = [
            'name' => 'Arial',
            'size' => 14,
            'bold' => true,
        ];

        $fontSubtitle = [
            'name' => 'Arial',
            'size' => 9,
            'bold' => true,
        ];

        $fontTableHeader = [
            'name' => 'Arial',
            'size' => 7,
            'bold' => true,
            'color' => 'FFFFFF',
        ];

        $fontTable = [
            'name' => 'Arial',
            'size' => 7,
        ];

        $fontTableBold = [
            'name' => 'Arial',
            'size' => 7,
            'bold' => true,
        ];

        // ====================================================
        // HEADER
        // ====================================================

        $headerParagraph = $section->addTextRun([
            'alignment' => Jc::CENTER,
            'spaceAfter' => 40,
        ]);

        if (
            !empty($logoBidTikPath) &&
            is_file($logoBidTikPath)
        ) {

            $headerParagraph->addImage(
                $logoBidTikPath,
                [
                    'width' => 45,
                    'height' => 45,
                    'wrappingStyle' => 'inline',
                ]
            );
        }

        $headerParagraph->addText(
            '    ',
            $fontNormal
        );

        $headerParagraph->addText(
            'LAPORAN KEHADIRAN PERSONEL',
            $fontTitle
        );

        $headerParagraph->addText(
            '    ',
            $fontNormal
        );

        if (
            !empty($logoPoldaPath) &&
            is_file($logoPoldaPath)
        ) {

            $headerParagraph->addImage(
                $logoPoldaPath,
                [
                    'width' => 45,
                    'height' => 45,
                    'wrappingStyle' => 'inline',
                ]
            );
        }

        $section->addText(
            'BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI',
            $fontSubtitle,
            [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 0,
            ]
        );

        $section->addText(
            'POLDA JAWA TIMUR',
            $fontNormal,
            [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 80,
            ]
        );

        $section->addText(
            '________________________________________________________________________________',
            [
                'name' => 'Arial',
                'size' => 7,
                'bold' => true,
                'color' => 'B5121B',
            ],
            [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 100,
            ]
        );

        // ====================================================
        // INFORMASI LAPORAN
        // ====================================================

        $section->addText(
            'Tanggal : ' . $tanggalFormat,
            $fontNormal,
            [
                'spaceAfter' => 30,
            ]
        );

        $section->addText(
            'Jenis Laporan : Rekapitulasi Kehadiran Personel',
            $fontNormal,
            [
                'spaceAfter' => 120,
            ]
        );

        // ====================================================
        // TABEL 1
        // DATA KEHADIRAN PERSONEL
        // ====================================================

        $section->addText(
            'DATA KEHADIRAN PERSONEL',
            $fontBold,
            [
                'spaceAfter' => 50,
            ]
        );

        $dataTable = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '555555',
            'cellMargin' => 45,
            'layout' => 'fixed',
        ]);

        $dataTable->addRow(500);

        $headerColumns = [
            ['No.', 450],
            ['NRP/NIP', 1200],
            ['Nama', 2000],
            ['Pangkat', 1100],
            ['Unit Kerja', 1800],
            ['Status', 1450],
            ['Waktu', 1638],
        ];

        foreach ($headerColumns as $column) {

            $dataTable
                ->addCell(
                    $column[1],
                    [
                        'bgColor' => 'B5121B',
                        'valign' => VerticalJc::CENTER,
                    ]
                )
                ->addText(
                    $column[0],
                    $fontTableHeader,
                    [
                        'alignment' => Jc::CENTER,
                    ]
                );
        }

        // ====================================================
        // ISI DATA PERSONEL
        // ====================================================

        if (!empty($dataAbsensi)) {

            $no = 1;

            foreach ($dataAbsensi as $row) {

                $dataTable->addRow();

                // No.
                $dataTable
                    ->addCell(
                        450,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        (string) $no++,
                        $fontTable,
                        [
                            'alignment' => Jc::CENTER,
                        ]
                    );

                // NRP/NIP
                $dataTable
                    ->addCell(
                        1200,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        (string) (
                            $row['nrp_nip'] ?? '-'
                        ),
                        $fontTable
                    );

                // Nama
                $dataTable
                    ->addCell(
                        2000,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        (string) (
                            $row['nama'] ?? '-'
                        ),
                        $fontTable
                    );

                // Pangkat
                $dataTable
                    ->addCell(
                        1100,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        (string) (
                            $row['pangkat'] ?? '-'
                        ),
                        $fontTable
                    );

                // Unit Kerja
                $dataTable
                    ->addCell(
                        1800,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        (string) (
                            $row['satker'] ?? '-'
                        ),
                        $fontTable
                    );

                // Status
                $status = !empty($row['status'])
                    ? strtoupper(
                        trim($row['status'])
                    )
                    : 'BELUM ABSEN';

                $dataTable
                    ->addCell(
                        1450,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        $status,
                        $fontTable,
                        [
                            'alignment' => Jc::CENTER,
                        ]
                    );

                // Waktu
                $waktu = '-';

                if (!empty($row['waktu_masuk'])) {

                    try {

                        $waktu = date(
                            'H:i',
                            strtotime(
                                $row['waktu_masuk']
                            )
                        );

                    } catch (\Throwable $e) {

                        $waktu = '-';
                    }
                }

                $dataTable
                    ->addCell(
                        1638,
                        [
                            'valign' => VerticalJc::CENTER,
                        ]
                    )
                    ->addText(
                        $waktu,
                        $fontTable,
                        [
                            'alignment' => Jc::CENTER,
                        ]
                    );
            }

        } else {

            $dataTable->addRow();

            $dataTable
                ->addCell(
                    9638,
                    [
                        'valign' => VerticalJc::CENTER,
                    ]
                )
                ->addText(
                    'Tidak terdapat data kehadiran.',
                    $fontTable,
                    [
                        'alignment' => Jc::CENTER,
                    ]
                );
        }

        $section->addText(
            '',
            $fontNormal,
            [
                'spaceAfter' => 30,
            ]
        );

        // ====================================================
        // TABEL 2
        // REKAPITULASI KEHADIRAN
        // ====================================================

        $section->addText(
            'REKAPITULASI KEHADIRAN',
            $fontBold,
            [
                'spaceAfter' => 50,
            ]
        );

        $rekapTable = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '555555',
            'cellMargin' => 40,
            'layout' => 'fixed',
        ]);

        $jumlahKolomRekap =
            count($statusAbsensi) + 1;

        $lebarRekap = (int) floor(
            9638 / $jumlahKolomRekap
        );

        $rekapTable->addRow();

        foreach ($statusAbsensi as $status) {

            $rekapTable
                ->addCell(
                    $lebarRekap,
                    [
                        'bgColor' => '171717',
                        'valign' => VerticalJc::CENTER,
                    ]
                )
                ->addText(
                    $status,
                    [
                        'name' => 'Arial',
                        'size' => 6,
                        'bold' => true,
                        'color' => 'FFFFFF',
                    ],
                    [
                        'alignment' => Jc::CENTER,
                    ]
                );
        }

        $rekapTable
            ->addCell(
                $lebarRekap,
                [
                    'bgColor' => 'EEEEEE',
                    'valign' => VerticalJc::CENTER,
                ]
            )
            ->addText(
                'TOTAL',
                $fontTableBold,
                [
                    'alignment' => Jc::CENTER,
                ]
            );

        $rekapTable->addRow();

        foreach ($statusAbsensi as $status) {

            $rekapTable
                ->addCell(
                    $lebarRekap,
                    [
                        'valign' => VerticalJc::CENTER,
                    ]
                )
                ->addText(
                    (string) (
                        $rekapStatus[$status] ?? 0
                    ),
                    $fontTableBold,
                    [
                        'alignment' => Jc::CENTER,
                    ]
                );
        }

        $rekapTable
            ->addCell(
                $lebarRekap,
                [
                    'bgColor' => 'EEEEEE',
                    'valign' => VerticalJc::CENTER,
                ]
            )
            ->addText(
                (string) $totalKehadiran,
                $fontTableBold,
                [
                    'alignment' => Jc::CENTER,
                ]
            );

        $section->addText(
            '',
            $fontNormal,
            [
                'spaceAfter' => 30,
            ]
        );

        // ====================================================
        // TABEL 3
        // DESKRIPSI KEGIATAN
        // TANPA KOLOM NO.
        // ====================================================

        $section->addText(
            'DESKRIPSI KEGIATAN',
            $fontBold,
            [
                'spaceAfter' => 50,
            ]
        );

        $kegiatanTable = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '555555',
            'cellMargin' => 70,
            'layout' => 'fixed',
        ]);

        // HEADER
        $kegiatanTable->addRow();

        $kegiatanTable
            ->addCell(
                9638,
                [
                    'bgColor' => 'B5121B',
                    'valign' => VerticalJc::CENTER,
                ]
            )
            ->addText(
                'Deskripsi Kegiatan',
                $fontTableHeader,
                [
                    'alignment' => Jc::CENTER,
                ]
            );

        // ISI
        $kegiatanTable->addRow();

        $kegiatanTable
            ->addCell(
                9638,
                [
                    'valign' => VerticalJc::CENTER,
                ]
            )
            ->addText(
                '-',
                $fontTable
            );

        // ====================================================
        // MENGETAHUI
        // ====================================================

        $section->addText(
            '',
            $fontNormal
        );

        $section->addText(
            'Mengetahui,',
            [
                'name' => 'Arial',
                'size' => 9,
                'bold' => true,
            ],
            [
                'alignment' => Jc::RIGHT,
                'spaceAfter' => 80,
            ]
        );

        $section->addText(
            '',
            $fontNormal
        );

        $section->addText(
            '____________________________',
            [
                'name' => 'Arial',
                'size' => 9,
                'bold' => true,
            ],
            [
                'alignment' => Jc::RIGHT,
            ]
        );

        // ====================================================
        // SIMPAN FILE WORD
        // ====================================================

        $uploadPath =
            WRITEPATH .
            'uploads/';

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0775,
                true
            );
        }

        $filename =
            'laporan_kehadiran_' .
            $tanggal .
            '.docx';

        $filePath =
            $uploadPath .
            $filename;

        try {

            $writer = IOFactory::createWriter(
                $phpWord,
                'Word2007'
            );

            $writer->save($filePath);

        } catch (\Throwable $e) {

            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Gagal membuat dokumen Word: ' .
                    $e->getMessage()
                );
        }

        return $this->response
            ->download(
                $filePath,
                null
            )
            ->setFileName(
                $filename
            );
    }

    // ========================================================
    // KIRIM WHATSAPP
    // ========================================================

    public function kirimWhatsApp()
    {
        $tanggal =
            $this->request->getPost(
                'tanggal'
            );

        // ====================================================
        // VALIDASI TANGGAL
        // ====================================================

        if (empty($tanggal)) {

            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Tanggal laporan belum dipilih.'
                );
        }

        // ====================================================
        // NOMOR WHATSAPP
        // ====================================================

        $nomorTujuan =
            env('WA_TARGET_NUMBER');

        if (empty($nomorTujuan)) {

            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Nomor WhatsApp tujuan belum diatur.'
                );
        }

        // ====================================================
        // FONNTE TOKEN
        // ====================================================

        $token =
            env('FONNTE_TOKEN');

        if (empty($token)) {

            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Fonnte token belum diatur.'
                );
        }

        // ====================================================
        // AMBIL DATA PRESENSI
        // ====================================================

        $presensi = $this->presensiModel
            ->where(
                'waktu_masuk >=',
                $tanggal . ' 00:00:00'
            )
            ->where(
                'waktu_masuk <=',
                $tanggal . ' 23:59:59'
            )
            ->findAll();

        // ====================================================
        // REKAP
        // ====================================================

        $rekap = [
            'HADIR' => 0,
            'DINAS' => 0,
            'LEPAS DINAS' => 0,
            'CUTI' => 0,
            'SAKIT' => 0,
            'IZIN' => 0,
            'TERLAMBAT' => 0,
            'DIK' => 0,
            'BKO' => 0,
        ];

        foreach ($presensi as $absen) {

            $status = strtoupper(
                trim(
                    $absen['status'] ?? ''
                )
            );

            if (isset($rekap[$status])) {
                $rekap[$status]++;
            }
        }

        // ====================================================
        // FORMAT TANGGAL
        // ====================================================

        try {

            $tanggalFormat = Time::parse(
                $tanggal,
                locale: 'id'
            )->toLocalizedString(
                'dd MMMM yyyy'
            );

        } catch (\Throwable $e) {

            $tanggalFormat = $tanggal;
        }

        // ====================================================
        // PESAN WHATSAPP
        // ====================================================

        $pesan =
            "LAPORAN KEHADIRAN PERSONEL\n" .
            "POLDA JAWA TIMUR BIDANG TIK\n\n" .
            "Tanggal: " .
            $tanggalFormat .
            "\n\n" .
            "REKAPITULASI KEHADIRAN\n" .
            "HADIR: " .
            $rekap['HADIR'] .
            "\n" .
            "DINAS: " .
            $rekap['DINAS'] .
            "\n" .
            "LEPAS DINAS: " .
            $rekap['LEPAS DINAS'] .
            "\n" .
            "CUTI: " .
            $rekap['CUTI'] .
            "\n" .
            "SAKIT: " .
            $rekap['SAKIT'] .
            "\n" .
            "IZIN: " .
            $rekap['IZIN'] .
            "\n" .
            "TERLAMBAT: " .
            $rekap['TERLAMBAT'] .
            "\n" .
            "DIK: " .
            $rekap['DIK'] .
            "\n" .
            "BKO: " .
            $rekap['BKO'] .
            "\n\n" .
            "Laporan dibuat melalui Sistem " .
            "Rekapitulasi dan Pelaporan Data " .
            "Kehadiran Personel Bidang TIK " .
            "Polda Jawa Timur.";

        // ====================================================
        // CURL CLIENT
        // ====================================================

        $client = \Config\Services::curlrequest([
            'timeout' => 30,
            'http_errors' => false,
        ]);

        // ====================================================
        // KIRIM KE FONNTE
        // ====================================================

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

            $statusCode =
                $response->getStatusCode();

            $hasil = json_decode(
                $response->getBody(),
                true
            );

        } catch (\Throwable $e) {

            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Gagal menghubungi layanan WhatsApp: ' .
                    $e->getMessage()
                );
        }

        // ====================================================
        // BERHASIL
        // ====================================================

        if (
            $statusCode >= 200 &&
            $statusCode < 300 &&
            isset($hasil['status']) &&
            $hasil['status'] === true
        ) {

            return redirect()
                ->to('/admin/laporan')
                ->with(
                    'msg',
                    'Laporan berhasil dikirim ke WhatsApp.'
                );
        }

        // ====================================================
        // GAGAL
        // ====================================================

        $pesanError =
            $hasil['reason'] ??
            $hasil['message'] ??
            'Laporan gagal dikirim ke WhatsApp.';

        return redirect()
            ->to('/admin/laporan')
            ->with(
                'msg',
                $pesanError
            );
    }
}