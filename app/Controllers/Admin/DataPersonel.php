<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataPersonel extends BaseController
{
    protected $personelModel;

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
    }

    public function index()
    {
        $data = [
            'title'            => 'Data Personel',
            'personel'         => $this->personelModel->findAll(),
            'personelTerhapus' => $this->personelModel->onlyDeleted()->findAll()
        ];

        return view('admin/data/data-personel', $data);
    }

    // SIMPAN DATA DARI MODAL TAMBAH
    public function store()
    {
        $nrp = trim((string) $this->request->getPost('nrp_nip'));

        if (empty($nrp)) {
            return redirect()->back()->withInput()->with('error', 'NRP/NIP Wajib diisi!');
        }

        $qrPath = $this->generateQRCode($nrp);

        // Filter slash pada input pangkat manual
        $pangkatRaw = trim((string) $this->request->getPost('pangkat'));
        $pangkatClean = trim(str_replace('/', '', $pangkatRaw));

        $saved = $this->personelModel->save([
            'nrp_nip'       => $nrp,
            'nama'          => trim((string) $this->request->getPost('nama')),
            'pangkat'       => $pangkatClean,
            'subbid'        => trim((string) $this->request->getPost('subbid')),
            'ur'            => trim((string) $this->request->getPost('ur')),
            'jenis_kelamin' => 'L',
            'qr_code'       => $qrPath,
        ]);

        if ($saved) {
            return redirect()->to('/admin/data-personel')->with('success', 'Data personel & QR Code berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data personel.');
    }

    public function importView()
    {
        $data = ['title' => 'Import Data Personel'];
        return view('admin/data/import-personel', $data);
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'File Excel tidak valid.');
        }

        $ext = strtolower($file->getClientExtension());

        if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
            return redirect()->back()->with('error', 'Format file harus XLSX, XLS, atau CSV.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();

            // Mengambil semua baris dalam bentuk array
            $rows = $sheet->toArray('', true, true, false);

            if (count($rows) <= 1) {
                return redirect()->back()->with('error', 'File tidak memiliki data personel.');
            }

            $db = \Config\Database::connect();
            $db->transBegin();

            $berhasil = 0;
            $duplikat = 0;
            $dilewati = 0;
            $nrpDalamFile = [];

            $totalRows = count($rows);

            // LOGIKA MULTI-ROW DETECTOR: Membaca per pasang baris data Excel
            for ($i = 0; $i < $totalRows; $i++) {
                $col0 = trim((string)($rows[$i][0] ?? ''));
                $col1 = trim((string)($rows[$i][1] ?? ''));
                $col2 = trim((string)($rows[$i][2] ?? ''));
                $col3 = trim((string)($rows[$i][3] ?? ''));

                // Deteksi awal data berdasarkan Nomor Urut di Kolom 0 atau Nama di Kolom 1
                if (is_numeric($col0) && $col0 > 0) {
                    
                    // Baris 1: Informasi Nama, Pangkat, dan Jabatan Utama
                    $nama1    = $col1;
                    $pangkat  = $col2;
                    $jabatan1 = $col3;

                    // Baris 2: Informasi Sambungan Nama, NRP (Di bawah Pangkat), dan Sambungan Jabatan
                    $nama2    = '';
                    $nrp      = '';
                    $jabatan2 = '';

                    if (isset($rows[$i + 1])) {
                        $nextCol0 = trim((string)($rows[$i + 1][0] ?? ''));
                        
                        // Jika baris berikutnya bukan nomor urut baru, berarti itu baris pasangannya (NRP)
                        if (!is_numeric($nextCol0) || $nextCol0 === '') {
                            $nama2    = trim((string)($rows[$i + 1][1] ?? ''));
                            $nrp      = trim((string)($rows[$i + 1][2] ?? '')); // NRP berada di bawah kolom Pangkat
                            $jabatan2 = trim((string)($rows[$i + 1][3] ?? ''));
                            $i++; // Lompat ke baris berikutnya
                        }
                    }

                    // Jika NRP masih belum didapatkan (misal file 1 baris standar)
                    if ($nrp === '' && !is_numeric($col0)) {
                        $nrp = $col0;
                    }

                    // Gabungkan Nama & Jabatan yang terpisah 2 baris
                    $namaFull    = preg_replace('/\s+/', ' ', trim($nama1 . ' ' . $nama2));
                    $jabatanFull = strtoupper(preg_replace('/\s+/', ' ', trim($jabatan1 . ' ' . $jabatan2)));

                    // Formating NRP/NIP (hilangkan desimal .0 jika ada)
                    $nrp = preg_replace('/\.0$/', '', $nrp);

                    // Lewati jika data kunci tidak lengkap
                    if (empty($nrp) || empty($namaFull)) {
                        $dilewati++;
                        continue;
                    }

                    // =========================================================
                    // FILTER CLEANING PANGKAT (Hapus Slash)
                    // =========================================================
                    $pangkatClean = trim(str_replace('/', '', $pangkat ?: 'POLRI'));

                    // =========================================================
                    // PARSING AUTOMATIS SUBBID DARI STRING JABATAN
                    // =========================================================
                    $subbid = 'SUBBAGRENMIN';

                    if (strpos($jabatanFull, 'RENMIN') !== false) {
                        $subbid = 'SUBBAGRENMIN';
                    } elseif (
                        strpos($jabatanFull, 'TEKINFO') !== false ||
                        strpos($jabatanFull, 'PULLAHTA') !== false ||
                        strpos($jabatanFull, 'INTI') !== false ||
                        strpos($jabatanFull, 'YANDUKNIS') !== false
                    ) {
                        $subbid = 'SUBBIDTEKINFO';
                    } elseif (
                        strpos($jabatanFull, 'TEKKOM') !== false ||
                        strpos($jabatanFull, 'HARKAN') !== false ||
                        strpos($jabatanFull, 'JARKOM') !== false ||
                        strpos($jabatanFull, 'YANKOM') !== false
                    ) {
                        $subbid = 'SUBBIDTEKKOM';
                    } elseif (strpos($jabatanFull, 'KABID') !== false) {
                        $subbid = 'KABID TIK';
                    }

                    // =========================================================
                    // PARSING AUTOMATIS UR DARI STRING JABATAN
                    // =========================================================
                    $ur = 'URMINTU';

                    if (strpos($jabatanFull, 'REN') !== false) {
                        $ur = 'URREN';
                    } elseif (strpos($jabatanFull, 'KEU') !== false) {
                        $ur = 'URKEU';
                    } elseif (strpos($jabatanFull, 'PULLAHTA') !== false) {
                        $ur = 'URPULLAHTA';
                    } elseif (strpos($jabatanFull, 'INTI') !== false) {
                        $ur = 'URINTI';
                    } elseif (strpos($jabatanFull, 'YANDUKNIS') !== false) {
                        $ur = 'URYANDUKNIS';
                    } elseif (strpos($jabatanFull, 'JARKOM') !== false) {
                        $ur = 'URJARKOM';
                    } elseif (strpos($jabatanFull, 'YANKOM') !== false) {
                        $ur = 'URYANKOM';
                    } elseif (strpos($jabatanFull, 'HARKAN') !== false) {
                        $ur = 'URHARKAN';
                    }

                    // Cek duplikat dalam file
                    if (in_array($nrp, $nrpDalamFile, true)) {
                        $duplikat++;
                        continue;
                    }

                    $nrpDalamFile[] = $nrp;

                    // Cek duplikat di Database
                    $existing = $this->personelModel
                        ->withDeleted()
                        ->where('nrp_nip', $nrp)
                        ->first();

                    if ($existing) {
                        $duplikat++;
                        continue;
                    }

                    // Generate QR Code
                    $qrPath = $this->generateQRCode($nrp);

                    // Simpan data personel
                    $saved = $this->personelModel->save([
                        'nrp_nip'       => $nrp,
                        'nama'          => $namaFull,
                        'pangkat'       => $pangkatClean,
                        'subbid'        => $subbid,
                        'ur'            => $ur,
                        'jenis_kelamin' => 'L',
                        'qr_code'       => $qrPath,
                    ]);

                    if ($saved) {
                        $berhasil++;
                    } else {
                        throw new \RuntimeException('Gagal menyimpan data NRP ' . $nrp);
                    }
                }
            }

            if ($db->transStatus() === false) {
                $db->transRollback();

                return redirect()->to('/admin/data-personel')
                    ->with('error', 'Import gagal. Data tidak berhasil disimpan.');
            }

            $db->transCommit();

            return redirect()->to('/admin/data-personel')->with(
                'success',
                "Import selesai. Berhasil: {$berhasil}, Duplikat: {$duplikat}, Dilewati: {$dilewati}."
            );

        } catch (\Throwable $e) {

            if (isset($db) && $db->transStatus() !== false) {
                $db->transRollback();
            }

            log_message('error', 'Import personel gagal: ' . $e->getMessage());

            return redirect()->to('/admin/data-personel')
                ->with('error', 'Import gagal. Periksa format Excel dan data di dalamnya.');
        }
    }

    // UPDATE DATA PERSONEL
    public function update($id)
    {
        $personel = $this->personelModel->find($id);
        if (!$personel) {
            return redirect()->back()->with('error', 'Data personel tidak ditemukan.');
        }

        $nrp = trim((string) $this->request->getPost('nrp_nip'));

        $qrPath = $personel['qr_code'];
        if (!empty($nrp) && $nrp !== $personel['nrp_nip']) {
            if (!empty($personel['qr_code']) && file_exists(FCPATH . $personel['qr_code'])) {
                @unlink(FCPATH . $personel['qr_code']);
            }
            $qrPath = $this->generateQRCode($nrp);
        }

        // Filter slash pada edit data pangkat manual
        $pangkatRaw = trim((string) $this->request->getPost('pangkat')) ?: $personel['pangkat'];
        $pangkatClean = trim(str_replace('/', '', $pangkatRaw));

        $this->personelModel->update($id, [
            'nrp_nip' => !empty($nrp) ? $nrp : $personel['nrp_nip'],
            'nama'    => trim((string) $this->request->getPost('nama')) ?: $personel['nama'],
            'pangkat' => $pangkatClean,
            'subbid'  => trim((string) $this->request->getPost('subbid')) ?: ($personel['subbid'] ?? ''),
            'ur'      => trim((string) $this->request->getPost('ur')) ?: ($personel['ur'] ?? ''),
            'qr_code' => $qrPath,
        ]);

        return redirect()->to('/admin/data-personel')->with('success', 'Data personel berhasil diperbarui.');
    }

    // HAPUS DATA PERSONEL (SOFT DELETE)
    public function delete($id)
    {
        $this->personelModel->delete($id);

        return redirect()->to('/admin/data-personel')
                         ->with('success', 'Data personel berhasil dipindahkan ke Data Terhapus.')
                         ->with('open_modal_sampah', true);
    }

    // RESTORE DATA PERSONEL
    public function restore($id)
    {
        $this->personelModel->builder()->where('id', $id)->update(['deleted_at' => null]);

        return redirect()->to('/admin/data-personel')
                         ->with('success', 'Data personel berhasil dipulihkan ke tabel utama.');
    }

    private function generateQRCode($nrp)
    {
        $writer = new PngWriter();
        $qrCode = QrCode::create($nrp)->setSize(200);
        $result = $writer->write($qrCode);

        $fileName = 'qr_' . $nrp . '.png';
        $uploadDir = FCPATH . 'uploads/qr_personel/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $result->saveToFile($uploadDir . $fileName);
        return 'uploads/qr_personel/' . $fileName;
    }

    public function export()
    {
        $personelData = $this->personelModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'PANGKAT');
        $sheet->setCellValue('D1', 'NRP');
        $sheet->setCellValue('E1', 'SUBBID');
        $sheet->setCellValue('F1', 'UR');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9D9D9');
        $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row = 2;
        $no = 1;
        foreach ($personelData as $p) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $p['nama']);
            $sheet->setCellValue('C' . $row, $p['pangkat']);
            $sheet->setCellValueExplicit('D' . $row, $p['nrp_nip'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('E' . $row, $p['subbid'] ?? '-');
            $sheet->setCellValue('F' . $row, $p['ur'] ?? $p['satker'] ?? '-');
            
            $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Export_Data_Personel_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}