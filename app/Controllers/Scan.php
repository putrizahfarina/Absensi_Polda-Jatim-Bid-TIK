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

    public function index()
    {
        return view('scan');
    }

    public function prosesScan()
    {
        $nrp = $this->request->getPost('nrp_nip');
        $personel = $this->personelModel->where('nrp_nip', $nrp)->first();

        if (!$personel) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data personel dengan NRP/NIP tersebut tidak ditemukan!'
            ]);
        }

        // Cek apakah hari ini sudah absen
        $today = date('Y-m-d');
        $sudahAbsen = $this->presensiModel
            ->where('personel_id', $personel['id'])
            ->like('waktu_masuk', $today)
            ->first();

        if ($sudahAbsen) {
            return $this->response->setJSON([
                'status'  => 'warning',
                'message' => 'Personel ' . $personel['nama'] . ' sudah melakukan absensi hari ini.'
            ]);
        }

        // Simpan Absensi
        $this->presensiModel->save([
            'personel_id' => $personel['id'],
            'waktu_masuk' => date('Y-m-d H:i:s'),
            'status'      => 'Hadir'
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Absensi Berhasil! Selamat Datang ' . $personel['pangkat'] . ' ' . $personel['nama']
        ]);
    }
}