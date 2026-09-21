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
    --text-muted: #555555;

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
    padding: 0 0 30px 0;
}


/* ============================================================
   MENGHILANGKAN HEADER / JUDUL BAWAAN LAYOUT
============================================================ */

.page-header,
.page-title,
.breadcrumb,
.content-header,
.main-header-title {
    display: none !important;
}

.polda-dashboard ~ .page-header {
    display: none !important;
}


/* ============================================================
   HEADER / WELCOME
============================================================ */

.polda-welcome {
    position: relative;
    overflow: hidden;

    width: 100%;
    min-height: 225px;

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

    padding: 42px 45px;

    margin-bottom: 28px;

    color: var(--polda-white);

    box-shadow: 0 10px 30px rgba(0, 0, 0, .13);
}


/* ============================================================
   DEKORASI HEADER
============================================================ */

.polda-welcome::before {
    content: "";

    position: absolute;

    width: 320px;
    height: 320px;

    right: -110px;
    top: -150px;

    border: 45px solid rgba(199, 165, 74, .13);

    border-radius: 50%;
}


.polda-welcome::after {
    content: "";

    position: absolute;

    width: 160px;
    height: 160px;

    right: 120px;
    bottom: -95px;

    border: 23px solid rgba(181, 18, 27, .18);

    border-radius: 50%;
}


/* ============================================================
   HEADER CONTENT
============================================================ */

.polda-welcome-content {
    position: relative;
    z-index: 5;
}


.polda-welcome-label {
    display: inline-flex;
    align-items: center;

    gap: 9px;

    font-size: 13px;
    font-weight: 800;

    letter-spacing: 1.8px;

    text-transform: uppercase;

    color: #e4c875;

    margin-bottom: 13px;
}


.polda-welcome-label::before {
    content: "";

    width: 8px;
    height: 8px;

    background: var(--polda-red);

    border-radius: 50%;
}


.polda-welcome h2 {
    margin: 0;

    font-size: 34px;
    line-height: 1.25;

    font-weight: 800;

    color: #ffffff;
}


.polda-welcome p {
    margin: 12px 0 0;

    color: rgba(255, 255, 255, .76);

    font-size: 15px;

    line-height: 1.6;
}


.polda-date {
    display: inline-flex;
    align-items: center;

    margin-top: 20px;

    padding: 9px 15px;

    border-radius: 8px;

    background: rgba(255, 255, 255, .08);

    border: 1px solid rgba(255, 255, 255, .10);

    font-size: 13px;

    color: rgba(255, 255, 255, .88);
}


.polda-date .material-icons {
    font-size: 17px;

    margin-right: 7px;
}


/* ============================================================
   SECTION TITLE
============================================================ */

.polda-section-title {
    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 16px;
}


.polda-section-title-left {
    display: flex;

    align-items: center;

    gap: 11px;
}


.polda-section-title-icon {
    width: 40px;
    height: 40px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: var(--polda-gold-soft);

    color: var(--polda-gold);
}


.polda-section-title-icon .material-icons {
    font-size: 21px;
}


.polda-section-title h3 {
    margin: 0;

    font-size: 19px;

    font-weight: 800;

    color: var(--polda-gold);
}


.polda-section-title span {
    display: block;

    font-size: 13px;

    color: #555555;

    margin-top: 3px;
}


/* ============================================================
   KPI GRID
============================================================ */

.polda-kpi-grid {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 18px;

    margin-bottom: 29px;
}


/* ============================================================
   KPI CARD
============================================================ */

.polda-kpi {
    position: relative;

    background: var(--polda-white);

    border: 1px solid var(--border);

    border-radius: 16px;

    padding: 21px;

    min-height: 155px;

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


.polda-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;

    width: 4px;
    height: 100%;

    background: var(--polda-red);
}


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


.polda-kpi-head {
    position: relative;

    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 18px;
}


.polda-kpi-icon {
    width: 48px;
    height: 48px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    color: #ffffff;

    box-shadow:
        0 5px 12px rgba(0, 0, 0, .10);
}


