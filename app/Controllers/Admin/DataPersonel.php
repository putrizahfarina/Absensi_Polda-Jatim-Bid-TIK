<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class DataPersonel extends BaseController
{
    protected $personelModel;

    public function __construct()
    {
        // MENGGUNAKAN 'new' AGAR DIJAMIN TIDAK NULL
        $this->personelModel = new PersonelModel();
    }

    public function index()
    {
        $data = [
            'title'            => 'Data Personel',
            // Sekarang kita bisa pakai $this->personelModel dengan aman
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

        // Generate QR Code
        $qrPath = $this->generateQRCode($nrp);

        // Simpan data personel ke database (Memasukkan subbid dan ur)
        $saved = $this->personelModel->save([
            'nrp_nip'       => $nrp,
            'nama'          => trim((string) $this->request->getPost('nama')),
            'pangkat'       => trim((string) $this->request->getPost('pangkat')),
            'subbid'        => trim((string) $this->request->getPost('subbid')), // Menyimpan data Subbid
            'ur'            => trim((string) $this->request->getPost('ur')),     // Menyimpan data UR
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

    // Validasi file
    if (!$file || !$file->isValid() || $file->hasMoved()) {
        return redirect()->back()->with('error', 'File Excel tidak valid.');
    }

    $ext = strtolower($file->getClientExtension());

    if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
        return redirect()->back()->with('error', 'Format file harus XLSX, XLS, atau CSV.');
    }

    try {
        // Membaca file Excel atau CSV
        $spreadsheet = IOFactory::load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet();

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

        // Mulai dari baris kedua karena baris pertama adalah header
        foreach (array_slice($rows, 1) as $data) {

            $nrp = trim((string) ($data[0] ?? ''));
            $nama = trim((string) ($data[1] ?? ''));
            $pangkat = trim((string) ($data[2] ?? ''));
            $subbid = trim((string) ($data[3] ?? ''));
            $ur = trim((string) ($data[4] ?? ''));
            $jenisKelamin = strtoupper(trim((string) ($data[5] ?? 'L')));

            // Lewati baris yang benar-benar kosong
            if (
                $nrp === '' &&
                $nama === '' &&
                $pangkat === '' &&
                $subbid === '' &&
                $ur === ''
            ) {
                continue;
            }

            // Validasi data wajib
            if (
                $nrp === '' ||
                $nama === '' ||
                $pangkat === '' ||
                $subbid === '' ||
                $ur === ''
            ) {
                $dilewati++;
                continue;
            }

            // Periksa NRP duplikat dalam file
            if (in_array($nrp, $nrpDalamFile, true)) {
                $duplikat++;
                continue;
            }

            $nrpDalamFile[] = $nrp;

            // Periksa NRP yang sudah ada di database,
            // termasuk data yang sudah dihapus sementara
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
                'nama'          => $nama,
                'pangkat'       => $pangkat,
                'subbid'        => $subbid,
                'ur'            => $ur,
                'jenis_kelamin' => in_array($jenisKelamin, ['L', 'P'], true)
                    ? $jenisKelamin
                    : 'L',
                'qr_code'       => $qrPath,
            ]);

            if ($saved) {
                $berhasil++;
            } else {
                throw new \RuntimeException('Gagal menyimpan data NRP ' . $nrp);
            }
        }

        // Periksa transaksi database
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

        // Jika NRP diubah, buat ulang QR Code-nya
        $qrPath = $personel['qr_code'];
        if (!empty($nrp) && $nrp !== $personel['nrp_nip']) {
            if (!empty($personel['qr_code']) && file_exists(FCPATH . $personel['qr_code'])) {
                @unlink(FCPATH . $personel['qr_code']);
            }
            $qrPath = $this->generateQRCode($nrp);
        }

        // Update data personel dengan subbid dan ur (jika form dikosongkan, pakai data lama)
        $this->personelModel->update($id, [
            'nrp_nip' => !empty($nrp) ? $nrp : $personel['nrp_nip'],
            'nama'    => trim((string) $this->request->getPost('nama')) ?: $personel['nama'],
            'pangkat' => trim((string) $this->request->getPost('pangkat')) ?: $personel['pangkat'],
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
        // Mengembalikan data terhapus dengan mengosongkan kolom deleted_at
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
}