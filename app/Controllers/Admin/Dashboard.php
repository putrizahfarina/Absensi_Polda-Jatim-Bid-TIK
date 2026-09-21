<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonelModel;
use App\Models\PresensiModel;
use CodeIgniter\I18n\Time;

class Dashboard extends BaseController
{
    protected PersonelModel $personelModel;
    protected PresensiModel $presensiModel;
    protected $generalSettings;

    public function __construct()
    {
        $this->personelModel = new PersonelModel();
        $this->presensiModel = new PresensiModel();

        $this->generalSettings = (object) [
            'jam_pulang_standard' => '15:00:00'
        ];
    }

    public function index()
    {
        $now = Time::now();
        $today = $now->toDateString();

        // ========================================================
        // DATE RANGE 7 HARI
        // ========================================================

        $dateRange = [];
        $chartLabelColors = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Time::now()->subDays($i);

            if ($i === 0) {
                $formattedDate = 'Hari ini';
            } else {
                $formattedDate = $date->getDay() . ' ' .
                    substr($date->toFormattedDateString(), 0, 3);
            }

            $dateRange[] = $formattedDate;
            $chartLabelColors[] = '#333';
        }

        // ========================================================
        // JAM PULANG
        // ========================================================

        $jamPulangStandard =
            $this->generalSettings->jam_pulang_standard ?? '15:00:00';

        $isAfterSchool =
            $now->toTimeString() > $jamPulangStandard;

        // ========================================================
        // DATA PERSONEL
        // ========================================================

        $personel = $this->personelModel
            ->where('deleted_at', null)
            ->findAll();

        $totalPersonel = count($personel);

        // ========================================================
        // STATISTIK KEHADIRAN HARI INI
        // ========================================================

        $jumlahKehadiran = $this->getAttendanceStats($today);

        // ========================================================
        // GRAFIK KEHADIRAN
        // ========================================================

        $grafikKehadiran =
            $this->presensiModel->getAttendanceTrend(7);

        // ========================================================
        // DATA DASHBOARD
        // ========================================================

        $data = [
            'title' => 'Dashboard',
            'ctx' => 'admin-dashboard',

            // Data personel
            'siswa' => $personel,

            // Dipertahankan agar view lama tidak error
            'guru' => [],
            'kelas' => [],
            'jurusan' => [],

            // Grafik
            'dateRange' => $dateRange,
            'chartLabelColors' => $chartLabelColors,
            'dateNow' => $now->toLocalizedString('d MMMM Y'),

            'grafikKehadiranSiswa' => $grafikKehadiran,
            'grafikKehadiranGuru' => [],

            // Statistik hari ini
            'jumlahKehadiranSiswa' => $jumlahKehadiran,

            'jumlahKehadiranGuru' => [
                'hadir' => 0,
                'sakit' => 0,
                'izin' => 0,
                'alfa' => 0
            ],

            'totalSiswa' => $totalPersonel,
            'totalGuru' => 0,

            'petugas' => [],

            'topLateStudents' => [],
            'absenteeAlerts' => [],

            // Data khusus dashboard Polda
            'totalPersonel' => $totalPersonel,
            'totalHadir' => $jumlahKehadiran['hadir'],
            'totalDinas' => $jumlahKehadiran['dinas'],
            'totalLepasDinas' => $jumlahKehadiran['lepas_dinas'],
            'totalCuti' => $jumlahKehadiran['cuti'],
            'totalSakit' => $jumlahKehadiran['sakit'],
            'totalIzin' => $jumlahKehadiran['izin'],
            'totalTerlambat' => $jumlahKehadiran['terlambat'],
            'totalDik' => $jumlahKehadiran['dik'],
            'totalBko' => $jumlahKehadiran['bko'],
        ];