.polda-kpi-icon .material-icons {
    font-size: 23px;
}


.polda-kpi-status {
    font-size: 11px;

    font-weight: 800;

    letter-spacing: .7px;

    padding: 6px 9px;

    border-radius: 20px;

    background: #f4f4f4;

    color: #333333;
}


.polda-kpi-title {
    position: relative;

    z-index: 2;

    font-size: 13px;

    color: #444444;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .7px;
}


.polda-kpi-value {
    position: relative;

    z-index: 2;

    font-size: 32px;

    line-height: 1;

    margin-top: 8px;

    font-weight: 850;

    color: #171717;
}


/* ============================================================
   WARNA KPI
============================================================ */

.kpi-total::before {
    background: var(--polda-red);
}

.kpi-total .polda-kpi-icon {
    background: var(--polda-red);
}


.kpi-hadir::before {
    background: #198754;
}

.kpi-hadir .polda-kpi-icon {
    background: #198754;
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

    padding: 21px 24px;

    border-bottom: 1px solid var(--border);
}


.polda-card-title {
    display: flex;

    align-items: center;

    gap: 12px;
}


.polda-card-title-icon {
    width: 43px;
    height: 43px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: var(--polda-red-soft);

    color: var(--polda-red);
}


.polda-card-title-icon .material-icons {
    font-size: 21px;
}


.polda-card-title h4 {
    margin: 0;

    font-size: 17px;

    font-weight: 800;

    color: var(--polda-black);
}


.polda-card-title span {
    display: block;

    font-size: 12px;

    color: #666666;

    margin-top: 4px;
}


/* ============================================================
   CARD BODY
============================================================ */

.polda-card-body {
    padding: 23px;
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
   RESPONSIVE
============================================================ */

@media (max-width: 1200px) {

    .polda-kpi-grid {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }
}


@media (max-width: 900px) {

    .polda-kpi-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
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
        padding: 30px 25px;

        border-radius: 15px;

        min-height: 210px;
    }

    .polda-welcome h2 {
        font-size: 25px;
    }

    .polda-welcome p {
        font-size: 13px;
    }

    .polda-kpi-grid {
        grid-template-columns: 1fr;
    }

    .polda-card-header {
        padding: 17px;
    }

    .polda-card-body {
        padding: 17px;
    }

    .chart-container {
        height: 270px;
    }
}


