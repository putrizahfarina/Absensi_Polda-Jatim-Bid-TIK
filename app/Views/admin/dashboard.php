```php
<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>

<style>
/* ============================================================
   DASHBOARD BID TIK POLDA JAWA TIMUR
   Tema : Hitam - Putih - Merah - Gold
============================================================ */

:root {
    --polda-red: #b5121b;
    --polda-red-dark: #850c13;
    --polda-red-soft: #fcebed;

    --polda-black: #171717;
    --polda-dark: #242424;
    --polda-gray: #666;
    --polda-light-gray: #f5f6f8;

    --polda-gold: #c7a54a;
    --polda-gold-soft: #f7f0dc;

    --polda-white: #ffffff;

    --text-dark: #202124;
    --text-muted: #777;

    --border: #e8e8e8;

    --shadow-sm: 0 4px 15px rgba(0, 0, 0, .05);
    --shadow-md: 0 8px 25px rgba(0, 0, 0, .08);
}


/* ============================================================
   RESET AREA DASHBOARD
============================================================ */

.polda-dashboard {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 5px 0 30px 0;
}


/* ============================================================
   MENGHILANGKAN HEADER / JUDUL BAWAAN LAYOUT
   Supaya tidak bertumpuk dengan dashboard
============================================================ */

.page-header,
.page-title,
.breadcrumb,
.content-header,
.main-header-title {
    display: none !important;
}


/*
   Beberapa template menggunakan heading di dalam
   content wrapper. Kita tidak menyentuh seluruh .content
   agar dashboard tidak rusak.
*/
.polda-dashboard ~ .page-header {
    display: none !important;
}


/* ============================================================
   HEADER / WELCOME
============================================================ */

.polda-welcome {
    position: relative;
    overflow: hidden;

    min-height: 175px;

    display: flex;
    align-items: center;

    background:
        linear-gradient(
            135deg,
            #151515 0%,
            #242424 55%,
            #850c13 100%
        );

    border-radius: 20px;

    padding: 30px 34px;

    margin-bottom: 25px;

    color: var(--polda-white);

    box-shadow: 0 10px 30px rgba(0, 0, 0, .13);
}


/* Ornamen lingkaran */

.polda-welcome::before {
    content: "";

    position: absolute;

    width: 270px;
    height: 270px;

    right: -95px;
    top: -125px;

    border: 42px solid rgba(199, 165, 74, .13);

    border-radius: 50%;
}


.polda-welcome::after {
    content: "";

    position: absolute;

    width: 130px;
    height: 130px;

    right: 100px;
    bottom: -80px;

    border: 20px solid rgba(181, 18, 27, .18);

    border-radius: 50%;
}


/* Isi header */

.polda-welcome-content {
    position: relative;
    z-index: 5;
}


.polda-welcome-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    font-size: 11px;
    font-weight: 800;

    letter-spacing: 1.8px;

    text-transform: uppercase;

    color: #e4c875;

    margin-bottom: 9px;
}


.polda-welcome-label::before {
    content: "";

    width: 7px;
    height: 7px;

    background: var(--polda-red);

    border-radius: 50%;
}


.polda-welcome h2 {
    margin: 0;

    font-size: 27px;
    line-height: 1.25;

    font-weight: 800;

    color: #ffffff;
}


.polda-welcome p {
    margin: 9px 0 0;

    color: rgba(255, 255, 255, .76);

    font-size: 13px;

    line-height: 1.6;
}


.polda-date {
    display: inline-flex;
    align-items: center;

    margin-top: 17px;

    padding: 7px 12px;

    border-radius: 8px;

    background: rgba(255, 255, 255, .08);

    border: 1px solid rgba(255, 255, 255, .10);

    font-size: 12px;

    color: rgba(255, 255, 255, .88);
}


.polda-date .material-icons {
    font-size: 15px;

    margin-right: 6px;
}


/* ============================================================
   SECTION TITLE
============================================================ */

.polda-section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 14px;
}


.polda-section-title-left {
    display: flex;
    align-items: center;
    gap: 10px;
}


.polda-section-title-icon {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: var(--polda-red-soft);

    color: var(--polda-red);
}


.polda-section-title-icon .material-icons {
    font-size: 18px;
}


.polda-section-title h3 {
    margin: 0;

    font-size: 16px;

    font-weight: 800;

    color: var(--polda-black);
}


.polda-section-title span {
    font-size: 11px;

    color: #888;
}


/* ============================================================
   KPI GRID
============================================================ */

.polda-kpi-grid {
    display: grid;

    grid-template-columns: repeat(4, minmax(0, 1fr));

    gap: 17px;

    margin-bottom: 27px;
}


/* ============================================================
   KPI CARD
============================================================ */

.polda-kpi {
    position: relative;

    background: var(--polda-white);

    border: 1px solid var(--border);

    border-radius: 16px;

    padding: 19px;

    min-height: 145px;

    overflow: hidden;

    box-shadow: var(--shadow-sm);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}


.polda-kpi:hover {
    transform: translateY(-4px);

    box-shadow: var(--shadow-md);

    border-color: #ddd;
}


/* Garis warna kiri */

.polda-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;

    width: 4px;
    height: 100%;

    background: var(--polda-red);
}


/* Lingkaran dekorasi */

.polda-kpi::after {
    content: "";

    position: absolute;

    width: 85px;
    height: 85px;

    right: -35px;
    bottom: -35px;

    border-radius: 50%;

    background: rgba(181, 18, 27, .035);
}


/* Header KPI */

.polda-kpi-head {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 17px;
}


/* Icon */

.polda-kpi-icon {
    width: 45px;
    height: 45px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    color: #ffffff;

    box-shadow: 0 5px 12px rgba(0, 0, 0, .10);
}


.polda-kpi-icon .material-icons {
    font-size: 21px;
}


/* Badge */

.polda-kpi-status {
    font-size: 9px;

    font-weight: 800;

    letter-spacing: .7px;

    padding: 5px 8px;

    border-radius: 20px;

    background: #f4f4f4;

    color: #666;
}


/* Judul */

.polda-kpi-title {
    position: relative;
    z-index: 2;

    font-size: 11px;

    color: var(--text-muted);

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .7px;
}


/* Angka */

.polda-kpi-value {
    position: relative;
    z-index: 2;

    font-size: 28px;

    line-height: 1;

    margin-top: 7px;

    font-weight: 850;

    color: var(--polda-black);
}


/* ============================================================
   WARNA MASING-MASING KPI
============================================================ */

.kpi-total::before {
    background: var(--polda-red);
}

.kpi-total .polda-kpi-icon {
    background: var(--polda-red);
}


.kpi-dinas::before {
    background: #242424;
}

.kpi-dinas .polda-kpi-icon {
    background: #242424;
}


.kpi-lepas::before {
    background: #666;
}

.kpi-lepas .polda-kpi-icon {
    background: #666;
}


.kpi-cuti::before {
    background: #9b7b24;
}

.kpi-cuti .polda-kpi-icon {
    background: #9b7b24;
}


.kpi-sakit::before {
    background: #a51b24;
}

.kpi-sakit .polda-kpi-icon {
    background: #a51b24;
}


.kpi-izin::before {
    background: #555;
}

.kpi-izin .polda-kpi-icon {
    background: #555;
}


.kpi-terlambat::before {
    background: #c47b13;
}

.kpi-terlambat .polda-kpi-icon {
    background: #c47b13;
}


.kpi-dik::before {
    background: #704c7d;
}

.kpi-dik .polda-kpi-icon {
    background: #704c7d;
}


.kpi-bko::before {
    background: #333;
}

.kpi-bko .polda-kpi-icon {
    background: #333;
}


/* ============================================================
   CARD UTAMA
============================================================ */

.polda-card {
    background: #ffffff;

    border-radius: 17px;

    border: 1px solid var(--border);

    box-shadow: var(--shadow-sm);

    margin-bottom: 25px;

    overflow: hidden;
}


/* ============================================================
   CARD HEADER
============================================================ */

.polda-card-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 19px 22px;

    border-bottom: 1px solid var(--border);
}


.polda-card-title {
    display: flex;

    align-items: center;

    gap: 11px;
}


.polda-card-title-icon {
    width: 39px;
    height: 39px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: var(--polda-red-soft);

    color: var(--polda-red);
}


.polda-card-title-icon .material-icons {
    font-size: 19px;
}


.polda-card-title h4 {
    margin: 0;

    font-size: 15px;

    font-weight: 800;

    color: var(--polda-black);
}


.polda-card-title span {
    display: block;

    font-size: 10px;

    color: #888;

    margin-top: 3px;
}


/* ============================================================
   CARD BODY
============================================================ */

.polda-card-body {
    padding: 21px;
}


/* ============================================================
   REKAP KEHADIRAN
============================================================ */

.attendance-grid {
    display: grid;

    grid-template-columns: repeat(4, minmax(0, 1fr));

    gap: 14px;
}


.attendance-item {
    position: relative;

    background: #fafafa;

    border: 1px solid var(--border);

    border-radius: 13px;

    padding: 16px;

    transition: .2s ease;

    overflow: hidden;
}


.attendance-item:hover {
    background: #ffffff;

    transform: translateY(-2px);

    box-shadow: 0 5px 15px rgba(0, 0, 0, .06);
}


.attendance-top {
    display: flex;

    align-items: center;

    justify-content: space-between;
}


.attendance-label {
    font-size: 10px;

    color: #777;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .5px;
}


.attendance-icon {
    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: var(--polda-red-soft);

    color: var(--polda-red);
}


.attendance-icon .material-icons {
    font-size: 17px;
}


.attendance-number {
    font-size: 24px;

    font-weight: 850;

    margin-top: 10px;

    color: var(--polda-black);
}


/* ============================================================
   CHART
============================================================ */

.chart-container {
    position: relative;

    width: 100%;

    height: 330px;

    padding: 5px;
}


/* ============================================================
   BADGE
============================================================ */

.status-badge {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 5px 9px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 700;

    background: #f3f3f3;

    color: #555;
}


.status-badge::before {
    content: "";

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}


/* ============================================================
   RESPONSIVE
============================================================ */

@media (max-width: 1200px) {

    .polda-kpi-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .attendance-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}


@media (max-width: 900px) {

    .polda-kpi-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .attendance-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .polda-welcome {
        min-height: auto;
    }
}


@media (max-width: 600px) {

    .polda-dashboard {
        padding: 0 0 25px 0;
    }

    .polda-welcome {
        padding: 23px;

        border-radius: 15px;
    }

    .polda-welcome h2 {
        font-size: 21px;
    }

    .polda-welcome p {
        font-size: 12px;
    }

    .polda-kpi-grid,
    .attendance-grid {
        grid-template-columns: 1fr;
    }

    .polda-card-header {
        padding: 16px;
    }

    .polda-card-body {
        padding: 16px;
    }

    .chart-container {
        height: 270px;
    }
}


@media (max-width: 400px) {

    .polda-welcome h2 {
        font-size: 19px;
    }

    .polda-kpi {
        min-height: 135px;
    }
}

</style>


<!-- ============================================================
     WRAPPER DASHBOARD
============================================================ -->

<div class="polda-dashboard">


    <!-- ========================================================
         HEADER DASHBOARD
    ========================================================= -->

    <div class="polda-welcome">

        <div class="polda-welcome-content">

            <div class="polda-welcome-label">
                Sistem Informasi Bidang TIK
            </div>

            <h2>
                Dashboard Bid TIK Polda Jawa Timur
            </h2>

            <p>
                Monitoring dan rekapitulasi data kehadiran anggota/personel
            </p>

            <div class="polda-date">

                <i class="material-icons">
                    calendar_today
                </i>

                <?= isset($dateNow) ? $dateNow : date('d F Y'); ?>

            </div>

        </div>

    </div>


    <!-- ========================================================
         JUDUL DATA PERSONEL
    ========================================================= -->

    <div class="polda-section-title">

        <div class="polda-section-title-left">

            <div class="polda-section-title-icon">

                <i class="material-icons">
                    groups
                </i>

            </div>

            <div>

                <h3>
                    Statistik Personel
                </h3>

                <span>
                    Ringkasan status personel hari ini
                </span>

            </div>

        </div>

    </div>


    <!-- ========================================================
         KPI DASHBOARD
    ========================================================= -->

    <div class="polda-kpi-grid">


        <!-- TOTAL ANGGOTA -->

        <div class="polda-kpi kpi-total">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        groups
                    </i>

                </div>

                <div class="polda-kpi-status">
                    PERSONEL
                </div>

            </div>

            <div class="polda-kpi-title">
                Total Anggota
            </div>

            <div class="polda-kpi-value">

                <?= isset($siswa) ? count($siswa) : 0; ?>

            </div>

        </div>


        <!-- DINAS -->

        <div class="polda-kpi kpi-dinas">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        work
                    </i>

                </div>

                <div class="polda-kpi-status">
                    AKTIF
                </div>

            </div>

            <div class="polda-kpi-title">
                Dinas
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- LEPAS DINAS -->

        <div class="polda-kpi kpi-lepas">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        logout
                    </i>

                </div>

                <div class="polda-kpi-status">
                    STATUS
                </div>

            </div>

            <div class="polda-kpi-title">
                Lepas Dinas
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- CUTI -->

        <div class="polda-kpi kpi-cuti">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        event
                    </i>

                </div>

                <div class="polda-kpi-status">
                    STATUS
                </div>

            </div>

            <div class="polda-kpi-title">
                Cuti
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- SAKIT -->

        <div class="polda-kpi kpi-sakit">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        healing
                    </i>

                </div>

                <div class="polda-kpi-status">
                    STATUS
                </div>

            </div>

            <div class="polda-kpi-title">
                Sakit
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- IZIN -->

        <div class="polda-kpi kpi-izin">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        assignment
                    </i>

                </div>

                <div class="polda-kpi-status">
                    STATUS
                </div>

            </div>

            <div class="polda-kpi-title">
                Izin
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- TERLAMBAT -->

        <div class="polda-kpi kpi-terlambat">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        schedule
                    </i>

                </div>

                <div class="polda-kpi-status">
                    PERINGATAN
                </div>

            </div>

            <div class="polda-kpi-title">
                Terlambat
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- DIK -->

        <div class="polda-kpi kpi-dik">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        school
                    </i>

                </div>

                <div class="polda-kpi-status">
                    STATUS
                </div>

            </div>

            <div class="polda-kpi-title">
                DIK
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


        <!-- BKO -->

        <div class="polda-kpi kpi-bko">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        swap_horiz
                    </i>

                </div>

                <div class="polda-kpi-status">
                    PENUGASAN
                </div>

            </div>

            <div class="polda-kpi-title">
                BKO
            </div>

            <div class="polda-kpi-value">
                0
            </div>

        </div>


    </div>


    <!-- ========================================================
         REKAP KEHADIRAN
    ========================================================= -->

    <div class="polda-card">

        <div class="polda-card-header">

            <div class="polda-card-title">

                <div class="polda-card-title-icon">

                    <i class="material-icons">
                        fact_check
                    </i>

                </div>

                <div>

                    <h4>
                        Rekap Kehadiran Anggota
                    </h4>

                    <span>
                        Status kehadiran personel hari ini
                    </span>

                </div>

            </div>

        </div>


        <div class="polda-card-body">

            <div class="attendance-grid">


                <!-- DINAS -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            Dinas
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                work
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- LEPAS DINAS -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            Lepas Dinas
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                logout
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- CUTI -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            Cuti
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                event
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- SAKIT -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            Sakit
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                healing
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- IZIN -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            Izin
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                assignment
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- TERLAMBAT -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            Terlambat
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                schedule
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- DIK -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            DIK
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                school
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


                <!-- BKO -->

                <div class="attendance-item">

                    <div class="attendance-top">

                        <div class="attendance-label">
                            BKO
                        </div>

                        <div class="attendance-icon">

                            <i class="material-icons">
                                swap_horiz
                            </i>

                        </div>

                    </div>

                    <div class="attendance-number">
                        0
                    </div>

                </div>


            </div>

        </div>

    </div>


    <!-- ========================================================
         GRAFIK KEHADIRAN
    ========================================================= -->

    <div class="polda-card">

        <div class="polda-card-header">

            <div class="polda-card-title">

                <div class="polda-card-title-icon">

                    <i class="material-icons">
                        show_chart
                    </i>

                </div>

                <div>

                    <h4>
                        Grafik Kehadiran
                    </h4>

                    <span>
                        Monitoring jumlah kehadiran anggota
                    </span>

                </div>

            </div>

        </div>


        <div class="polda-card-body">

            <div class="chart-container">

                <canvas id="attendanceChart"></canvas>

            </div>

        </div>

    </div>


</div>


<!-- ============================================================
     CHART JS
============================================================ -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById("attendanceChart");

    if (!canvas) {
        return;
    }

    const ctx = canvas.getContext("2d");


    const labels = <?= isset($dateRange)
        ? json_encode($dateRange)
        : json_encode([]);
    ?>;


    const attendanceData = <?= isset($jumlahKehadiranSiswa)
        ? json_encode($jumlahKehadiranSiswa)
        : json_encode([]);
    ?>;


    new Chart(ctx, {

        type: "line",

        data: {

            labels: labels,

            datasets: [

                {

                    label: "Kehadiran Anggota",

                    data: attendanceData,

                    borderWidth: 3,

                    tension: 0.35,

                    fill: true,

                    pointRadius: 4,

                    pointHoverRadius: 6,

                    backgroundColor: "rgba(181, 18, 27, 0.08)",

                    borderColor: "#b5121b",

                    pointBackgroundColor: "#b5121b",

                    pointBorderColor: "#ffffff",

                    pointBorderWidth: 2

                }

            ]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                intersect: false,

                mode: "index"

            },


            plugins: {

                legend: {

                    display: true,

                    position: "top",

                    align: "end",

                    labels: {

                        usePointStyle: true,

                        boxWidth: 8,

                        padding: 15

                    }

                },


                tooltip: {

                    backgroundColor: "#171717",

                    titleColor: "#ffffff",

                    bodyColor: "#ffffff",

                    padding: 12,

                    cornerRadius: 8

                }

            },


            scales: {

                x: {

                    grid: {

                        display: false

                    },

                    ticks: {

                        color: "#777",

                        font: {

                            size: 11

                        }

                    }

                },


                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0,

                        color: "#777",

                        font: {

                            size: 11

                        }

                    },

                    grid: {

                        color: "rgba(0, 0, 0, 0.06)"

                    }

                }

            }

        }

    });

});

</script>


<?= $this->endSection() ?>
```
