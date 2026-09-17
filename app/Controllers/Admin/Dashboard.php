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
      // Menggunakan model Personel Bid TIK yang benar
      $this->personelModel = new PersonelModel();
      $this->presensiModel = new PresensiModel();
      
      // Mencegah error jika generalSettings kosong
      $this->generalSettings = (object) ['jam_pulang_standard' => '15:00:00'];
   }

   public function index()
   {
      $now = Time::now();

      $dateRange = [];
      $chartLabelColors = [];
      
      // Dipertahankan sesuai struktur bawaan
      for ($i = 6; $i >= 0; $i--) {
         $date = $now->subDays($i)->toDateString();
         $isHoliday = false; // Dibuat default false agar tidak error HariLiburModel
         if ($i == 0) {
            $formattedDate = "Hari ini";
         } else {
            $t = $now->subDays($i);
            $formattedDate = "{$t->getDay()} " . substr($t->toFormattedDateString(), 0, 3);
         }
         array_push($dateRange, $formattedDate);
         array_push($chartLabelColors, $isHoliday ? '#f44336' : '#333');
      }

      $today = $now->toDateString();
      
      $jamPulangStandard = $this->generalSettings->jam_pulang_standard ?? '14:00:00';
      $isAfterSchool = $now->toTimeString() > $jamPulangStandard;

      // Memanggil fungsi dari PresensiModel (bukan personel)
      $grafikKehadiranSiswa = $this->presensiModel->getAttendanceTrend();

      $data = [
         'title' => 'Dashboard',
         'ctx' => 'admin-dashboard',

         // 'siswa' diubah menjadi mengambil data personel
         'siswa' => $this->personelModel->findAll(),
         
         // Array dikosongkan sementara agar di View template Anda tidak memicu error "Undefined variable"
         'guru' => [], 
         'kelas' => [],
         'jurusan' => [],

         'dateRange' => $dateRange,
         'chartLabelColors' => $chartLabelColors,
         'dateNow' => $now->toLocalizedString('d MMMM Y'),

         'grafikKehadiranSiswa' => $grafikKehadiranSiswa,
         'grafikKehadiranGuru' => [],

         // Menghitung kehadiran menggunakan PresensiModel berdasarkan database Bid TIK
         'jumlahKehadiranSiswa' => [
            'hadir' => count($this->presensiModel->where('status', 'Hadir')->like('waktu_masuk', $today)->findAll()),
            'sakit' => count($this->presensiModel->where('status', 'Sakit')->like('waktu_masuk', $today)->findAll()),
            'izin' => count($this->presensiModel->where('status', 'Izin')->like('waktu_masuk', $today)->findAll()),
            'alfa' => count($this->presensiModel->where('status', 'Alfa')->like('waktu_masuk', $today)->findAll())
         ],

         'jumlahKehadiranGuru' => [
            'hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alfa' => 0
         ],

         'totalSiswa' => $this->personelModel->countAllResults(),
         'totalGuru' => 0,

         'petugas' => [],
         
         // Error sebelumnya terjadi karena JOIN tb_siswa, kita kosongkan agar view aman
         'topLateStudents' => [],
         'absenteeAlerts' => [],
      ];

      return view('admin/dashboard', $data);
   }

   public function auditLog()
   {
      // Disesuaikan agar view audit_log berjalan tanpa memanggil error model
      $data = [
         'title' => 'Audit Log - Riwayat Perubahan',
         'ctx' => 'audit-log',
         'logs' => [] 
      ];
      return view('admin/audit_log', $data);
   }

   public function getLiveStats()
   {
      $now = Time::now();
      $today = $now->toDateString();

      // Statistik Live 
      $jumlahKehadiranSiswa = [
         'hadir' => count($this->presensiModel->where('status', 'Hadir')->like('waktu_masuk', $today)->findAll()),
         'sakit' => count($this->presensiModel->where('status', 'Sakit')->like('waktu_masuk', $today)->findAll()),
         'izin' => count($this->presensiModel->where('status', 'Izin')->like('waktu_masuk', $today)->findAll()),
         'alfa' => count($this->presensiModel->where('status', 'Alfa')->like('waktu_masuk', $today)->findAll())
      ];

      $totalSiswa = $this->personelModel->countAllResults();
      
      $jamPulangStandard = $this->generalSettings->jam_pulang_standard ?? '14:00:00';
      $isAfterSchool = $now->toTimeString() > $jamPulangStandard;

      return $this->response->setJSON([
         'stats' => $jumlahKehadiranSiswa,
         'totalSiswa' => $totalSiswa,
         'isAfterSchool' => $isAfterSchool,
         'lastUpdate' => $now->toTimeString()
      ]);
   }

   public function filterData()
   {
      $now = Time::now();
      $today = $now->toDateString();

      // Statistik Siswa (Personel)
      $jumlahKehadiranSiswa = [
         'hadir' => count($this->presensiModel->where('status', 'Hadir')->like('waktu_masuk', $today)->findAll()),
         'sakit' => count($this->presensiModel->where('status', 'Sakit')->like('waktu_masuk', $today)->findAll()),
         'izin' => count($this->presensiModel->where('status', 'Izin')->like('waktu_masuk', $today)->findAll()),
         'alfa' => count($this->presensiModel->where('status', 'Alfa')->like('waktu_masuk', $today)->findAll())
      ];

      // Panggil fungsi getAttendanceTrend
      $grafikKehadiranSiswa = $this->presensiModel->getAttendanceTrend(7);
      $jumlahSiswa = $this->personelModel->countAllResults();

      $data = [
         'hadir' => $jumlahKehadiranSiswa['hadir'],
         'sakit' => $jumlahKehadiranSiswa['sakit'],
         'izin' => $jumlahKehadiranSiswa['izin'],
         'alfa' => $jumlahKehadiranSiswa['alfa'],
         'totalSiswa' => $jumlahSiswa,
      ];

      return $this->response->setJSON([
         'result' => 1,
         'htmlContent' => view('admin/_dashboard_siswa_stats', $data),
         'chartData' => $grafikKehadiranSiswa,
         'totalSiswa' => $jumlahSiswa
      ]);
   }
}