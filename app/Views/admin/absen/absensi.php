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
        margin-top: 15px;
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
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        backdrop-filter: blur(4px);
        margin-right: 15px !important;
    }

    /* Tombol Simpan */
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

    /* Typography Hierarki (Hitam & Tebal) */
    .absensi-wrapper .card-title-custom {
        color: #000000;
        font-weight: 800;
        letter-spacing: -0.2px;
    }

    .absensi-wrapper .section-label {
        color: #000000;
        font-size: .8rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 14px;
        text-transform: uppercase;
    }

    /* Tombol Status Pengecualian */
    .absensi-wrapper .btn-status {
        flex: 1 1 0%;
        min-width: 85px;
        padding: 10px 12px;
        text-align: center;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        background: #ffffff;
        color: #000000;
        transition: all 0.2s ease;
    }

    .absensi-wrapper .btn-status strong {
        font-weight: 800;
        font-size: 1.1rem;
    }

    .absensi-wrapper .btn-status small {
        font-weight: 700;
        color: #475569;
    }

    .absensi-wrapper .btn-status:hover {
        background: #f8fafc;
        border-color: #94a3b8;
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
        border: 1px solid #94a3b8;
        border-radius: 12px;
        padding: 12px 16px;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: border-color 0.2s;
        color: #000000;
        font-weight: 500;
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
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        margin-top: 8px;
        overflow: hidden;
    }

    .absensi-wrapper .inner-search-wrapper {
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
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
        color: #000000;
        font-weight: 500;
    }

    .absensi-wrapper .personel-item {
        padding: 10px 16px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background 0.15s;
    }

    .absensi-wrapper .personel-item:hover {
        background: #f1f5f9;
    }

    /* GRID UNTUK DUA KOLOM KARTU PENGECUALIAN */
    .absensi-wrapper .cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    /* Kartu Personel */
    .absensi-wrapper .chip-personel {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 14px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .absensi-wrapper .chip-personel.marked-delete {
        background-color: #fff1f2 !important;
        border-color: #fecdd3 !important;
    }

    .absensi-wrapper .avatar-circle {
        width: 34px;
        height: 34px;
        font-size: 0.85rem;
        flex-shrink: 0;
        border-radius: 50%;
        background: #f1f5f9;
        color: #000000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        text-transform: uppercase;
        border: 1px solid #cbd5e1;
    }

    .absensi-wrapper .nama-personel {
        color: #000000;
        font-weight: 600;
        font-size: 0.9rem;
        line-height: 1.2;
        margin-bottom: 2px;
        transition: all 0.2s;
    }

    .absensi-wrapper .detail-personel {
        color: #475569;
        font-weight: 500;
        font-size: 0.75rem;
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
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        border-radius: 50%;
        background: transparent;
        color: #64748b;
        font-size: 16px;
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
        font-size: 12px !important;
    }

    .absensi-wrapper .btn-toggle-hapus.undo:hover {
        background: #fecdd3 !important;
    }

    /* Input Keterangan */
    .absensi-wrapper .input-keterangan {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 6px 12px;
        font-size: 0.8rem;
        height: 32px;
        font-weight: 500;
        color: #000000;
        background: #f8fafc;
        transition: border-color 0.2s;
    }

    .absensi-wrapper .input-keterangan:focus {
        border-color: #000000;
        background: #ffffff;
        box-shadow: none;
    }

    .absensi-wrapper .chip-personel.marked-delete .input-keterangan {
        background: #fff1f2 !important;
        border-color: #fecdd3 !important;
        text-decoration: line-through !important;
        opacity: .55 !important;
    }

    /* Textarea Deskripsi Kegiatan */
    .absensi-wrapper #deskripsiKegiatan {
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        color: #000000;
        font-weight: 500;
    }
    .absensi-wrapper #deskripsiKegiatan:focus {
        border-color: #000000;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
    }

    /* Badges Status di Tabel */
    .badge-status {
        font-size: .85rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-flex;
        gap: 6px;
        align-items: center;
    }

    .badge-hadir { background: #dcfce7; color: #15803d; }
    .badge-sakit { background: #ffedd5; color: #c2410c; }
    .badge-primary { background: #e0f2fe; color: #0369a1; }
    .badge-izin { background: #fef9c3; color: #a16207; }
    .badge-other { background: #f1f5f9; color: #000000; }

    /* Input Controls */
    .absensi-wrapper .form-control,
    .absensi-wrapper .form-select {
        border-color: #cbd5e1;
        border-radius: 10px;
        color: #000000;
        font-weight: 500;
    }

    @media(max-width:768px) {
        .absensi-wrapper .btn-status {
            min-width: 75px;
            padding: 8px 10px;
        }
        #tableSearch, #tableFilterStatus {
            width: 100% !important;
        }
        .absensi-wrapper .cards-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Tabel Utama */
    .table-sipatik {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-sipatik thead th {
        background: #f1f5f9;
        color: #000000;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        padding: 14px 16px;
        border-bottom: 2px solid #cbd5e1;
        text-transform: uppercase;
    }

    .table-sipatik tbody tr:nth-child(odd) {
        background-color: #ffffff; 
    }

    .table-sipatik tbody tr:nth-child(even) {
        background-color: #f8fafc; 
    }

    .table-sipatik tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-sipatik tbody tr:hover {
        background-color: #f1f5f9 !important; 
    }

    .table-sipatik tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 0.9rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .no-badge {
        width: 28px;
        height: 28px;
        background: #ffffff;
        color: #000000;
        border: 1px solid #94a3b8;
        font-weight: 800;
        font-size: 0.8rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .table-header-wrapper {
        padding-bottom: 16px;
        margin-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #000000;
        letter-spacing: -0.2px;
    }

    .search-box-wrapper {
        position: relative;
        width: 240px;
    }

    .search-box-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 0.85rem;
        pointer-events: none;
        transition: color 0.2s;
    }

    .search-box-wrapper input {
        padding-left: 38px !important;
        padding-right: 12px;
        height: 40px;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #000000;
        transition: all 0.2s ease;
    }

    .search-box-wrapper input:focus {
        border-color: #000000;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
    }

    .search-box-wrapper input:focus + i {
        color: #000000;
    }

    .select-filter-custom {
        height: 40px;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #000000;
        padding-left: 12px;
        padding-right: 30px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .select-filter-custom:focus {
        border-color: #000000;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
    }
    
    /* Tombol Paginasi Tambahan */
    .page-btn-custom {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s;
    }
    .page-btn-custom:hover:not(.disabled) {
        background: #f1f5f9;
        color: #0f172a;
    }
    .page-btn-custom.active {
        background: #000000;
        color: #ffffff;
        border-color: #000000;
    }
    .page-btn-custom.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<div class="container-fluid pt-3 mt-2 px-2 absensi-wrapper">
    <!-- Hero Header Banner -->
    <div class="hero-header d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
        <div>
            <span class="hero-subtitle-tag"><i class="fas fa-circle me-1" style="font-size:8px"></i> SISTEM INFORMASI BIDANG TIK</span>
            <h3 class="hero-title">Absensi Personel BID TIK</h3>
            <div class="hero-date-badge mt-1">
                <i class="far fa-calendar-alt" style="margin-right: 8px;"></i> <?= $tanggal ?>
                
            </div>
        </div>

        <button id="btnSimpan" type="button" class="btn btn-simpan-sipatik">
            <i class="fas fa-save me-2"></i> Simpan Absensi
        </button>
    </div>

    <!-- Card Input Absensi -->
    <div class="card-custom p-4 mb-4">
        <h5 class="card-title-custom mb-3">
            <i class="fas fa-clipboard-check me-2 text-danger"></i> Input Absensi Pengecualian
        </h5>

        <div class="alert mb-4"
            style="background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;border-radius:12px;font-size:0.9rem;font-weight:500;">
            <i class="fas fa-info-circle me-2"></i>
            Semua personel otomatis tercatat <strong style="color:#0c4a6e;font-weight:800;">Hadir (H)</strong>.
            Tandai hanya personel yang tidak hadir atau memiliki status pengecualian.
        </div>

        <label class="form-label text-uppercase mb-2 section-label">PILIH STATUS PENGECUALIAN</label>

        <div class="d-flex flex-wrap gap-2 mb-4" id="statusContainer">
            <button type="button" class="btn btn-status active" data-status="Sakit"><strong>S</strong><br><small>SAKIT</small></button>
            <button type="button" class="btn btn-status" data-status="Dinas Luar"><strong>DL</strong><br><small>DINAS LUAR</small></button>
            <button type="button" class="btn btn-status" data-status="Izin"><strong>I</strong><br><small>IZIN</small></button>
            <button type="button" class="btn btn-status" data-status="Lepas Dinas"><strong>LD</strong><br><small>LEPAS DINAS</small></button>
            <button type="button" class="btn btn-status" data-status="Cuti"><strong>C</strong><br><small>CUTI</small></button>
            <button type="button" class="btn btn-status" data-status="Terlambat"><strong>TL</strong><br><small>TERLAMBAT</small></button>
            <button type="button" class="btn btn-status" data-status="Pendidikan"><strong>DIK</strong><br><small>PENDIDIKAN</small></button>
            <button type="button" class="btn btn-status" data-status="BKO"><strong>BKO</strong><br><small>BKO</small></button>
        </div>

        <label class="form-label text-uppercase mb-2 section-label" id="lblCariPersonel">
            CARI NAMA PERSONEL UNTUK DITANDAI (SAKIT)
        </label>

        <div class="position-relative mb-2">
            <div id="dropdownTrigger" class="search-box-trigger">
                <span id="triggerText" style="font-size:0.9rem;">Cari nama / NRP / divisi...</span>
                <i id="triggerIcon" class="fas fa-chevron-down" style="color:#64748b"></i>
            </div>

            <div id="customDropdownMenu" class="dropdown-floating-menu d-none">
                <div class="inner-search-wrapper">
                    <i class="fas fa-search ms-1" style="color:#64748b"></i>
                    <input type="text" id="innerSearchInput" class="inner-search-input" placeholder="Ketik nama atau NRP..." autocomplete="off">
                </div>
                <div id="personnelListContainer" style="max-height:280px;overflow-y:auto"></div>
            </div>
        </div>

        <div class="mb-4" id="textStats" style="font-size:.85rem;font-weight:600;color:#475569;"></div>
        <div id="exceptionChipsContainer"></div>
    </div>

    <!-- Deskripsi Kegiatan -->
    <div class="card-custom p-4 mb-4">
        <h5 class="card-title-custom mb-3">
            <i class="fas fa-clipboard-list me-2 text-danger"></i> Deskripsi Kegiatan
        </h5>

        <textarea
            id="deskripsiKegiatan"
            name="deskripsi"
            class="form-control"
            rows="4"
            maxlength="5000"
            placeholder="  Tuliskan deskripsi kegiatan hari ini..."
        ><?= esc($deskripsiKegiatan ?? '') ?></textarea>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="card-custom p-3 mb-3" style="background: #700e0e !important; border-radius: 16px;">
        <div class="d-flex align-items-center gap-3">
            <div style="width: 42px; height: 42px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-chart-pie" style="color: #ffffff; font-size: 20px;"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1" style="color: #ffffff !important; font-size: 1.1rem; letter-spacing: 0.5px;">
                    RINGKASAN HARI INI
                </h5>
                <p class="mb-0" style="color: #cbd5e1 !important; font-size: 0.85rem; font-weight: 500;">
                    Rekap jumlah personel berdasarkan status absensi
                </p>
            </div>
        </div>
    </div>

    <!-- Card Statistik per Status -->
    <div id="summaryContainer" class="row g-3 mb-4"></div>

    <!-- Tabel Absensi Card -->
    <div class="card-custom p-4 mb-4">
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
        
        <!-- Paginasi Container (Baru Ditambahkan) -->
        <div id="tablePagination" class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <div id="paginationInfo" style="font-size: 0.85rem; color: #64748b; font-weight: 600;"></div>
            <div id="paginationButtons" class="d-flex gap-1 flex-wrap"></div>
        </div>

    </div>
</div>

<script>
'use strict';

const allPersonel = <?= json_encode($personel ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const existingAbsen = <?= json_encode($absenHariIni ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const serverToday = "<?= date('Y-m-d') ?>";

let selectedStatus = 'Sakit';
let exceptions = [];

// Variabel Paginasi Client-Side
const rowsPerPage = 15;
let currentPage = 1;
let currentFilteredData = [];

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
        'Lepas Dinas': 'LD',
        'Cuti': 'C',
        'Terlambat': 'TL',
        'Pendidikan': 'DIK',
        'BKO': 'BKO'
    };
    return map[status] || status.charAt(0);
}

function formatTanggalIndo(dateStr) {
    if (!dateStr) return '';
    const parts = dateStr.split('-');
    if (parts.length !== 3) return dateStr;
    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const hari = parseInt(parts[2], 10);
    const bulanNama = bulan[parseInt(parts[1], 10) - 1] || parts[1];
    return `${hari} ${bulanNama} ${parts[0]}`;
}

/* Memuat absensi yang sudah ada (termasuk yang masuk dari rentang masa lalu) */
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
                    tanggal_mulai: item.tanggal_mulai || serverToday,
                    tanggal_selesai: item.tanggal_selesai || serverToday,
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
            trigger.style.borderColor = '#000000';
            icon.className = 'fas fa-chevron-up text-dark';
            renderDropdownList(searchInput.value);
            setTimeout(() => searchInput.focus(), 50);
        } else {
            menu.classList.add('d-none');
            trigger.style.borderColor = '#94a3b8';
            icon.className = 'fas fa-chevron-down';
            icon.style.color = '#64748b';
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

    document.getElementById('tableSearch').addEventListener('input', () => {
        currentPage = 1; 
        renderTable();
    });
    
    document.getElementById('tableFilterStatus').addEventListener('change', () => {
        currentPage = 1;
        renderTable();
    });

    /* KLIK TANDAI HAPUS */
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

    /* Input keterangan & Tanggal (Delegasi Event) */
    chipsContainer.addEventListener('input', function (e) {
        const uid = e.target.getAttribute('data-uid');
        const item = exceptions.find(ex => String(ex._uid) === String(uid));
        
        if (item && !item.is_deleted) {
            if (e.target.classList.contains('input-keterangan')) {
                item.keterangan = e.target.value;
                renderTable();
            }
        }
    });

    chipsContainer.addEventListener('change', function (e) {
        const uid = e.target.getAttribute('data-uid');
        const item = exceptions.find(ex => String(ex._uid) === String(uid));
        
        if (item && !item.is_deleted) {
            if (e.target.classList.contains('input-tgl-mulai')) {
                item.tanggal_mulai = e.target.value;
                renderTable();
            } else if (e.target.classList.contains('input-tgl-selesai')) {
                item.tanggal_selesai = e.target.value;
                renderTable();
            }
        }
    });

    /* Simpan absensi */
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
                text: data.message || 'Absensi seluruh personel berhasil disimpan!',
                icon: 'success',
                confirmButtonColor: '#000000',
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
    const activeIds = exceptions.filter(e => !e.is_deleted).map(e => String(e.personel_id));

    const matches = allPersonel.filter(p => {
        if (activeIds.includes(String(p.id))) return false;
        const text = [p.nama, p.nrp_nip, p.ur, p.pangkat, p.subbid].join(' ').toLowerCase();
        return text.includes(query);
    });

    container.innerHTML = '';

    if (!matches.length) {
        container.innerHTML = '<div class="p-4 text-center text-muted small fw-bold">Tidak ada personel ditemukan.</div>';
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
            <div class="avatar-circle">${escapeHtml((p.nama || '?').charAt(0).toUpperCase())}</div>
            <div class="flex-grow-1 overflow-hidden">
                <div style="color:#000000; font-weight:600; font-size:0.95rem;" class="text-truncate">${escapeHtml(displayName)}</div>
                <div style="color:#475569; font-weight:500; font-size:0.8rem;" class="text-truncate">
                    ${escapeHtml([p.nrp_nip, p.pangkat, p.ur].filter(Boolean).join(' · '))}
                </div>
            </div>
        `;

        item.addEventListener('click', function () {
            if (exceptions.some(e => String(e.personel_id) === String(p.id) && !e.is_deleted)) return;

            exceptions.push({
                _uid: generateUid(),
                personel_id: p.id,
                nama: p.nama || '',
                nrp: p.nrp_nip || '—',
                pangkat: p.pangkat || '',
                divisi: p.ur || '—',
                status: selectedStatus,
                keterangan: '',
                tanggal_mulai: serverToday,
                tanggal_selesai: serverToday,
                is_deleted: false
            });

            document.getElementById('customDropdownMenu').classList.add('d-none');
            document.getElementById('dropdownTrigger').style.borderColor = '#94a3b8';
            document.getElementById('triggerIcon').className = 'fas fa-chevron-down';
            document.getElementById('triggerIcon').style.color = '#64748b';

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
        `${availableCount} personel tersedia · <strong class="text-danger" style="font-weight:700;">${deletedCount} ditandai hapus</strong>`;
}

function renderAll() {
    renderChips();
    renderSummary();
    renderTable(); 
    updateStatsText();

    const input = document.getElementById('innerSearchInput');
    if (input) renderDropdownList(input.value);
}

/* Render kartu status dengan input Date */
function renderChips() {
    const container = document.getElementById('exceptionChipsContainer');
    container.innerHTML = '';

    if (!exceptions.length) {
        container.innerHTML = '<div style="color:#64748b;font-weight:600;font-size:0.85rem;">Belum ada personel yang ditandai.</div>';
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
            <div class="mb-3 d-flex align-items-center" style="color:#000000;font-size:14px;font-weight:800;letter-spacing:0.3px;text-transform:uppercase;">
                <span style="width:10px;height:10px;border-radius:50%; background:#f97316;display:inline-block;margin-right:10px"></span>
                ${escapeHtml(status)} (${initials(status)})
                <span style="background:#e2e8f0;color:#000000;padding:2px 10px; border-radius:12px;font-size:12px;margin-left:10px;font-weight:800;">
                    ${grouped[status].length}
                </span>
            </div>
            <div class="cards-grid"></div>
        `;

        const grid = group.querySelector('.cards-grid');

        grouped[status].forEach(item => {
            const marked = item.is_deleted === true;
            const card = document.createElement('div');
            card.className = 'chip-personel' + (marked ? ' marked-delete' : '');

            let displayName = item.nama || '';
            if (item.pangkat && !displayName.toLowerCase().startsWith(item.pangkat.toLowerCase())) {
                displayName = item.pangkat + ' ' + displayName;
            }


            // Generate field tanggal untuk rentang
            const isRange = ['Dinas Luar', 'Cuti', 'BKO', 'Pendidikan'].includes(item.status);
            let dateHtml = '';
            if (isRange) {
                const statusText = item.status.toUpperCase();
                const uid = escapeHtml(item._uid);
                
                // Hitung durasi hari awal saat pertama kali dimuat
                const tglMulaiRender = item.tanggal_mulai || serverToday;
                const tglSelesaiRender = item.tanggal_selesai || serverToday;
                let durasiAwal = 1;
                if(tglMulaiRender && tglSelesaiRender) {
                    const d1 = new Date(tglMulaiRender);
                    const d2 = new Date(tglSelesaiRender);
                    durasiAwal = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
                }
                
                dateHtml = `
                    <div style="background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 12px; margin-top: 12px; margin-bottom: 12px;">
                        <!-- Header / Judul -->
                        <div style="font-size: 0.75rem; font-weight: 700; color: #0369a1; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            JANGKA WAKTU ${statusText}
                        </div>
                        
                        <!-- Input Tanggal Mulai & Selesai -->
                        <div class="d-flex gap-3 mb-1">
                            <div class="flex-grow-1">
                                <label style="font-size: 0.75rem; color: #334155; display: block; margin-bottom: 4px;">Mulai</label>
                                <input type="date" class="form-control input-tgl-mulai" 
                                    id="mulai-${uid}" onchange="hitungDurasiHari('${uid}')"
                                    style="font-size: 0.85rem; padding: 6px 10px; color: #000000 !important; background-color: #ffffff !important; border: 1px solid #cbd5e1; border-radius: 6px;"
                                    data-uid="${uid}" 
                                    value="${escapeHtml(tglMulaiRender)}" ${marked ? 'disabled' : ''}>
                            </div>
                            <div class="flex-grow-1">
                                <label style="font-size: 0.75rem; color: #334155; display: block; margin-bottom: 4px;">Selesai</label>
                                <input type="date" class="form-control input-tgl-selesai" 
                                    id="selesai-${uid}" onchange="hitungDurasiHari('${uid}')"
                                    style="font-size: 0.85rem; padding: 6px 10px; color: #000000 !important; background-color: #ffffff !important; border: 1px solid #cbd5e1; border-radius: 6px;"
                                    data-uid="${uid}" 
                                    value="${escapeHtml(tglSelesaiRender)}" ${marked ? 'disabled' : ''}>
                            </div>
                        </div>
                        
                        <!-- Teks Bantuan / Keterangan Durasi -->
                        <div id="teks-durasi-${uid}" style="font-size: 0.75rem; color: #0369a1; font-weight: 600; margin-top: 10px;">
                            ${durasiAwal} hari &middot; absensi tercatat otomatis setiap hari
                        </div>
                    </div>
                `;
            }


            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center" style="gap:10px;min-width:0">
                        <div class="avatar-circle" style="${marked ? 'opacity:.5' : ''}">
                            ${escapeHtml((item.nama || '?').charAt(0).toUpperCase())}
                        </div>
                        <div style="min-width:0">
                            <div class="nama-personel text-truncate" title="${escapeHtml(displayName)}">${escapeHtml(displayName)}</div>
                            <div class="detail-personel text-truncate" title="${escapeHtml(item.nrp)} · ${escapeHtml(item.divisi)}">
                                ${escapeHtml(item.nrp)} <span style="margin:0 4px">·</span> ${escapeHtml(item.divisi)}
                            </div>
                        </div>
                    </div>

                    <span class="btn-toggle-hapus ${marked ? 'undo' : ''}"
                        data-uid="${escapeHtml(item._uid)}"
                        title="${marked ? 'Batal tandai hapus' : 'Tandai hapus'}">
                        ${marked ? '<i class="fas fa-undo"></i>' : '&times;'}
                    </span>
                </div>

                ${dateHtml}

                <div class="mt-auto pt-2">
                    <input type="text" class="form-control input-keterangan"
                        data-uid="${escapeHtml(item._uid)}"
                        placeholder="Keterangan ${escapeHtml(status.toLowerCase())}..."
                        value="${escapeHtml(item.keterangan || '')}"
                        ${marked ? 'disabled' : ''}>
                </div>
            `;
            grid.appendChild(card);
        });
        container.appendChild(group);
    });
}

function renderSummary() {
    const container = document.getElementById('summaryContainer');
    const counts = {
        'Hadir': 0, 'Izin': 0, 'Sakit': 0, 'Dinas Luar': 0, 
        'Lepas Dinas': 0, 'Cuti': 0, 'Terlambat': 0, 'Pendidikan': 0, 'BKO': 0
    };

    const active = exceptions.filter(e => !e.is_deleted);
    counts.Hadir = Math.max(0, allPersonel.length - active.length);

    active.forEach(e => { counts[e.status] = (counts[e.status] || 0) + 1; });

    const items = [
        ['Hadir', 'HADIR (H)', '#10b981'], ['Izin', 'IZIN (I)', '#eab308'],
        ['Sakit', 'SAKIT (S)', '#f97316'], ['Dinas Luar', 'DINAS LUAR (DL)', '#0ea5e9'],
        ['Cuti', 'CUTI (C)', '#ec4899'], ['Terlambat', 'TERLAMBAT (TL)', '#64748b'],
        ['Pendidikan', 'PENDIDIKAN (DIK)', '#14b8a6'], ['BKO', 'BKO', '#3b82f6']
    ];

    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; width: 100%;">
            ${items.map(([key, label, color]) => `
                <div style="background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; padding: 14px 8px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 80px;">
                    <div style="font-weight: 800; font-size: 22px; color: ${color}; margin-bottom: 4px; line-height: 1;">${counts[key] || 0}</div>
                    <div style="font-size: 11px; color: #000000; font-weight: 800; letter-spacing: 0.3px; line-height: 1.2;">${label}</div>
                </div>
            `).join('')}
        </div>
    `;
}

function renderTable() {
    const query = document.getElementById('tableSearch').value.toLowerCase().trim();
    const filter = document.getElementById('tableFilterStatus').value;
    const activeMap = {};

    exceptions.forEach(e => {
        if (!e.is_deleted) activeMap[String(e.personel_id)] = e;
    });

    currentFilteredData = [];

    allPersonel.forEach(p => {
        const exception = activeMap[String(p.id)];
        const status = exception ? exception.status : 'Hadir';
        const keterangan = exception ? (exception.keterangan || '') : '';

        if (filter !== 'Semua' && status !== filter) return;

        const nama = String(p.nama || '');
        const nrp = String(p.nrp_nip || '');

        if (query && !nama.toLowerCase().includes(query) && !nrp.toLowerCase().includes(query)) return;
        currentFilteredData.push({ p, status, keterangan, exception });
    });

    const totalPages = Math.ceil(currentFilteredData.length / rowsPerPage);
    if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
    if (currentPage === 0 && totalPages > 0) currentPage = 1;

    displayTablePage();
}

function displayTablePage() {
    const tbody = document.getElementById('tableAbsenBody');
    tbody.innerHTML = '';

    if (currentFilteredData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5 text-muted fw-bold"><i class="fas fa-search mb-2 d-block fs-3"></i>Data tidak ditemukan.</td></tr>';
        renderPaginationControls();
        return;
    }

    const startIdx = (currentPage - 1) * rowsPerPage;
    const endIdx = startIdx + rowsPerPage;
    const pageData = currentFilteredData.slice(startIdx, endIdx);

    let number = startIdx + 1;
    const rangeStatuses = ['Dinas Luar', 'Cuti', 'BKO', 'Pendidikan'];

    pageData.forEach(item => {
        const { p, status, keterangan, exception } = item;
        const nama = String(p.nama || '');
        const nrp = String(p.nrp_nip || '');

        let badge = 'badge-hadir';
        if (status === 'Sakit') badge = 'badge-sakit';
        else if (status === 'Dinas Luar') badge = 'badge-primary';
        else if (status === 'Izin') badge = 'badge-izin';
        else if (status !== 'Hadir') badge = 'badge-other';

        // Format kolom Keterangan: tampilkan rentang tanggal biru untuk status multi-hari
        let keteranganHtml = escapeHtml(keterangan || '—');
        if (exception && rangeStatuses.includes(status)) {
            const tglMulai = formatTanggalIndo(exception.tanggal_mulai || serverToday);
            const tglSelesai = formatTanggalIndo(exception.tanggal_selesai || serverToday);
            keteranganHtml = `<div style="color:#0369a1; font-size: 0.75rem; font-weight:700;">${escapeHtml(tglMulai + ' – ' + tglSelesai)}</div>`;
            if (keterangan) {
                keteranganHtml += `<div style="color:#475569; font-size:0.8rem; font-weight:500;">${escapeHtml(keterangan)}</div>`;
            }
        }

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center"><span class="no-badge">${number}</span></td>
            <td><span style="color:#000000; font-weight:600; font-size:0.95rem;">${escapeHtml(nama)}</span></td>
            <td style="color:#475569; font-weight:500;">${escapeHtml(p.pangkat || '—')}</td>
            <td style="color:#475569; font-weight:600;">${escapeHtml(nrp || '—')}</td>
            <td><span class="badge bg-light text-dark border" style="border-radius: 6px; font-weight: 700;">${escapeHtml(p.subbid || '—')}</span></td>
            <td><span class="badge bg-light text-dark border" style="border-radius: 6px; font-weight: 700;">${escapeHtml(p.ur || '—')}</span></td>
            <td><span class="badge-status ${badge}">● ${escapeHtml(status)}</span></td>
            <td style="color:#475569; font-weight:500;">${keteranganHtml}</td>
        `;
        tbody.appendChild(tr);
        number++;
    });

    renderPaginationControls();
}

function renderPaginationControls() {
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationButtons = document.getElementById('paginationButtons');
    
    const totalRows = currentFilteredData.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    
    if (totalRows === 0) {
        paginationInfo.innerHTML = 'Menampilkan 0 data';
        paginationButtons.innerHTML = '';
        return;
    }

    const startRange = ((currentPage - 1) * rowsPerPage) + 1;
    const endRange = Math.min(currentPage * rowsPerPage, totalRows);
    
    paginationInfo.innerHTML = `Menampilkan <span style="color:#000;">${startRange} - ${endRange}</span> dari <span style="color:#000;">${totalRows}</span> data`;
    paginationButtons.innerHTML = '';
    
    if (totalPages > 1) {
        const prevBtn = document.createElement('button');
        prevBtn.className = `page-btn-custom ${currentPage === 1 ? 'disabled' : ''}`;
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prevBtn.onclick = () => { if(currentPage > 1) { currentPage--; displayTablePage(); } };
        paginationButtons.appendChild(prevBtn);

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) { startPage = Math.max(1, endPage - 4); }

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.className = `page-btn-custom ${i === currentPage ? 'active' : ''}`;
            btn.innerText = i;
            btn.onclick = () => { currentPage = i; displayTablePage(); };
            paginationButtons.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = `page-btn-custom ${currentPage === totalPages ? 'disabled' : ''}`;
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        nextBtn.onclick = () => { if(currentPage < totalPages) { currentPage++; displayTablePage(); } };
        paginationButtons.appendChild(nextBtn);
    }
}

    // Fungsi untuk menghitung perubahan hari secara dinamis
// Jadikan fungsi global dengan window. agar pasti bisa dipanggil oleh input HTML
window.hitungDurasiHari = function(uid) {
    const mulaiEl = document.getElementById('mulai-' + uid);
    const selesaiEl = document.getElementById('selesai-' + uid);
    const teksDurasiEl = document.getElementById('teks-durasi-' + uid);
    
    if (mulaiEl && selesaiEl && mulaiEl.value && selesaiEl.value && teksDurasiEl) {
        const date1 = new Date(mulaiEl.value);
        const date2 = new Date(selesaiEl.value);
        
        // Hitung selisih hari
        const selisihWaktu = date2.getTime() - date1.getTime();
        const selisihHari = Math.ceil(selisihWaktu / (1000 * 3600 * 24)) + 1;
        
        if (selisihHari > 0) {
            teksDurasiEl.innerHTML = selisihHari + ' hari &middot; absensi tercatat otomatis setiap hari';
        } else {
            teksDurasiEl.innerHTML = '<span style="color:#ef4444;">Tanggal selesai tidak boleh mundur!</span>';
        }
    }
};

</script>

<?= $this->endSection() ?>