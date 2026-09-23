<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class GenerateQR extends BaseController
{
    protected PersonelModel $personelModel;
    protected KelasModel $kelasModel;
    protected GuruModel $guruModel;

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        if (!can_view_report()) {
            return redirect()->to('admin');
        }

        $personel = $this->personelModel->findAll();
        $kelas = $this->kelasModel->getDataKelas();
        $guru = $this->guruModel->getAllGuru();

        $data = [
            'title' => 'Generate QR Code',
            'ctx' => 'admin-qr',
            'personel' => $personel,
            'kelas' => $kelas,
            'guru' => $guru
        ];

        return view('admin/generate-qr/generate-qr', $data);
    }

    public function getPersonel()
    {
        $personel = $this->personelModel->findAll();

        return $this->response->setJSON($personel);
    }
}