@media (max-width: 400px) {

    .polda-welcome {
        min-height: 200px;
    }

    .polda-welcome h2 {
        font-size: 21px;
    }

    .polda-kpi {
        min-height: 140px;
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

                <?= isset($dateNow)
                    ? $dateNow
                    : date('d F Y'); ?>

            </div>

        </div>

    </div>


    <!-- ========================================================
         JUDUL STATISTIK PERSONEL
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
                <?= $totalPersonel
                    ?? (isset($siswa)
                        ? count($siswa)
                        : 0); ?>
            </div>

        </div>


        <!-- HADIR -->

        <div class="polda-kpi kpi-hadir">

            <div class="polda-kpi-head">

                <div class="polda-kpi-icon">

                    <i class="material-icons">
                        check_circle
                    </i>

                </div>

                <div class="polda-kpi-status">
                    HADIR
                </div>

            </div>

            <div class="polda-kpi-title">
                Hadir
            </div>

            <div class="polda-kpi-value">
                <?= $totalHadir ?? 0; ?>
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
                <?= $totalDinas ?? 0; ?>
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
                <?= $totalLepasDinas ?? 0; ?>
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
                <?= $totalCuti ?? 0; ?>
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
                <?= $totalSakit ?? 0; ?>
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
                <?= $totalIzin ?? 0; ?>
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
                <?= $totalTerlambat ?? 0; ?>
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
                <?= $totalDik ?? 0; ?>
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
                <?= $totalBko ?? 0; ?>
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
                        Monitoring jumlah kehadiran anggota berdasarkan status hari ini
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

    const canvas =
        document.getElementById("attendanceChart");

    if (!canvas) {
        return;
    }

    const ctx =
        canvas.getContext("2d");


    /* ========================================================
       STATUS ABSENSI
    ======================================================== */

    const labels = [
        "HADIR",
        "DINAS",
        "LEPAS DINAS",
        "CUTI",
        "SAKIT",
        "IZIN",
        "TERLAMBAT",
        "DIK",
        "BKO"
    ];


    /* ========================================================
       DATA DARI CONTROLLER
    ======================================================== */

    const attendanceData = [

        <?= (int) ($totalHadir ?? 0) ?>,

        <?= (int) ($totalDinas ?? 0) ?>,

        <?= (int) ($totalLepasDinas ?? 0) ?>,

        <?= (int) ($totalCuti ?? 0) ?>,

        <?= (int) ($totalSakit ?? 0) ?>,

        <?= (int) ($totalIzin ?? 0) ?>,

        <?= (int) ($totalTerlambat ?? 0) ?>,

        <?= (int) ($totalDik ?? 0) ?>,

        <?= (int) ($totalBko ?? 0) ?>

    ];


    /* ========================================================
       GRAFIK LINE
    ======================================================== */

    new Chart(ctx, {

        type: "line",

        data: {

            labels: labels,

            datasets: [

                {

                    label: "Jumlah Personel",

                    data: attendanceData,

                    borderColor: "#171717",

                    backgroundColor:
                        "rgba(23, 23, 23, 0.08)",

                    pointBackgroundColor:
                        "#171717",

                    pointBorderColor:
                        "#ffffff",

                    pointBorderWidth: 2,

                    pointRadius: 6,

                    pointHoverRadius: 8,

                    borderWidth: 3,

                    tension: 0.35,

                    fill: true

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

                        pointStyle: "circle",

                        boxWidth: 8,

                        padding: 15,

                        color: "#171717",

                        font: {

                            size: 13,

                            weight: "600"

                        }

                    }

                },


                tooltip: {

                    backgroundColor: "#171717",

                    titleColor: "#ffffff",

                    bodyColor: "#ffffff",

                    padding: 12,

                    cornerRadius: 8,

                    callbacks: {

                        label: function (context) {

                            return " " +
                                context.parsed.y +
                                " personel";

                        }

                    }

                }

            },


            scales: {

                x: {

                    grid: {

                        display: false

                    },

                    ticks: {

                        color: "#171717",

                        font: {

                            size: 11,

                            weight: "600"

                        },

                        maxRotation: 0,

                        minRotation: 0

                    }

                },


                y: {

                    beginAtZero: true,

                    ticks: {

                        color: "#171717",

                        precision: 0,

                        stepSize: 1,

                        font: {

                            size: 12,

                            weight: "500"

                        }

                    },

                    title: {

                        display: true,

                        text: "Jumlah Personel",

                        color: "#171717",

                        font: {

                            size: 12,

                            weight: "600"

                        }

                    },

                    grid: {

                        color:
                            "rgba(0, 0, 0, 0.08)"

                    }

                }

            }

        },


        plugins: [

            {

                id: "valueLabels",

                afterDatasetsDraw:
                    function (chart) {

                    const ctx = chart.ctx;

                    ctx.save();

                    ctx.fillStyle = "#171717";

                    ctx.font =
                        "600 12px Arial";

                    ctx.textAlign =
                        "center";

                    ctx.textBaseline =
                        "bottom";

                    const meta =
                        chart.getDatasetMeta(0);

                    meta.data.forEach(
                        function (
                            point,
                            index
                        ) {

                            const value =
                                chart
                                    .data
                                    .datasets[0]
                                    .data[index];

                            ctx.fillText(
                                value,
                                point.x,
                                point.y - 10
                            );

                        }
                    );

                    ctx.restore();

                }

            }

        ]

    });

});
</script>


<?= $this->endSection() ?>