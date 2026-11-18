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

        // Daftar status yang menggunakan rentang tanggal
        $rangeStatuses = ['Dinas Luar', 'Cuti', 'BKO', 'Pendidikan'];

        // Map data absensi hari ini berdasarkan personel_id
        $absenMap = [];
        foreach ($existingAbsen as $absen) {
            $pId = $absen['personel_id'];
            $status = $absen['status'] ?? '';

            $absen['tanggal_mulai'] = $today;
            $absen['tanggal_selesai'] = $today;

            // Jika status termasuk rentang tanggal, cari tanggal awal & akhir yang berurutan
            if (in_array($status, $rangeStatuses)) {
                $riwayat = $this->presensiModel
                    ->select('DATE(waktu_masuk) as tgl', false)
                    ->where('personel_id', $pId)
                    ->where('status', $status)
                    ->orderBy('tgl', 'ASC')
                    ->findAll();

                $tanggalList = array_column($riwayat, 'tgl');

                // Telusuri mundur dari hari ini untuk mencari tanggal_mulai
                $mulai = $today;
                while (in_array(date('Y-m-d', strtotime($mulai . ' -1 day')), $tanggalList)) {
                    $mulai = date('Y-m-d', strtotime($mulai . ' -1 day'));
                }

                // Telusuri maju dari hari ini untuk mencari tanggal_selesai
                $selesai = $today;
                while (in_array(date('Y-m-d', strtotime($selesai . ' +1 day')), $tanggalList)) {
                    $selesai = date('Y-m-d', strtotime($selesai . ' +1 day'));
                }

                $absen['tanggal_mulai'] = $mulai;
                $absen['tanggal_selesai'] = $selesai;
            }

            $absenMap[$pId] = $absen;
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
        
        $exceptionMap = [];
        $otherDatesExceptions = []; // Menyimpan absensi untuk tanggal-tanggal selain hari ini
        
        foreach ($exceptions as $exc) {
            $pId = $exc['personel_id'];
            $exceptionMap[$pId] = [
                'status'     => $exc['status'],
                'keterangan' => $exc['keterangan'] ?? ''
            ];

            // Jika status butuh rentang tanggal, kita siapkan datanya untuk tanggal-tanggal lain
            if (in_array($exc['status'], ['Dinas Luar', 'Cuti', 'BKO', 'Pendidikan'])) {
                $tglMulai = $exc['tanggal_mulai'] ?? $today;
                $tglSelesai = $exc['tanggal_selesai'] ?? $today;

                if (!empty($tglMulai) && !empty($tglSelesai)) {
                    $start = strtotime($tglMulai);
                    $end = strtotime($tglSelesai);
                    
                    if ($start && $end && $start <= $end) {
                        for ($time = $start; $time <= $end; $time += 86400) {
                            $dateStr = date('Y-m-d', $time);
                            
                            // Eksekusi untuk tanggal selain HARI INI
                            if ($dateStr > $today) {
                                $otherDatesExceptions[] = [
                                    'personel_id' => $pId,
                                    'status'      => $exc['status'],
                                    'keterangan'  => $exc['keterangan'] ?? '',
                                    'tanggal'     => $dateStr
                                ];
                            }
                        }
                    }
                }
            }
        }

        // Hapus data absensi hari ini untuk di-sync ulang secara bersih
        $this->presensiModel->where('DATE(waktu_masuk)', $today)->delete();

        $dataInsert = [];
        foreach ($allPersonel as $p) {
            $pId = $p['id'];
            if (isset($exceptionMap[$pId])) {
                // Status Pengecualian Hari Ini
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

        // PROSES RENTANG TANGGAL LAINNYA (Misal: Besok s.d. Selesai)
        // Kita simpan agar besok admin tidak perlu input ulang
        foreach ($otherDatesExceptions as $fExc) {
            // Hapus data lama di tanggal terkait agar tidak terjadi duplikat
            $this->presensiModel
                 ->where('personel_id', $fExc['personel_id'])
                 ->where('DATE(waktu_masuk)', $fExc['tanggal'])
                 ->delete();

            // Masukkan data baru sesuai status rentangnya
            $this->presensiModel->insert([
                'personel_id' => $fExc['personel_id'],
                'status'      => $fExc['status'],
                'keterangan'  => $fExc['keterangan'],
                'waktu_masuk' => $fExc['tanggal'] . ' 07:00:00' // Default jam masuk
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Absensi seluruh personel berhasil disinkronkan!'
        ]);
    }
}