<?php
$assetVersion = '1.0.2';
?>

<link rel="stylesheet" href="<?= base_url('assets/fonts/fonts.css?v=' . $assetVersion); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/material-dashboard.min.css?v=' . $assetVersion); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/style.min.css?v=' . $assetVersion); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/js/plugins/file-uploader/css/jquery.dm-uploader.min.css?v=' . $assetVersion); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/js/plugins/file-uploader/css/styles-1.0.css?v=' . $assetVersion); ?>" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />

<style>

/* ========================================
   BACKGROUND HALAMAN UTAMA
   ======================================== */

.main-panel-watermark {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
    background: #111827 !important;
}


/* ========================================
   WATERMARK LOGO
   ======================================== */

.main-panel-watermark::before {
    content: "";

    position: fixed;

    top: 50%;
    left: calc(50% + 140px);

    width: 500px;
    height: 500px;

    transform: translate(-50%, -50%);

    background-image: url("<?= base_url('assets/img/logo_bid_TIK_POLDA.png'); ?>");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;

    opacity: 0.20;

    pointer-events: none;
    z-index: 0;
}


/* ========================================
   ISI HALAMAN DI ATAS WATERMARK
   ======================================== */

.main-panel-watermark > * {
    position: relative;
    z-index: 1;
}


/* ========================================
   SIDEBAR HITAM
   ======================================== */

.sidebar,
.sidebar-wrapper {
    background: #05070A !important;
}


/* ========================================
   HEADER SIDEBAR
   ======================================== */

.sidebar .logo {
    background: #000000 !important;
    padding-top: 25px !important;
    padding-bottom: 25px !important;
}

.sidebar .logo .simple-text {
    color: #F5C542 !important;
    font-weight: 700 !important;
}

.sidebar .logo .simple-text small {
    color: #ffffff !important;
}

.sidebar .logo:after {
    background-color: rgba(245, 197, 66, 0.35) !important;
}


/* ========================================
   GARIS PEMISAH SIDEBAR
   ======================================== */

.sidebar hr {
    border-color: rgba(255, 255, 255, 0.12) !important;
}


/* ========================================
   MENU SIDEBAR
   ======================================== */

.sidebar .nav li a {
    color: #ffffff !important;
}


/* ========================================
   ICON SIDEBAR
   ======================================== */

.sidebar .nav li a i,
.sidebar .nav li a .material-icons {
    color: #ffffff !important;
}


/* ========================================
   MENU AKTIF - MAROON
   ======================================== */

.sidebar .nav li.active > a {
    background: rgba(128, 0, 32, 0.80) !important;
    color: #F5C542 !important;

    box-shadow:
        0 4px 12px rgba(128, 0, 32, 0.35) !important;
}


/* ========================================
   ICON MENU AKTIF - GOLD
   ======================================== */

.sidebar .nav li.active > a i,
.sidebar .nav li.active > a .material-icons {
    color: #F5C542 !important;
}


/* ========================================
   HOVER MENU
   ======================================== */

.sidebar .nav li a:hover {
    background: rgba(128, 0, 32, 0.45) !important;
    color: #ffffff !important;
}


/* ========================================
   GLASS CARD
   ======================================== */

.main-panel-watermark .card {
    background: rgba(255, 255, 255, 0.10) !important;

    border: 1px solid rgba(255, 255, 255, 0.20) !important;

    box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.30) !important;

    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}


/* ========================================
   TULISAN CARD
   ======================================== */

.main-panel-watermark .card h1,
.main-panel-watermark .card h2,
.main-panel-watermark .card h3,
.main-panel-watermark .card h4,
.main-panel-watermark .card h5,
.main-panel-watermark .card h6,
.main-panel-watermark .card p,
.main-panel-watermark .card label,
.main-panel-watermark .card span {
    color: #ffffff;
}


/* ========================================
   INPUT TANGGAL
   ======================================== */

.main-panel-watermark input[type="date"] {
    background: transparent !important;
    color: #ffffff !important;

    border-color: rgba(255, 255, 255, 0.30) !important;
}


/* ========================================
   TOMBOL REFRESH
   ======================================== */

.main-panel-watermark .btn-success {
    background-color: #159b72 !important;
    border: none !important;
}


/* ========================================
   HOVER CARD
   ======================================== */

.main-panel-watermark .card:hover {
    background: rgba(255, 255, 255, 0.14) !important;
    transition: 0.3s;
}

</style>