        return view(
            'admin/dashboard',
            $data
        );
    }

    // ============================================================
    // MENGAMBIL STATISTIK ABSENSI BERDASARKAN TANGGAL
    // ============================================================

    private function getAttendanceStats(string $tanggal): array
    {
        $statusList = [
            'HADIR',
            'DINAS',
            'LEPAS DINAS',
            'CUTI',
            'SAKIT',
            'IZIN',
            'TERLAMBAT',
            'DIK',
            'BKO'
        ];

        $stats = [
            'hadir' => 0,
            'dinas' => 0,
            'lepas_dinas' => 0,
            'cuti' => 0,
            'sakit' => 0,
            'izin' => 0,
            'terlambat' => 0,
            'dik' => 0,
            'bko' => 0,
            'alfa' => 0
        ];

        // Ambil semua presensi hari ini
        $presensi = $this->presensiModel
            ->where(
                'waktu_masuk >=',
                $tanggal . ' 00:00:00'
            )
            ->where(
                'waktu_masuk <=',
                $tanggal . ' 23:59:59'
            )
            ->findAll();

        foreach ($presensi as $absen) {
            $status = strtoupper(
                trim($absen['status'] ?? '')
            );

            switch ($status) {
                case 'HADIR':
                    $stats['hadir']++;
                    break;

                case 'DINAS':
                    $stats['dinas']++;
                    break;

                case 'LEPAS DINAS':
                    $stats['lepas_dinas']++;
                    break;

                case 'CUTI':
                    $stats['cuti']++;
                    break;

                case 'SAKIT':
                    $stats['sakit']++;
                    break;

                case 'IZIN':
                    $stats['izin']++;
                    break;

                case 'TERLAMBAT':
                    $stats['terlambat']++;
                    break;

                case 'DIK':
                    $stats['dik']++;
                    break;

                case 'BKO':
                    $stats['bko']++;
                    break;
            }
        }

        return $stats;
    }

    // ============================================================
    // AUDIT LOG
    // ============================================================

    public function auditLog()
    {
        $data = [
            'title' => 'Audit Log - Riwayat Perubahan',
            'ctx' => 'audit-log',
            'logs' => []
        ];

        return view(
            'admin/audit_log',
            $data
        );
    }

    // ============================================================
    // LIVE STATS
    // ============================================================

    public function getLiveStats()
    {
        $now = Time::now();
        $today = $now->toDateString();

        $stats = $this->getAttendanceStats($today);

        $totalPersonel = $this->personelModel
            ->where('deleted_at', null)
            ->countAllResults();

        $jamPulangStandard =
            $this->generalSettings->jam_pulang_standard ?? '15:00:00';

        $isAfterSchool =
            $now->toTimeString() > $jamPulangStandard;

        return $this->response->setJSON([
            'stats' => $stats,
            'totalPersonel' => $totalPersonel,
            'totalSiswa' => $totalPersonel,
            'isAfterSchool' => $isAfterSchool,
            'lastUpdate' => $now->toTimeString()
        ]);
    }

    // ============================================================
    // FILTER DATA
    // ============================================================

    public function filterData()
    {
        $now = Time::now();
        $today = $now->toDateString();

        $stats = $this->getAttendanceStats($today);

        $grafikKehadiran =
            $this->presensiModel->getAttendanceTrend(7);

        $jumlahPersonel = $this->personelModel
            ->where('deleted_at', null)
            ->countAllResults();

        $data = [
            'hadir' => $stats['hadir'],
            'dinas' => $stats['dinas'],
            'lepas_dinas' => $stats['lepas_dinas'],
            'cuti' => $stats['cuti'],
            'sakit' => $stats['sakit'],
            'izin' => $stats['izin'],
            'terlambat' => $stats['terlambat'],
            'dik' => $stats['dik'],
            'bko' => $stats['bko'],
            'alfa' => $stats['alfa'],
            'totalSiswa' => $jumlahPersonel,
            'totalPersonel' => $jumlahPersonel
        ];

        return $this->response->setJSON([
            'result' => 1,
            'htmlContent' => view(
                'admin/_dashboard_siswa_stats',
                $data
            ),
            'chartData' => $grafikKehadiran,
            'totalSiswa' => $jumlahPersonel,
            'totalPersonel' => $jumlahPersonel
        ]);
    }
}