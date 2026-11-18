<?php
$user     = auth()->user();
$context  = $ctx ?? 'dashboard';
$menuItems = [];

// ── Sidebar color based on context ──
switch ($context) {
   case 'absen-siswa':
   case 'siswa':
   case 'kelas':
      $sidebarColor = 'purple';
      break;
   case 'absen-guru':
   case 'guru':
      $sidebarColor = 'green';
      break;
   case 'qr':
   case 'backup':
      $sidebarColor = 'danger';
      break;
   default:
      $sidebarColor = 'azure';
      break;
}

// ── Role-based logo label ──
$roleLabel = 'Operator Petugas Absensi';
if ($user) {
   if ($user->inGroup('superadmin')) {
      $roleLabel = 'SIPATIK';
   } elseif ($user->inGroup('kepsek')) {
      $roleLabel = 'Kepala Sekolah';
   } elseif ($user->inGroup('scanner') && !$user->can('admin.access')) {
      $roleLabel = 'Petugas Scanner';
   } elseif ($user->inGroup('guru') && !$user->inGroup('admin') && !$user->inGroup('superadmin')) {
      $roleLabel = 'Guru / Wali Kelas';
   }
}

// ── Collect menu sections ──
$hasTeacherSection = false;
$hasAdminSection   = false;

// ── Teacher / Wali Kelas menus ──
if ($user && is_guru()) {
   $hasTeacherSection = true;
   $menuItems = array_merge($menuItems, [
      ['title' => 'Dashboard Wali Kelas', 'url' => 'teacher/dashboard', 'icon' => 'dashboard', 'context' => 'teacher-dashboard'],
      ['title' => 'Pengajuan Izin',       'url' => 'teacher/perizinan',  'icon' => 'mail', 'context' => 'teacher-perizinan'],
      ['title' => 'Laporan Kelas',         'url' => 'teacher/laporan',   'icon' => 'print',      'context' => 'teacher-laporan'],
      ['title' => 'QR Code Siswa',         'url' => 'teacher/qr',         'icon' => 'qr_code',    'context' => 'teacher-qr'],
      ['title' => 'Manajemen Kehadiran',   'url' => 'teacher/attendance', 'icon' => 'event_note', 'context' => 'teacher-attendance'],
   ]);
}

$adminMenus = [
   ['title' => 'Dashboard',        'url' => 'admin/dashboard',     'icon' => 'dashboard', 'context' => 'admin-dashboard', 'perm' => 'admin.access'],
   ['title' => 'Absensi Personel', 'url' => 'admin/absensi',       'icon' => 'checklist', 'context' => 'absen-guru',      'perm' => 'attendance.edit'],
   ['title' => 'Data Personel',    'url' => 'admin/data-personel', 'icon' => 'person',    'context' => 'siswa',           'perm' => 'students.manage'],
   ['title' => 'Generate Laporan', 'url' => 'admin/laporan',       'icon' => 'print',     'context' => 'laporan',         'perm' => 'attendance.view'],
   ['title' => 'Data Petugas',     'url' => 'admin/petugas',       'icon' => 'computer',  'context' => 'petugas',         'perm' => 'petugas.manage'],
];

$adminItems = [];
foreach ($adminMenus as $m) {
   if ($user && $user->can($m['perm'])) {
      $adminItems[] = $m;
   }
}

if ($adminItems !== []) {
   $hasAdminSection = true;
}

// ── Decide whether to show section headers ──
$showSectionHeaders = ($hasTeacherSection && $hasAdminSection);
?>
<div class="sidebar" data-color="danger">
   <div class="logo">
      <a href="<?= base_url('admin/dashboard'); ?>"
         class="simple-text logo-normal"
         style="display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 10px 5px;">

         <!-- LOGO SIPATIK -->
         <img src="<?= base_url('assets/img/logo-sipatik.png'); ?>"
              alt="Logo SIPATIK"
              style="width: 100px;
                     height: 100px;
                     object-fit: contain;
                     margin-bottom: 8px;">

         <!-- NAMA APLIKASI -->
         <b style="font-size: 18px; letter-spacing: 1px;">
            SIPATIK
         </b>

         <small style="font-size: 9px; line-height: 1.5;">
            KEPOLISIAN DAERAH JAWA TIMUR
         </small>

      </a>
   </div>
   <div class="sidebar-wrapper">
      <ul class="nav">

<?php if ($showSectionHeaders): ?>

         <!--Wali Kelas section-->
         <li class="nav-item"><p class="nav-link py-1">Wali Kelas</p></li>
         <?php foreach ($menuItems as $item): ?>
            <?php $isActive = ($context === $item['context'] || url_is($item['url'] . '*')); ?>
            <li class="nav-item <?= $isActive ? 'active' : ''; ?>">
               <a class="nav-link font-weight-bold" href="<?= base_url($item['url']); ?>">
                  <i class="material-icons"><?= $item['icon']; ?></i>
                  <p><?= $item['title']; ?></p>
               </a>
            </li>
         <?php endforeach; ?>

         <!--Admin section-->
         <li class="nav-item"><p class="nav-link py-1">Admin</p></li>
         <?php foreach ($adminItems as $item): ?>
            <?php $isActive = ($context === $item['context'] || url_is($item['url'] . '*')); ?>
            <li class="nav-item <?= $isActive ? 'active' : ''; ?>">
               <a class="nav-link font-weight-bold" href="<?= base_url($item['url']); ?>">
                  <i class="material-icons"><?= $item['icon']; ?></i>
                  <p><?= $item['title']; ?></p>
               </a>
            </li>
         <?php endforeach; ?>

<?php else: ?>
         <!--Single section (no grouping needed)-->
         <?php foreach (array_merge($menuItems, $adminItems) as $item): ?>
            <?php $isActive = ($context === $item['context'] || url_is($item['url'] . '*')); ?>
            <li class="nav-item <?= $isActive ? 'active' : ''; ?>">
               <a class="nav-link font-weight-bold" href="<?= base_url($item['url']); ?>">
                  <i class="material-icons"><?= $item['icon']; ?></i>
                  <p><?= $item['title']; ?></p>
               </a>
            </li>
         <?php endforeach; ?>
<?php endif; ?>

         <!-- Fallback: scanner-only -->
         <?php if (empty($menuItems) && empty($adminItems) && $user && $user->inGroup('scanner')): ?>
            <li class="nav-item <?= ($context === 'scan' || url_is('scan*')) ? 'active' : ''; ?>">
               <a class="nav-link font-weight-bold" href="<?= base_url('scan'); ?>">
                  <i class="material-icons">qr_code</i>
                  <p>Scan QR</p>
               </a>
            </li>
         <?php endif; ?>
      </ul>
   </div>
</div>