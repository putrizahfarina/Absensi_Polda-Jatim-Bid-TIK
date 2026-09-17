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

        // Validasi agar jika input kosong, otomatis diisi default 'Bid TIK'
        $satkerInput = trim((string) $this->request->getPost('satker'));
        $satker = !empty($satkerInput) ? $satkerInput : 'Bid TIK';

        // Generate QR Code
        $qrPath = $this->generateQRCode($nrp);

        // Simpan data personel ke database
        $saved = $this->personelModel->save([
            'nrp_nip'       => $nrp,
            'nama'          => trim((string) $this->request->getPost('nama')),
            'pangkat'       => trim((string) $this->request->getPost('pangkat')),
            'satker'        => $satker,
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

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();

            if ($ext === 'csv') {
                $handle = fopen($file->getTempName(), "r");
                $row = 0;

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $row++;
                    if ($row == 1) continue; // Skip header

                    $nrp = trim($data[0] ?? '');
                    if (empty($nrp)) continue;

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
                // DIPERBAIKI: URL redirect dikembalikan ke /admin/data-personel
                return redirect()->to('/admin/data-personel')->with('success', 'Data personel berhasil diimpor.');
            }
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file. Pastikan format file .csv');
    }

    // UPDATE DATA PERSONEL
    public function update($id)
    {
        $personel = $this->personelModel->find($id);
        if (!$personel) {
            return redirect()->back()->with('error', 'Data personel tidak ditemukan.');
        }

        $nrp = trim((string) $this->request->getPost('nrp_nip'));
        $satkerInput = trim((string) $this->request->getPost('satker'));

        // Jika form dikirim kosong/tidak diisi, pertahankan nilai lama dari database
        $satker = !empty($satkerInput) ? $satkerInput : ($personel['satker'] ?? 'Bid TIK');

        // Jika NRP diubah, buat ulang QR Code-nya
        $qrPath = $personel['qr_code'];
        if (!empty($nrp) && $nrp !== $personel['nrp_nip']) {
            if (!empty($personel['qr_code']) && file_exists(FCPATH . $personel['qr_code'])) {
                @unlink(FCPATH . $personel['qr_code']);
            }
            $qrPath = $this->generateQRCode($nrp);
        }

        $this->personelModel->update($id, [
            'nrp_nip' => !empty($nrp) ? $nrp : $personel['nrp_nip'],
            'nama'    => trim((string) $this->request->getPost('nama')) ?: $personel['nama'],
            'pangkat' => trim((string) $this->request->getPost('pangkat')) ?: $personel['pangkat'],
            'satker'  => $satker,
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