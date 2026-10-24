<?php

namespace App\Controllers\Admin;
use App\Models\DeskripsiKegiatanModel;
use App\Controllers\BaseController;
use App\Models\PersonelModel;
use App\Models\PresensiModel;

class Absensi extends BaseController
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
        // 1. Ambil seluruh data personel aktif
        $personel = $this->personelModel->orderBy('nama', 'ASC')->findAll();

        // 2. Ambil absensi hari ini jika sudah ada
        $today = date('Y-m-d');
        $existingAbsen = $this->presensiModel->where('DATE(waktu_masuk)', $today)->findAll();

        // Map data absensi hari ini berdasarkan personel_id
        $absenMap = [];
        foreach ($existingAbsen as $absen) {
            $absenMap[$absen['personel_id']] = $absen;
        }

        // Tanggal Indonesia
        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'indonesian');
        $formatter = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
        $tanggalFormat = $formatter->format(new \DateTime());

        $data = [
            'title'         => 'Absensi Personel',
            'tanggal'       => $tanggalFormat,
            'personel'      => $personel,
            'absenHariIni'  => $absenMap
        ];

        return view('admin/absen/absensi', $data);
    }

    public function simpan()
    {
        $json = $this->request->getJSON(true);
        // Simpan deskripsi kegiatan untuk tanggal hari ini
$deskripsi = trim($json['deskripsi'] ?? '');
$deskripsiModel = new DeskripsiKegiatanModel();

$existingDeskripsi = $deskripsiModel
    ->where('tanggal', date('Y-m-d'))
    ->first();

if ($existingDeskripsi) {
    $deskripsiModel->update($existingDeskripsi['id'], [
        'deskripsi' => $deskripsi
    ]);
} else {
    $deskripsiModel->insert([
        'tanggal'   => date('Y-m-d'),
        'deskripsi' => $deskripsi
    ]);
}
        $exceptions = $json['exceptions'] ?? []; // Array pengecualian
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');

        // Ambil semua ID personel
        $allPersonel = $this->personelModel->findAll();
        
        // Buat map pengecualian: [personel_id => ['status' => ..., 'keterangan' => ...]]
        $exceptionMap = [];
        foreach ($exceptions as $exc) {
            $exceptionMap[$exc['personel_id']] = [
                'status'     => $exc['status'],
                'keterangan' => $exc['keterangan'] ?? ''
            ];
        }

        // Hapus data absensi hari ini untuk di-sync ulang secara bersih
        $this->presensiModel->where('DATE(waktu_masuk)', $today)->delete();

        $dataInsert = [];
        foreach ($allPersonel as $p) {
            $pId = $p['id'];
            if (isset($exceptionMap[$pId])) {
                // Status Pengecualian (Sakit/DL/Izin/Alfa/dll)
                $dataInsert[] = [
                    'personel_id' => $pId,
                    'status'      => $exceptionMap[$pId]['status'],
                    'keterangan'  => $exceptionMap[$pId]['keterangan'],
                    'waktu_masuk' => $now
                ];
            } else {
                // Otomatis HADIR
                $dataInsert[] = [
                    'personel_id' => $pId,
                    'status'      => 'Hadir',
                    'keterangan'  => '',
                    'waktu_masuk' => $now
                ];
            }
        }

        if (!empty($dataInsert)) {
            $this->presensiModel->insertBatch($dataInsert);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Absensi seluruh personel berhasil disinkronkan!'
        ]);
    }
}