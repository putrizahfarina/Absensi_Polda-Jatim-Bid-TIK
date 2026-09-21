<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use App\Models\PresensiModel;

class Absensi extends BaseController
{
    public function index()
    {
        $personelModel = new PersonelModel();
        $presensiModel = new PresensiModel();

        // 1. Data personel aktif
        $dataPersonel = $personelModel
            ->where('deleted_at', null)
            ->findAll();

        // 2. Data absensi yang sudah tercatat hari ini
        $hariIni = date('Y-m-d');

        $absensiHariIni = $presensiModel
            ->select('presensi.*, personel.nama, personel.nrp_nip, personel.satker')
            ->join('personel', 'personel.id = presensi.personel_id')
            ->where('DATE(presensi.waktu_masuk)', $hariIni)
            ->findAll();

        $totalPersonel = count($dataPersonel);
        $totalTercatat = count($absensiHariIni);
        $totalBelum    = max(0, $totalPersonel - $totalTercatat);

        $data = [
            'title'          => 'Absensi Personel',
            'personel'       => $dataPersonel,
            'absensiHariIni' => $absensiHariIni,
            'totalTercatat'  => $totalTercatat,
            'totalBelum'     => $totalBelum,
        ];

        return view('admin/absen/absensi', $data);
    }

    public function simpan()
    {
        $presensiModel = new PresensiModel();

        // Mengambil status absensi
        $statuses = $this->request->getPost('status');

        // Mengambil Deskripsi Kegiatan Hari Ini
        $deskripsiKegiatan = trim(
            $this->request->getPost('deskripsi_kegiatan') ?? ''
        );

        $waktuSekarang = date('Y-m-d H:i:s');
        $hariIni       = date('Y-m-d');

        // Koneksi database langsung
        // Digunakan karena PresensiModel tidak diubah
        $db = \Config\Database::connect();

        // Hanya proses jika ada status yang dipilih
        if (!empty($statuses) && is_array($statuses)) {

            foreach ($statuses as $personelId => $statusPilihan) {

                // Lewati jika status tidak diisi
                if (empty($statusPilihan)) {
                    continue;
                }

                // Cek apakah personel sudah memiliki absensi hari ini
                $cekAbsen = $presensiModel
                    ->where('personel_id', $personelId)
                    ->where('DATE(waktu_masuk)', $hariIni)
                    ->first();

                if ($cekAbsen) {

                    // Jika sudah ada, update status dan waktu
                    $presensiModel->update($cekAbsen['id'], [
                        'status'      => $statusPilihan,
                        'waktu_masuk' => $waktuSekarang
                    ]);

                    // Simpan deskripsi kegiatan
                    $db->table('presensi')
                        ->where('id', $cekAbsen['id'])
                        ->update([
                            'point_apel' => $deskripsiKegiatan
                        ]);

                } else {

                    // Jika belum ada, buat data absensi baru
                    $presensiModel->insert([
                        'personel_id' => $personelId,
                        'status'      => $statusPilihan,
                        'waktu_masuk' => $waktuSekarang,
                    ]);

                    // Ambil ID data yang baru dibuat
                    $presensiId = $presensiModel->getInsertID();

                    // Simpan deskripsi kegiatan
                    $db->table('presensi')
                        ->where('id', $presensiId)
                        ->update([
                            'point_apel' => $deskripsiKegiatan
                        ]);
                }
            }
        }

        return redirect()
            ->to(base_url('admin/absensi'))
            ->with(
                'pesan',
                'Data absensi berhasil disimpan!'
            );
    }

    public function hapus($id)
    {
        $presensiModel = new PresensiModel();

        $presensiModel->delete($id);

        return redirect()
            ->to(base_url('admin/absensi'))
            ->with(
                'pesan',
                'Data absensi berhasil dihapus!'
            );
    }
}