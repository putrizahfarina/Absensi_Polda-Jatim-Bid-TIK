<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class DataPersonel extends BaseController
{
    protected $personelModel;

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
    }

    // HALAMAN DATA PERSONEL
    public function index()
    {
        $personel = $this->personelModel->findAll();

        // Cek QR setiap personel.
        // Jika path QR ada di database tetapi file fisiknya hilang,
        // QR akan dibuat ulang otomatis.
        foreach ($personel as &$p) {
            $qrPath = $p['qr_code'] ?? '';

            if (
                !empty($p['nrp_nip']) &&
                (
                    empty($qrPath) ||
                    !file_exists(FCPATH . $qrPath)
                )
            ) {
                $newQrPath = $this->generateQRCode($p['nrp_nip']);

                $this->personelModel->update($p['id'], [
                    'qr_code' => $newQrPath
                ]);

                $p['qr_code'] = $newQrPath;
            }
        }

        return view('admin/data/data-personel', [
            'title'            => 'Data Personel',
            'personel'         => $personel,
            'personelTerhapus' => $this->personelModel->onlyDeleted()->findAll()
        ]);
    }

    // SIMPAN DATA DARI MODAL TAMBAH
    public function store()
    {
        $nrp = trim((string) $this->request->getPost('nrp_nip'));

        if (empty($nrp)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'NRP/NIP Wajib diisi!');
        }

        $satkerInput = trim((string) $this->request->getPost('satker'));
        $satker = !empty($satkerInput) ? $satkerInput : 'Bid TIK';

        // Generate QR Code
        $qrPath = $this->generateQRCode($nrp);

        // Simpan data personel
        $saved = $this->personelModel->save([
            'nrp_nip'       => $nrp,
            'nama'          => trim((string) $this->request->getPost('nama')),
            'pangkat'       => trim((string) $this->request->getPost('pangkat')),
            'satker'        => $satker,
            'jenis_kelamin' => 'L',
            'qr_code'       => $qrPath,
        ]);

        if ($saved) {
            return redirect()->to('/admin/data-personel')
                ->with('success', 'Data personel & QR Code berhasil disimpan.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal menyimpan data personel.');
    }

    // HALAMAN IMPORT
    public function importView()
    {
        $data = [
            'title' => 'Import Data Personel'
        ];

        return view('admin/data/import-personel', $data);
    }

    // IMPORT DATA PERSONEL
    public function import()
    {
        $file = $this->request->getFile('file_excel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();

            if ($ext === 'csv') {
                $handle = fopen($file->getTempName(), 'r');
                $row = 0;

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $row++;

                    // Skip header
                    if ($row == 1) {
                        continue;
                    }

                    $nrp = trim($data[0] ?? '');

                    if (empty($nrp)) {
                        continue;
                    }

                    $qrPath = $this->generateQRCode($nrp);
                    $satkerCsv = trim($data[4] ?? '');

                    $this->personelModel->save([
                        'nrp_nip'       => $nrp,
                        'nama'          => trim($data[1] ?? ''),
                        'pangkat'       => trim($data[2] ?? ''),
                        'jabatan'       => trim($data[3] ?? ''),
                        'satker'        => !empty($satkerCsv) ? $satkerCsv : 'Bid TIK',
                        'jenis_kelamin' => trim($data[5] ?? 'L'),
                        'qr_code'       => $qrPath,
                    ]);
                }

                fclose($handle);

                return redirect()->to('/admin/data-personel')
                    ->with('success', 'Data personel berhasil diimpor.');
            }
        }

        return redirect()->back()
            ->with('error', 'Gagal mengunggah file. Pastikan format file .csv');
    }

    // UPDATE DATA PERSONEL
    public function update($id)
    {
        $personel = $this->personelModel->find($id);

        if (!$personel) {
            return redirect()->back()
                ->with('error', 'Data personel tidak ditemukan.');
        }

        $nrp = trim((string) $this->request->getPost('nrp_nip'));
        $satkerInput = trim((string) $this->request->getPost('satker'));

        $satker = !empty($satkerInput)
            ? $satkerInput
            : ($personel['satker'] ?? 'Bid TIK');

        // Jika NRP diubah, buat QR baru
        $qrPath = $personel['qr_code'];

        if (!empty($nrp) && $nrp !== $personel['nrp_nip']) {
            if (
                !empty($personel['qr_code']) &&
                file_exists(FCPATH . $personel['qr_code'])
            ) {
                @unlink(FCPATH . $personel['qr_code']);
            }

            $qrPath = $this->generateQRCode($nrp);
        }

        $this->personelModel->update($id, [
            'nrp_nip' => !empty($nrp)
                ? $nrp
                : $personel['nrp_nip'],

            'nama' => trim((string) $this->request->getPost('nama'))
                ?: $personel['nama'],

            'pangkat' => trim((string) $this->request->getPost('pangkat'))
                ?: $personel['pangkat'],

            'satker' => $satker,
            'qr_code' => $qrPath,
        ]);

        return redirect()->to('/admin/data-personel')
            ->with('success', 'Data personel berhasil diperbarui.');
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
        $this->personelModel
            ->builder()
            ->where('id', $id)
            ->update(['deleted_at' => null]);

        return redirect()->to('/admin/data-personel')
            ->with('success', 'Data personel berhasil dipulihkan ke tabel utama.');
    }

    // REGENERATE QR CODE
    public function regenerateQR($id)
    {
        $personel = $this->personelModel->find($id);

        if (!$personel) {
            return redirect()->back()
                ->with('error', 'Data personel tidak ditemukan.');
        }

        $nrp = trim((string) $personel['nrp_nip']);

        if (empty($nrp)) {
            return redirect()->back()
                ->with('error', 'NRP personel tidak ditemukan.');
        }

        if (
            !empty($personel['qr_code']) &&
            file_exists(FCPATH . $personel['qr_code'])
        ) {
            @unlink(FCPATH . $personel['qr_code']);
        }

        $qrPath = $this->generateQRCode($nrp);

        $this->personelModel->update($id, [
            'qr_code' => $qrPath
        ]);

        return redirect()->to('/admin/data-personel')
            ->with('success', 'QR Code berhasil dibuat ulang.');
    }

    // GENERATE QR CODE
    private function generateQRCode($nrp)
    {
        $writer = new PngWriter();

        $qrCode = QrCode::create($nrp)
            ->setSize(200);

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