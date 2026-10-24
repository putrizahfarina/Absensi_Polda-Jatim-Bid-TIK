<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- CDN SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Styling Sesuai Theme Dashboard SIPATIK */
    .absensi-wrapper {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Hero Banner Header Maroon Gradasi */
    .absensi-wrapper .hero-header {
        background: linear-gradient(135deg, #7a0c1e 0%, #3b050d 60%, #1a0205 100%);
        border-radius: 20px;
        padding: 24px 28px;
        margin-top: 15px; /* Jarak aman biar gak nabrak header atas */
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .absensi-wrapper .hero-header::after {
        content: '';
        position: absolute;
        right: -40px;
        bottom: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        pointer-events: none;
    }

    .absensi-wrapper .hero-subtitle-tag {
        color: #f59e0b;
        font-weight: 800;
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .absensi-wrapper .hero-title {
        color: #ffffff;
        font-weight: 800;
        font-size: 1.8rem;
        letter-spacing: -0.5px;
        margin-top: 4px;
        margin-bottom: 6px;
    }

    .absensi-wrapper .hero-date-badge {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #e2e8f0;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        backdrop-filter: blur(4px);
        margin-right: 15px !important;
    }

    /* Tombol Simpan Gradient Maroon-Merah */
    .absensi-wrapper .btn-simpan-sipatik {
        background: linear-gradient(135deg, #9f1239 0%, #be123c 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px 20px;
        box-shadow: 0 4px 15px rgba(190, 18, 60, 0.4);
        transition: all 0.2s ease;
        margin-right: 8px !important;
    }

    .absensi-wrapper .btn-simpan-sipatik:hover {
        background: linear-gradient(135deg, #be123c 0%, #e11d48 100%);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* Container Card Putih Rounded */
    .absensi-wrapper .card-custom {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .absensi-wrapper .section-label {
        color: #d97706;
        font-size: .8rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 14px;
        text-transform: uppercase;
    }

    /* Avatar Circle */
    .absensi-wrapper .avatar-circle {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid #e2e8f0;
    }

    /* Tombol Status Pengecualian */
    .absensi-wrapper .btn-status {
        flex: 1 1 0%;
        min-width: 85px;
        padding: 10px 12px;
        text-align: center;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s ease;
    }

    .absensi-wrapper .btn-status:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .absensi-wrapper .btn-status.active {
        background: linear-gradient(135deg, #d20000 0%, #840000 100%) !important;
        color: #ffffff !important;
        border-color: #c2410c !important;
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
    }

    .absensi-wrapper .btn-status.active strong,
    .absensi-wrapper .btn-status.active small {
        color: #ffffff !important;
    }

    /* Dropdown Trigger Box */
    .absensi-wrapper .search-box-trigger {
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 14px 18px;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: border-color 0.2s;
    }

    .absensi-wrapper .search-box-trigger:hover {
        border-color: #7b0505;
    }

    .absensi-wrapper .dropdown-floating-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        margin-top: 8px;
        overflow: hidden;
    }

    .absensi-wrapper .inner-search-wrapper {
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
    }

    .absensi-wrapper .inner-search-input {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
        width: 100%;
        padding-left: 8px;
    }

    .absensi-wrapper .personel-item {
        padding: 12px 18px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background 0.15s;
    }

    .absensi-wrapper .personel-item:hover {
        background: #f8fafc;
    }

    /* Kartu Personel */
    .absensi-wrapper .chip-personel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.01);
    }

    /* CSS MERAH + CORET SAAT DITANDAI HAPUS */
    .absensi-wrapper .chip-personel.marked-delete {
        background-color: #fff1f2 !important;
        border-color: #fecdd3 !important;
    }

    .absensi-wrapper .nama-personel {
        color: #0f172a;
        font-size: 1.05rem;
        transition: all 0.2s;
    }

    .absensi-wrapper .detail-personel {
        color: #64748b;
        font-size: .85rem;
        transition: all .2s;
    }

    .absensi-wrapper .chip-personel.marked-delete .nama-personel,
    .absensi-wrapper .chip-personel.marked-delete .detail-personel {
        text-decoration: line-through !important;
        opacity: 0.45 !important;
    }

    .absensi-wrapper .chip-personel.marked-delete .nama-personel {
        color: #e11d48 !important;
    }

    /* Tombol Toggle Hapus & Undo */
    .absensi-wrapper .btn-toggle-hapus {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border-radius: 50%;
        background: transparent;
        color: #94a3b8;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        user-select: none;
    }

    .absensi-wrapper .btn-toggle-hapus:hover {
        background: #fee2e2;
        color: #e11d48;
    }

    .absensi-wrapper .btn-toggle-hapus.undo {
        background: #ffe4e6 !important;
        color: #e11d48 !important;
        font-size: 14px !important;
    }

    .absensi-wrapper .btn-toggle-hapus.undo:hover {
        background: #fecdd3 !important;
    }

    /* Input Keterangan */
    .absensi-wrapper .input-keterangan {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: .9rem;
        background: #f8fafc;
        transition: border-color 0.2s;
    }

    .absensi-wrapper .input-keterangan:focus {
        border-color: #9f1239;
        background: #ffffff;
    }

    .absensi-wrapper .chip-personel.marked-delete .input-keterangan {
        background: #fff1f2 !important;
        border-color: #fecdd3 !important;
        text-decoration: line-through !important;
        opacity: .55 !important;
    }

    /* Summary Widgets Persis Seperti Dashboard */
    .absensi-wrapper .widget-sipatik {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px;
        position: relative;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #f1f5f9;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .absensi-wrapper .widget-sipatik .icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1rem;
    }

    .absensi-wrapper .widget-sipatik .badge-pill-tag {
        background: #f1f5f9;
        color: #64748b;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Label Dikecilkan */
    .absensi-wrapper .widget-sipatik .widget-label {
        font-size: 0.65rem;            
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 6px;               
    }

    /* Angka Jumlah Dikecilkan */
    .absensi-wrapper .widget-sipatik .widget-value {
        font-size: 1.25rem;            
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-top: 2px;
    }

    /* Badges Status */
    .badge-status {
        font-size: .85rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        gap: 6px;
        align-items: center;
    }

    .badge-hadir { background: #dcfce7; color: #15803d; }
    .badge-sakit { background: #ffedd5; color: #c2410c; }
    .badge-primary { background: #e0f2fe; color: #0369a1; }
    .badge-izin { background: #fef9c3; color: #a16207; }
    .badge-alfa { background: #fee2e2; color: #b91c1c; }
    .badge-other { background: #f1f5f9; color: #475569; }

    .num-zebra-odd {
        background: #1e0508;
        color: white;
        border-radius: 6px;
        padding: 4px 10px;
        font-weight: bold;
    }

    .num-zebra-even {
        background: #f1f5f9;
        color: #475569;
        border-radius: 6px;
        padding: 4px 10px;
        font-weight: bold;
    }

    /* Input Controls */
    .absensi-wrapper .form-control,
    .absensi-wrapper .form-select {
        border-color: #e2e8f0;
        border-radius: 10px;
    }

    @media(max-width:768px) {
        .absensi-wrapper .btn-status {
            min-width: 75px;
            padding: 8px 10px;
        }

        #tableSearch, #tableFilterStatus {
            width: 100% !important;
        }
    }

    /* Card Container Tabel */
    .card-custom {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
    }

    /* Tabel Utama */
    .table-sipatik {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Header Tabel */
    .table-sipatik thead th {
        background: #e2e8f0;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
    }

    /* Zebra Striping (Ganti Warna Cerah & Gelap per Baris) */
    .table-sipatik tbody tr:nth-child(odd) {
        background-color: #ffffff; 
    }

    .table-sipatik tbody tr:nth-child(even) {
        background-color: #e2e8f0; 
    }

    /* Hover Effect per Baris */
    .table-sipatik tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-sipatik tbody tr:hover {
        background-color: #f1f5f9 !important; 
    }

    .table-sipatik tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    
   /* Nomor Urut Mengikuti Warna Zebra Baris */
.no-badge {
    width: 26px;
    height: 26px;
    background: transparent;
    color: #475569;
    border: 1px solid #cbd5e1;
    font-weight: 700;
    font-size: 0.75rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

    .avatar-initial {
        width: 30px;
        height: 30px;
        background: #e2e8f0;
        color: #475569;
        font-weight: 700;
        font-size: 0.75rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .tag-subbid, .tag-ur {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
    }

    .badge-status-pill {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Header Tabel Modern */
    .table-header-wrapper {
        padding-bottom: 16px;
        margin-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.2px;
    }

    /* Custom Search Box Modern */
    .search-box-wrapper {
        position: relative;
        width: 240px;
    }

    .search-box-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
        pointer-events: none;
        transition: color 0.2s;
    }

    .search-box-wrapper input {
        padding-left: 38px !important;
        padding-right: 12px;
        height: 38px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.85rem;
        color: #334155;
        transition: all 0.2s ease;
    }

    .search-box-wrapper input:focus {
        background-color: #ffffff;
        border-color: #7a0c1e;
        box-shadow: 0 0 0 3px rgba(122, 12, 30, 0.1);
    }

    .search-box-wrapper input:focus + i {
        color: #7a0c1e;
    }

    /* Filter Select Modern */
    .select-filter-custom {
        height: 38px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        padding-left: 12px;
        padding-right: 30px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .select-filter-custom:focus {
        background-color: #ffffff;
        border-color: #7a0c1e;
        box-shadow: 0 0 0 3px rgba(122, 12, 30, 0.1);
    }
</style>

<div class="container-fluid pt-3 mt-2 px-2 absensi-wrapper">
    <!-- Hero Header Banner dengan jarak aman -->
    <div class="hero-header d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
        <div>
            <span class="hero-subtitle-tag"><i class="fas fa-circle me-1" style="font-size:8px"></i> SISTEM INFORMASI BIDANG TIK</span>
            <h3 class="hero-title">Absensi Personel Bid TIK</h3>
            <div class="hero-date-badge mt-1">
                <i class="far fa-calendar-alt me-2 text-warning"></i>
                <?= esc($tanggal) ?>
            </div>
        </div>

        <button id="btnSimpan" type="button" class="btn btn-simpan-sipatik">
            <i class="fas fa-save me-2"></i> Simpan Absensi
        </button>
    </div>

    <!-- Card Input Absensi -->
    <div class="card-custom p-4 mb-4">
        <h5 class="fw-bold mb-3" style="color:#9f1239">
            <i class="fas fa-clipboard-check me-2"></i> Input Absensi Pengecualian
        </h5>

        <div class="alert mb-4"
            style="background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;border-radius:12px;font-size:0.9rem">
            <i class="fas fa-info-circle me-2"></i>
            Semua personel otomatis tercatat <strong>Hadir (H)</strong>.
            Tandai hanya personel yang tidak hadir atau memiliki status pengecualian.
        </div>

        <label class="form-label text-uppercase text-muted fw-bold mb-2"
            style="font-size:.75rem; letter-spacing:0.5px">PILIH STATUS PENGECUALIAN</label>

        <div class="d-flex flex-wrap gap-2 mb-4" id="statusContainer">
            <button type="button" class="btn btn-status active" data-status="Sakit"><strong>S</strong><br><small style="font-size: 0.68rem; font-weight: 700;">SAKIT</small></button>
            <button type="button" class="btn btn-status" data-status="Dinas Luar"><strong>DL</strong><br><small style="font-size: 0.68rem; font-weight: 700;">DINAS LUAR</small></button>
            <button type="button" class="btn btn-status" data-status="Izin"><strong>I</strong><br><small style="font-size: 0.68rem; font-weight: 700;">IZIN</small></button>
            <button type="button" class="btn btn-status" data-status="Alfa"><strong>A</strong><br><small style="font-size: 0.68rem; font-weight: 700;">ALFA</small></button>
            <button type="button" class="btn btn-status" data-status="Lepas Dinas"><strong>LD</strong><br><small style="font-size: 0.68rem; font-weight: 700;">LEPAS DINAS</small></button>
            <button type="button" class="btn btn-status" data-status="Cuti"><strong>C</strong><br><small style="font-size: 0.68rem; font-weight: 700;">CUTI</small></button>
            <button type="button" class="btn btn-status" data-status="Terlambat"><strong>TL</strong><br><small style="font-size: 0.68rem; font-weight: 700;">TERLAMBAT</small></button>
            <button type="button" class="btn btn-status" data-status="Pendidikan"><strong>DIK</strong><br><small style="font-size: 0.68rem; font-weight: 700;">PENDIDIKAN</small></button>
            <button type="button" class="btn btn-status" data-status="BKO"><strong>BKO</strong><br><small style="font-size: 0.68rem; font-weight: 700;">BKO</small></button>
        </div>

        <label class="form-label text-uppercase text-muted fw-bold mb-2"
            id="lblCariPersonel" style="font-size:.75rem; letter-spacing:0.5px">
            CARI NAMA PERSONEL UNTUK DITANDAI (SAKIT)
        </label>

        <div class="position-relative mb-2">
            <div id="dropdownTrigger" class="search-box-trigger">
                <span id="triggerText" class="text-muted" style="font-size:0.95rem;">Cari nama / NRP / divisi...</span>
                <i id="triggerIcon" class="fas fa-chevron-down text-muted"></i>
            </div>

            <div id="customDropdownMenu" class="dropdown-floating-menu d-none">
                <div class="inner-search-wrapper">
                    <i class="fas fa-search text-muted ms-1"></i>
                    <input type="text" id="innerSearchInput"
                        class="inner-search-input"
                        placeholder="Cari nama, NRP, divisi..." autocomplete="off">
                </div>
                <div id="personnelListContainer"
                    style="max-height:280px;overflow-y:auto"></div>
            </div>
        </div>

        <div class="text-muted mb-4" id="textStats" style="font-size:.85rem"></div>
        <div id="exceptionChipsContainer"></div>
    </div>
        <div id="exceptionChipsContainer"></div>
    </div>

    <!-- TAMBAHAN: DESKRIPSI KEGIATAN -->
   <!-- Deskripsi Kegiatan -->
<div class="card-custom p-3 mb-4">
    <h5 class="fw-bold mb-2" style="color: #b5121b;">
        <i class="fas fa-clipboard-list me-2"></i>
        Deskripsi Kegiatan
    </h5>

    <textarea
        id="deskripsiKegiatan"
        name="deskripsi"
        class="form-control"
        rows="4"
        maxlength="5000"
        placeholder="Tuliskan deskripsi kegiatan hari ini..."
    ><?= esc($deskripsiKegiatan ?? '') ?></textarea>
</div>
    <!-- AKHIR TAMBAHAN DAFTAR KEGIATAN -->

    
    <!-- Ringkasan Statistik -->
<!-- Header Ringkasan Hari Ini -->
<div class="card-custom p-3 mb-3"
     style="background: #850c13 !important;
            border: 1px solid #b5121b;
            border-radius: 12px;">

    <div class="d-flex align-items-center gap-3">
        <div style="width: 42px;
                    height: 42px;
                    background: rgba(255,255,255,0.15);
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;">
            <i class="fas fa-chart-pie"
               style="color: #ffffff; font-size: 20px;"></i>
        </div>

        <div>
            <h5 class="fw-bold mb-1"
                style="color: #ffffff !important;
                       font-size: 16px;">
                RINGKASAN HARI INI
            </h5>

            <p class="mb-0"
               style="color: #fce7e7 !important; font-size: 12px;">
                Rekap jumlah personel berdasarkan status absensi
            </p>
        </div>
    </div>
</div>

<!-- Card Statistik per Status -->
<div id="summaryContainer" class="row g-3 mb-4"></div>

    <!-- Tabel Absensi Card -->
    <div class="card-custom p-4">
        <!-- Header & Filter Tabel Absensi -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 table-header-wrapper">
            <div class="d-flex align-items-center gap-2">
                <h5 class="table-title mb-0">Tabel Absensi Hari Ini</h5>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- Input Search Modern -->
                <div class="search-box-wrapper">
                    <input type="text" id="tableSearch" class="form-control" placeholder="Cari nama / NRP...">
                    <i class="fas fa-search"></i>
                </div>

                <!-- Filter Status Modern -->
                <select id="tableFilterStatus" class="form-select select-filter-custom" style="width: 160px;">
                    <option value="Semua">Semua Status</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Dinas Luar">Dinas Luar</option>
                    <option value="Izin">Izin</option>
                    <option value="Alfa">Alfa</option>
                    <option value="Lepas Dinas">Lepas Dinas</option>
                    <option value="Cuti">Cuti</option>
                    <option value="Terlambat">Terlambat</option>
                    <option value="Pendidikan">Pendidikan</option>
                    <option value="BKO">BKO</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-sipatik align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">NO</th>
                        <th>NAMA</th>
                        <th>PANGKAT</th>
                        <th>NRP</th>
                        <th>SUBBID</th>
                        <th>UR</th>
                        <th>STATUS</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody id="tableAbsenBody"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
'use strict';

const allPersonel = <?= json_encode($personel ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const existingAbsen = <?= json_encode($absenHariIni ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

let selectedStatus = 'Sakit';
let exceptions = [];

function generateUid() {
    return Date.now().toString(36) + Math.random().toString(36).slice(2);
}

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}

function initials(status) {
    const map = {
        'Sakit': 'S',
        'Dinas Luar': 'DL',
        'Izin': 'I',
        'Alfa': 'A',
        'Lepas Dinas': 'LD',
        'Cuti': 'C',
        'Terlambat': 'TL',
        'Pendidikan': 'DIK',
        'BKO': 'BKO'
    };
    return map[status] || status.charAt(0);
}

/* Memuat absensi yang sudah ada */
if (existingAbsen && typeof existingAbsen === 'object') {
    Object.keys(existingAbsen).forEach(id => {
        const item = existingAbsen[id];
        if (item && item.status && item.status.trim() !== '' && item.status !== 'Hadir') {
            const p = allPersonel.find(x => String(x.id) === String(id));
            if (p) {
                exceptions.push({
                    _uid: generateUid(),
                    personel_id: p.id,
                    nama: p.nama || '',
                    nrp: p.nrp_nip || '—',
                    pangkat: p.pangkat || '',
                    divisi: p.ur || '—',
                    status: item.status,
                    keterangan: item.keterangan || '',
                    is_deleted: false
                });
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const chipsContainer = document.getElementById('exceptionChipsContainer');
    const trigger = document.getElementById('dropdownTrigger');
    const menu = document.getElementById('customDropdownMenu');
    const icon = document.getElementById('triggerIcon');
    const searchInput = document.getElementById('innerSearchInput');

    renderAll();

    /* Pilihan status */
    document.querySelectorAll('.btn-status').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.btn-status').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedStatus = this.dataset.status;
            document.getElementById('lblCariPersonel').textContent = 'CARI NAMA PERSONEL UNTUK DITANDAI (' + selectedStatus.toUpperCase() + ')';
        });
    });

    /* Dropdown */
    function toggleDropdown(show) {
        const shouldShow = show !== undefined ? show : menu.classList.contains('d-none');
        if (shouldShow) {
            menu.classList.remove('d-none');
            trigger.style.borderColor = '#9f1239';
            icon.className = 'fas fa-chevron-up text-danger';
            renderDropdownList(searchInput.value);
            setTimeout(() => searchInput.focus(), 50);
        } else {
            menu.classList.add('d-none');
            trigger.style.borderColor = '#cbd5e1';
            icon.className = 'fas fa-chevron-down text-muted';
        }
    }

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleDropdown();
    });

    menu.addEventListener('click', e => e.stopPropagation());
    document.addEventListener('click', () => toggleDropdown(false));

    searchInput.addEventListener('input', function () {
        renderDropdownList(this.value);
    });

    document.getElementById('tableSearch').addEventListener('input', renderTable);
    document.getElementById('tableFilterStatus').addEventListener('change', renderTable);

    /* KLIK TANDAI HAPUS (EVENT DELEGATION PADA CONTAINER CHIPS) */
    chipsContainer.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-toggle-hapus');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const uid = btn.getAttribute('data-uid');
        const item = exceptions.find(ex => String(ex._uid) === String(uid));

        if (item) {
            item.is_deleted = !item.is_deleted;
            renderAll();
        }
    });

    /* Input keterangan */
    chipsContainer.addEventListener('input', function (e) {
        if (!e.target.classList.contains('input-keterangan')) return;
        const uid = e.target.getAttribute('data-uid');
        const item = exceptions.find(ex => String(ex._uid) === String(uid));
        if (item && !item.is_deleted) {
            item.keterangan = e.target.value;
        }
    });

    /* Simpan absensi dengan SweetAlert2 */
    document.getElementById('btnSimpan').addEventListener('click', async function () {
        const button = this;
        if (button.disabled) return;

        const deletedCount = exceptions.filter(e => e.is_deleted).length;
        if (deletedCount > 0) {
            const confirmResult = await Swal.fire({
                title: 'Konfirmasi Simpan',
                text: `${deletedCount} personel ditandai hapus. Lanjutkan menyimpan absensi?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7a0c1e',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            });

            if (!confirmResult.isConfirmed) return;
        }

        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

        const dataToSave = exceptions.filter(e => !e.is_deleted);

        try {
            const response = await fetch('<?= base_url('admin/absensi/simpan') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({
    exceptions: dataToSave,
    deskripsi: document.getElementById('deskripsiKegiatan').value.trim()
})
            });

            if (!response.ok) throw new Error('HTTP ' + response.status);
            const data = await response.json();
            if (data.success === false) throw new Error(data.message || 'Gagal menyimpan absensi');

            await Swal.fire({
                title: 'Berhasil!',
                text: data.message || 'Absensi seluruh personel berhasil disinkronkan!',
                icon: 'success',
                confirmButtonColor: '#7a0c1e',
                confirmButtonText: 'Selesai'
            });

            location.reload();
        } catch (error) {
            console.error(error);

            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal menyimpan absensi. Periksa controller dan koneksi.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Coba Lagi'
            });

            button.disabled = false;
            button.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Absensi';
        }
    });
});

/* Daftar personel dropdown */
function renderDropdownList(query = '') {
    const container = document.getElementById('personnelListContainer');
    if (!container) return;

    query = String(query).toLowerCase().trim();

    const activeIds = exceptions
        .filter(e => !e.is_deleted)
        .map(e => String(e.personel_id));

    const matches = allPersonel.filter(p => {
        if (activeIds.includes(String(p.id))) return false;
        const text = [p.nama, p.nrp_nip, p.ur, p.pangkat, p.subbid].join(' ').toLowerCase();
        return text.includes(query);
    });

    container.innerHTML = '';

    if (!matches.length) {
        container.innerHTML = '<div class="p-4 text-center text-muted small">Tidak ada personel ditemukan.</div>';
        return;
    }

    matches.forEach(p => {
        const item = document.createElement('div');
        item.className = 'personel-item';

        let displayName = p.nama || '';
        if (p.pangkat && !displayName.toLowerCase().startsWith(p.pangkat.toLowerCase())) {
            displayName = p.pangkat + ' ' + displayName;
        }

        item.innerHTML = `
            <div class="avatar-circle" style="width:38px;height:38px">
                ${escapeHtml((p.nama || '?').charAt(0).toUpperCase())}
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <div class="fw-bold text-dark text-truncate">${escapeHtml(displayName)}</div>
                <div class="text-muted small text-truncate">
                    ${escapeHtml([p.nrp_nip, p.pangkat, p.ur].filter(Boolean).join(' · '))}
                </div>
            </div>
        `;

        item.addEventListener('click', function () {
            if (exceptions.some(e => String(e.personel_id) === String(p.id) && !e.is_deleted)) {
                return;
            }

            exceptions.push({
                _uid: generateUid(),
                personel_id: p.id,
                nama: p.nama || '',
                nrp: p.nrp_nip || '—',
                pangkat: p.pangkat || '',
                divisi: p.ur || '—',
                status: selectedStatus,
                keterangan: '',
                is_deleted: false
            });

            document.getElementById('customDropdownMenu').classList.add('d-none');
            document.getElementById('dropdownTrigger').style.borderColor = '#cbd5e1';
            document.getElementById('triggerIcon').className = 'fas fa-chevron-down text-muted';

            renderAll();
        });

        container.appendChild(item);
    });
}

function updateStatsText() {
    const activeCount = exceptions.filter(e => !e.is_deleted).length;
    const deletedCount = exceptions.filter(e => e.is_deleted).length;
    const availableCount = Math.max(0, allPersonel.length - activeCount);

    document.getElementById('textStats').innerHTML =
        `${availableCount} personel tersedia · <strong class="text-danger">${deletedCount} ditandai hapus</strong>`;
}

function renderAll() {
    renderChips();
    renderSummary();
    renderTable();
    updateStatsText();

    const input = document.getElementById('innerSearchInput');
    if (input) renderDropdownList(input.value);
}

/* Render kartu status */
function renderChips() {
    const container = document.getElementById('exceptionChipsContainer');
    container.innerHTML = '';

    if (!exceptions.length) {
        container.innerHTML = '<div class="text-muted small">Belum ada personel yang ditandai.</div>';
        return;
    }

    const grouped = {};
    exceptions.forEach(item => {
        if (!grouped[item.status]) grouped[item.status] = [];
        grouped[item.status].push(item);
    });

    Object.keys(grouped).forEach(status => {
        const group = document.createElement('div');
        group.className = 'mb-4';

        group.innerHTML = `
            <div class="fw-bold mb-3 d-flex align-items-center" style="color:#475569;font-size:13px">
                <span style="width:8px;height:8px;border-radius:50%; background:#f97316;display:inline-block;margin-right:8px"></span>
                ${escapeHtml(status)} (${initials(status)})
                <span style="background:#e2e8f0;color:#334155;padding:2px 8px; border-radius:12px;font-size:11px;margin-left:8px">
                    ${grouped[status].length}
                </span>
            </div>
        `;

        grouped[status].forEach(item => {
            const marked = item.is_deleted === true;
            const card = document.createElement('div');

            card.className = 'chip-personel' + (marked ? ' marked-delete' : '');

            let displayName = item.nama || '';
            if (item.pangkat && !displayName.toLowerCase().startsWith(item.pangkat.toLowerCase())) {
                displayName = item.pangkat + ' ' + displayName;
            }

            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center" style="gap:14px;min-width:0">
                        <div class="avatar-circle" style="${marked ? 'opacity:.5' : ''}">
                            ${escapeHtml((item.nama || '?').charAt(0).toUpperCase())}
                        </div>
                        <div style="line-height:1.4;min-width:0">
                            <div class="fw-bold nama-personel">
                                ${escapeHtml(displayName)}
                            </div>
                            <div class="detail-personel">
                                ${escapeHtml(item.nrp)}
                                <span style="margin:0 4px">·</span>
                                ${escapeHtml(item.divisi)}
                            </div>
                        </div>
                    </div>

                    <span class="btn-toggle-hapus ${marked ? 'undo' : ''}"
                        data-uid="${escapeHtml(item._uid)}"
                        title="${marked ? 'Batal tandai hapus' : 'Tandai hapus'}"
                        aria-label="${marked ? 'Batal tandai hapus' : 'Tandai hapus'}">
                        ${marked ? '<i class="fas fa-undo"></i>' : '&times;'}
                    </span>
                </div>

                <input type="text" class="form-control input-keterangan"
                    data-uid="${escapeHtml(item._uid)}"
                    placeholder="Keterangan ${escapeHtml(status.toLowerCase())}..."
                    value="${escapeHtml(item.keterangan || '')}"
                    ${marked ? 'disabled' : ''}>
            `;

            group.appendChild(card);
        });

        container.appendChild(group);
    });
}

/* Render Ringkasan Widget Bergaya Dashboard Utama */
function renderSummary() {
    const container = document.getElementById('summaryContainer');

    const counts = {
        'Hadir': 0, 'Izin': 0, 'Sakit': 0, 'Dinas Luar': 0, 'Alfa': 0,
        'Lepas Dinas': 0, 'Cuti': 0, 'Terlambat': 0, 'Pendidikan': 0, 'BKO': 0
    };

    const active = exceptions.filter(e => !e.is_deleted);
    counts.Hadir = Math.max(0, allPersonel.length - active.length);

    active.forEach(e => {
        counts[e.status] = (counts[e.status] || 0) + 1;
    });

    const items = [
        ['Hadir', 'HADIR (H)', '#10b981'],
        ['Izin', 'IZIN (I)', '#eab308'],
        ['Sakit', 'SAKIT (S)', '#f97316'],
        ['Dinas Luar', 'DINAS LUAR (DL)', '#0ea5e9'],
        ['Alfa', 'ALFA (A)', '#ef4444'],
        ['Lepas Dinas', 'LEPAS DINAS (LD)', '#8b5cf6'],
        ['Cuti', 'CUTI (C)', '#ec4899'],
        ['Terlambat', 'TERLAMBAT (TL)', '#64748b'],
        ['Pendidikan', 'PENDIDIKAN (DIK)', '#14b8a6'],
        ['BKO', 'BKO', '#3b82f6']
    ];

    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; width: 100%;">
            ${items.map(([key, label, color]) => `
                <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 8px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 80px;">
                    <div style="font-weight: 800; font-size: 20px; color: ${color}; margin-bottom: 4px; line-height: 1;">${counts[key] || 0}</div>
                    <div style="font-size: 10.5px; color: #64748b; font-weight: 700; letter-spacing: 0.2px; line-height: 1.2;">${label}</div>
                </div>
            `).join('')}
        </div>
    `;
}

function renderTable() {
    const tbody = document.getElementById('tableAbsenBody');
    tbody.innerHTML = '';

    const query = document.getElementById('tableSearch').value.toLowerCase().trim();
    const filter = document.getElementById('tableFilterStatus').value;

    const activeMap = {};

    exceptions.forEach(e => {
        if (!e.is_deleted) activeMap[String(e.personel_id)] = e;
    });

    let number = 1;

    allPersonel.forEach(p => {
        const exception = activeMap[String(p.id)];
        const status = exception ? exception.status : 'Hadir';
        const keterangan = exception ? (exception.keterangan || '—') : '—';

        if (filter !== 'Semua' && status !== filter) return;

        const nama = String(p.nama || '');
        const nrp = String(p.nrp_nip || '');

        if (query && !nama.toLowerCase().includes(query) &&
            !nrp.toLowerCase().includes(query)) return;

        let badge = 'badge-hadir';

        if (status === 'Sakit') badge = 'badge-sakit';
        else if (status === 'Dinas Luar') badge = 'badge-primary';
        else if (status === 'Izin') badge = 'badge-izin';
        else if (status === 'Alfa') badge = 'badge-alfa';
        else if (status !== 'Hadir') badge = 'badge-other';

        const tr = document.createElement('tr');

        
tr.innerHTML = `
    <td><span class="no-badge">${number}</span></td>

    <td>
        <span class="fw-bold text-dark">${escapeHtml(nama)}</span>
    </td>

    <td class="text-muted small">${escapeHtml(p.pangkat || '—')}</td>
    <td class="fw-bold" style="color:#64748b">${escapeHtml(nrp || '—')}</td>
    <td><span class="badge bg-light text-secondary border" style="border-radius: 6px; font-weight: 500;">${escapeHtml(p.subbid || '—')}</span></td>
    <td><span class="badge bg-light text-secondary border" style="border-radius: 6px; font-weight: 500;">${escapeHtml(p.ur || '—')}</span></td>
    <td><span class="badge-status ${badge}">● ${escapeHtml(status)}</span></td>
    <td class="text-muted small">${escapeHtml(keterangan)}</td>
`;

        tbody.appendChild(tr);
        number++;
    });
}
</script>

<?= $this->endSection() ?>