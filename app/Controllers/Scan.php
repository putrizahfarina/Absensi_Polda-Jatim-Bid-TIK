<?php

namespace App\Controllers;

use App\Models\PersonelModel;
use App\Models\PresensiModel;

class Scan extends BaseController
{
    protected $personelModel;
    protected $presensiModel;

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
        $this->presensiModel = new PresensiModel();
    }

    // ==========================================
    // HALAMAN ABSEN MASUK
    // URL: /scan
    // ==========================================
    public function index()
    {
        return view('scan/scan');
    }

    // ==========================================
    // HALAMAN ABSEN PULANG
    // URL: /scan/pulang
    // ==========================================
    public function pulang()
    {
        // Tetap menggunakan scan.php
        return view('scan/scan');
    }

    // ==========================================
    // PROSES ABSEN MASUK
    // POST: /scan/prosesScan
    // ==========================================
    public function prosesScan()
    {
        $nrp = trim($this->request->getPost('nrp_nip'));

        // Cek NRP/NIP kosong
        if ($nrp === '') {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'NRP/NIP tidak boleh kosong.'
            ]);
        }

        // Cari personel
        $personel = $this->personelModel
            ->where('nrp_nip', $nrp)
            ->first();

        // Personel tidak ditemukan
        if (!$personel) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data personel dengan NRP/NIP tersebut tidak ditemukan!'
            ]);
        }

        // Tanggal hari ini
        $today = date('Y-m-d');

        // Cek apakah sudah absen masuk hari ini
        $sudahAbsen = $this->presensiModel
            ->where('personel_id', $personel['id'])
            ->where('waktu_masuk >=', $today . ' 00:00:00')
            ->where('waktu_masuk <=', $today . ' 23:59:59')
            ->first();

        // Sudah absen masuk
        if ($sudahAbsen) {
            return $this->response->setJSON([
                'status'  => 'warning',
                'message' => 'Personel ' . $personel['nama'] .
                             ' sudah melakukan absensi masuk hari ini.'
            ]);
        }

        // Simpan absensi masuk
        $berhasil = $this->presensiModel->insert([
            'personel_id' => $personel['id'],
            'waktu_masuk' => date('Y-m-d H:i:s'),
            'status'      => 'Hadir'
        ]);

        // Gagal menyimpan
        if (!$berhasil) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan absensi masuk.'
            ]);
        }

        // Berhasil
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Absensi Masuk Berhasil! Selamat Datang ' .
                         $personel['pangkat'] . ' ' . $personel['nama']
        ]);
    }

    // ==========================================
    // PROSES ABSEN PULANG
    // POST: /scan/prosesScanPulang
    // ==========================================
    public function prosesScanPulang()
    {
        $nrp = trim($this->request->getPost('nrp_nip'));

        // Cek NRP/NIP kosong
        if ($nrp === '') {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'NRP/NIP tidak boleh kosong.'
            ]);
        }

        // Cari personel
        $personel = $this->personelModel
            ->where('nrp_nip', $nrp)
            ->first();

        // Personel tidak ditemukan
        if (!$personel) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data personel dengan NRP/NIP tersebut tidak ditemukan!'
            ]);
        }

        // Tanggal hari ini
        $today = date('Y-m-d');

        // Cari absensi masuk hari ini
        $presensi = $this->presensiModel
            ->where('personel_id', $personel['id'])
            ->where('waktu_masuk >=', $today . ' 00:00:00')
            ->where('waktu_masuk <=', $today . ' 23:59:59')
            ->first();

        // Belum absen masuk
        if (!$presensi) {
            return $this->response->setJSON([
                'status'  => 'warning',
                'message' => 'Personel ' . $personel['nama'] .
                             ' belum melakukan absen masuk hari ini.'
            ]);
        }

        // Sudah absen pulang
        if (!empty($presensi['waktu_pulang'])) {
            return $this->response->setJSON([
                'status'  => 'warning',
                'message' => 'Personel ' . $personel['nama'] .
                             ' sudah melakukan absen pulang hari ini.'
            ]);
        }

        // Waktu pulang
        $waktuPulang = date('Y-m-d H:i:s');

        // Update waktu pulang
        $berhasil = $this->presensiModel->update(
            $presensi['id'],
            [
                'waktu_pulang' => $waktuPulang
            ]
        );

        // Gagal update
        if (!$berhasil) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan waktu absen pulang.'
            ]);
        }

        // Berhasil
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Absen Pulang Berhasil! Sampai jumpa ' .
                         $personel['pangkat'] . ' ' . $personel['nama'],
            'nama'    => $personel['nama'],
            'pangkat' => $personel['pangkat'],
            'waktu'   => date('H:i:s', strtotime($waktuPulang))
        ]);
    }
}