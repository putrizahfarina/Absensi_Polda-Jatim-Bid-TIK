<?php

namespace App\Controllers;

use App\Models\PersonelModel;
use App\Models\PresensiModel;

class CekKehadiran extends BaseController
{
    protected $personelModel;
    protected $presensiModel;

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
        $this->presensiModel = new PresensiModel();

        helper(['form', 'url']);
    }

    public function index()
    {
        return view('cek_kehadiran/index', [
            'title' => 'Portal Cek Kehadiran Mandiri'
        ]);
    }

    public function view()
    {
        $nrpNip = trim($this->request->getPost('nrp_nip'));

        if (empty($nrpNip)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'NRP/NIP wajib diisi.');
        }

        // Cari personel berdasarkan NRP/NIP
        $personel = $this->personelModel
            ->where('nrp_nip', $nrpNip)
            ->first();

        if (!$personel) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Data personel dengan NRP/NIP tersebut tidak ditemukan.'
                );
        }

        // Ambil presensi personel pada tahun berjalan
        $year = date('Y');

        $history = $this->presensiModel
            ->where('personel_id', $personel['id'])
            ->where(
                'waktu_masuk >=',
                $year . '-01-01 00:00:00'
            )
            ->where(
                'waktu_masuk <=',
                $year . '-12-31 23:59:59'
            )
            ->orderBy('waktu_masuk', 'DESC')
            ->findAll();

        // Statistik bulan berjalan
        $month = date('m');

        $stats = [
            'hadir' => 0,
            'sakit' => 0,
            'izin'  => 0,
            'alfa'  => 0
        ];

        foreach ($history as $item) {

            if (
                empty($item['waktu_masuk']) ||
                date('m', strtotime($item['waktu_masuk'])) != $month
            ) {
                continue;
            }

            $status = strtolower($item['status'] ?? '');

            if ($status === 'hadir') {
                $stats['hadir']++;
            } elseif ($status === 'sakit') {
                $stats['sakit']++;
            } elseif ($status === 'izin') {
                $stats['izin']++;
            } elseif ($status === 'alfa') {
                $stats['alfa']++;
            }
        }

        return view('cek_kehadiran/hasil', [
            'title'     => 'Riwayat Kehadiran',
            'personel'  => $personel,
            'history'   => $history,
            'stats'     => $stats,
            'monthName' => date('F Y')
        ]);
    }
}