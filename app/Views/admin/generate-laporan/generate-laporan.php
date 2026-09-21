<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
    /* =========================================================
       GENERATE LAPORAN - BID TIK POLDA JAWA TIMUR
       ========================================================= */

    body {
        font-size: 14px;
    }

    .content {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    .laporan-page {
        width: 100%;
        padding: 0 5px 40px;
        margin-top: 0 !important;
        position: relative;
        z-index: 1;
    }

    /* =========================================================
       HERO HITAM - MERAH
       ========================================================= */

    .laporan-hero {
        position: relative;
        overflow: hidden;

        width: calc(100% + 10px);
        margin-left: -5px;
        margin-top: -95px;
        margin-bottom: 30px;

        min-height: 330px;
        padding: 145px 48px 55px;

        display: flex;
        align-items: center;

        border-radius: 0 0 22px 22px;

        background:
            linear-gradient(
                115deg,
                #171717 0%,
                #202020 40%,
                #3a171a 70%,
                #850c13 100%
            );

        color: #fff;

        box-shadow: 0 12px 30px rgba(0, 0, 0, .14);

        z-index: 1;
    }

    .laporan-hero-content {
        position: relative;
        z-index: 3;
        max-width: 760px;
    }

    .laporan-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        margin-bottom: 12px;
        padding: 8px 15px;

        border: 1px solid rgba(255,255,255,.20);
        border-radius: 30px;

        background: rgba(255,255,255,.08);

        color: #e5c86b;

        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .laporan-eyebrow i {
        font-size: 19px;
    }

    .laporan-hero h2 {
        margin: 0 0 12px;

        color: #fff;

        font-size: 40px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .laporan-hero p {
        max-width: 680px;
        margin: 0;

        color: rgba(255,255,255,.92);

        font-size: 16px;
        font-weight: 500;
        line-height: 1.7;
    }

    /* =========================================================
       DEKORASI HERO
       ========================================================= */

    .hero-decoration {
        position: absolute;
        right: 55px;
        top: 58%;

        width: 150px;
        height: 150px;

        display: flex;
        align-items: center;
        justify-content: center;

        transform: translateY(-50%);

        border: 1px solid rgba(255,255,255,.10);
        border-radius: 50%;

        background: rgba(255,255,255,.04);

        z-index: 2;
    }

    .hero-decoration::before {
        content: "";

        position: absolute;

        width: 105px;
        height: 105px;

        border: 1px solid rgba(199,165,74,.22);
        border-radius: 50%;
    }

    .hero-decoration i {
        position: relative;
        z-index: 2;

        color: #c7a54a;
        font-size: 58px;
    }

    /* =========================================================
       ALERT
       ========================================================= */

    .laporan-alert {
        border: none;
        border-radius: 12px;

        box-shadow: 0 5px 18px rgba(0,0,0,.08);

        font-size: 13px;
        font-weight: 600;
    }

    /* =========================================================
       MAIN CARD
       ========================================================= */

    .laporan-main-card {
        overflow: hidden;

        background: #fff;

        border: 1px solid #e8e8e8;
        border-radius: 18px;

        box-shadow: 0 8px 25px rgba(0,0,0,.07);
    }

    /* =========================================================
       SECTION HEADER
       ========================================================= */

    .laporan-section-header {
        min-height: 85px;
        padding: 20px 28px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        border-bottom: 1px solid #eeeeee;
    }

    .section-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .section-header-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: #fcebed;
        color: #b5121b;
    }

    .section-header-icon i {
        font-size: 25px;
    }

    .laporan-section-header h4 {
        margin: 0 0 5px;

        color: #171717;

        font-size: 21px;
        font-weight: 800;
    }

    .laporan-section-header p {
        margin: 0;

        color: #555555;

        font-size: 14px;
        font-weight: 500;
    }

    .section-badge {
        padding: 8px 14px;

        border-radius: 20px;

        background: #f7f0dc;
        color: #735a13;

        font-size: 12px;
        font-weight: 800;
        letter-spacing: .8px;
    }

    /* =========================================================
       FORM BODY
       ========================================================= */

    .laporan-form-body {
        padding: 28px;
    }

    /* =========================================================
       FILTER
       ========================================================= */

    .filter-box {
        padding: 22px;

        display: grid;
        grid-template-columns: 1fr 310px;
        gap: 30px;
        align-items: center;

        border: 1px solid #eeeeee;
        border-radius: 14px;

        background: #fafafa;
    }

    .filter-description {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .filter-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: #171717;
        color: #c7a54a;
    }

    .filter-icon i {
        font-size: 24px;
    }

    .filter-description h5 {
        margin: 0 0 5px;

        color: #171717;

        font-size: 16px;
        font-weight: 800;
    }

    .filter-description p {
        margin: 0;

        color: #555555;

        font-size: 14px;
        font-weight: 500;
        line-height: 1.7;
    }

    .filter-label {
        display: block;

        margin-bottom: 7px;

        color: #333333;

        font-size: 12px;
        font-weight: 800;
        letter-spacing: .7px;
    }

    .date-input-wrapper {
        position: relative;
    }

    .date-input-wrapper > i {
        position: absolute;
        left: 13px;
        top: 50%;

        transform: translateY(-50%);

        color: #b5121b;
        font-size: 20px;

        pointer-events: none;
        z-index: 2;
    }

    /* =========================================================
       INPUT TANGGAL
       ========================================================= */

    .date-input {
        height: 48px;

        padding-left: 43px !important;

        border: 1px solid #cccccc !important;
        border-radius: 9px !important;

        background: #fff !important;

        color: #111111 !important;
        -webkit-text-fill-color: #111111 !important;

        font-size: 16px !important;
        font-weight: 700 !important;

        opacity: 1 !important;
    }

    .date-input::-webkit-datetime-edit,
    .date-input::-webkit-datetime-edit-fields-wrapper,
    .date-input::-webkit-datetime-edit-text,
    .date-input::-webkit-datetime-edit-month-field,
    .date-input::-webkit-datetime-edit-day-field,
    .date-input::-webkit-datetime-edit-year-field {
        color: #111111 !important;
        -webkit-text-fill-color: #111111 !important;
        font-size: 16px !important;
        font-weight: 700 !important;
    }

    .date-input:focus {
        border-color: #b5121b !important;

        box-shadow:
            0 0 0 3px rgba(181,18,27,.08) !important;
    }

    /* =========================================================
       STATUS
       ========================================================= */

    .status-section {
        margin-top: 28px;
    }

    .status-section-title {
        margin-bottom: 14px;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .status-section-title h5 {
        margin: 0;

        color: #171717;

        font-size: 16px;
        font-weight: 800;
    }

    .status-section-title span {
        padding: 6px 11px;

        border-radius: 20px;

        background: #f1f2f4;
        color: #444444;

        font-size: 12px;
        font-weight: 700;
    }

    .status-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .status-card {
        min-height: 78px;
        padding: 14px 15px;

        display: flex;
        align-items: center;
        gap: 12px;

        border: 1px solid #e5e5e5;
        border-radius: 11px;

        background: #fff;

        transition: .2s ease;
    }

    .status-card:hover {
        transform: translateY(-2px);

        box-shadow: 0 5px 15px rgba(0,0,0,.08);
    }

    .status-icon {
        width: 40px;
        height: 40px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: #f1f2f4;
        color: #444444;
    }

    .status-icon i {
        font-size: 20px;
    }

    .status-name {
        margin: 0 0 4px;

        color: #222222;

        font-size: 13px;
        font-weight: 800;
    }

    .status-desc {
        margin: 0;

        color: #666666;

        font-size: 12px;
        font-weight: 500;
    }

    /* =========================================================
       POIN APEL
       ========================================================= */

    .apel-info {
        margin-top: 18px;
        padding: 17px 18px;

        display: flex;
        align-items: center;
        gap: 13px;

        border: 1px solid #eadfbf;
        border-radius: 12px;

        background: #fffaf0;
    }

    .apel-icon {
        width: 44px;
        height: 44px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: #f7f0dc;
        color: #8a6915;
    }

    .apel-icon i {
        font-size: 22px;
    }

    .apel-info h5 {
        margin: 0 0 5px;

        color: #4f3d0e;

        font-size: 14px;
        font-weight: 800;
    }

    .apel-info p {
        margin: 0;

        color: #66572f;

        font-size: 13px;
        font-weight: 500;
        line-height: 1.6;
    }

    /* =========================================================
       ACTION
       ========================================================= */

    .action-area {
        margin-top: 30px;
        padding-top: 25px;

        border-top: 1px solid #eeeeee;
    }

    .action-header {
        margin-bottom: 15px;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .action-title {
        color: #171717;

        font-size: 16px;
        font-weight: 800;
    }

    .action-description {
        color: #666666;

        font-size: 13px;
        font-weight: 500;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .btn-laporan {
        min-height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        border: none !important;
        border-radius: 10px !important;

        font-size: 14px !important;
        font-weight: 800 !important;

        transition: .2s ease;
    }

    .btn-laporan:hover {
        transform: translateY(-2px);

        box-shadow: 0 7px 17px rgba(0,0,0,.14);
    }

    .btn-icon {
        font-size: 21px !important;
    }

    /* =========================================================
       PDF - MERAH
       ========================================================= */

    .btn-pdf {
        background: #b5121b !important;
        color: #fff !important;
    }

    .btn-pdf:hover {
        background: #850c13 !important;
        color: #fff !important;
    }

    /* =========================================================
       DOC - HITAM
       ========================================================= */

    .btn-doc {
        background: #171717 !important;
        color: #fff !important;
    }

    .btn-doc:hover {
        background: #000 !important;
        color: #fff !important;
    }

    /* =========================================================
       WHATSAPP - GOLD
       ========================================================= */

    .btn-wa {
        background: #c7a54a !important;
        color: #171717 !important;
    }

    .btn-wa:hover {
        background: #b49338 !important;
        color: #171717 !important;
    }

    /* =========================================================
       NOTE
       ========================================================= */

    .laporan-note {
        margin-top: 18px;
        padding: 13px 15px;

        border-radius: 9px;

        background: #f1f2f4;
        color: #666666;

        font-size: 12px;
        font-weight: 500;
        line-height: 1.5;

        text-align: center;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1000px) {

        .laporan-hero {
            margin-top: -80px;
        }

        .hero-decoration {
            right: 30px;
        }

        .filter-box {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 800px) {

        .laporan-hero {
            margin-top: -60px;
            min-height: 300px;
            padding: 110px 35px 45px;
        }

        .laporan-hero h2 {
            font-size: 34px;
        }

        .hero-decoration {
            display: none;
        }

        .status-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .action-buttons {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {

        .laporan-hero {
            width: calc(100% + 4px);
            margin-left: -2px;
            margin-top: -40px;

            min-height: 250px;
            padding: 90px 25px 40px;

            border-radius: 0 0 16px 16px;
        }

        .laporan-hero h2 {
            font-size: 30px;
        }

        .laporan-hero p {
            font-size: 14px !important;
        }

        .laporan-form-body {
            padding: 20px;
        }

        .laporan-section-header {
            padding: 18px 20px;
        }

        .laporan-section-header h4 {
            font-size: 18px !important;
        }

        .laporan-section-header p {
            font-size: 13px !important;
        }

        .section-badge {
            display: none;
        }

        .status-grid {
            grid-template-columns: 1fr;
        }

        .filter-box {
            padding: 18px;
        }

        .filter-description p {
            font-size: 13px !important;
        }

        .status-name {
            font-size: 13px !important;
        }

        .status-desc {
            font-size: 12px !important;
        }
    }
</style>


<div class="content">

    <div class="container-fluid laporan-page">

        <!-- =====================================================
             HERO
             ===================================================== -->

        <div class="laporan-hero">

            <div class="laporan-hero-content">

                <div class="laporan-eyebrow">
                    <i class="material-icons">assessment</i>
                    BID TIK POLDA JAWA TIMUR
                </div>

                <h2>
                    Generate Laporan
                </h2>

                <p>
                    Rekapitulasi dan pelaporan data kehadiran personel
                    Bidang Teknologi Informasi dan Komunikasi.
                </p>

            </div>

            <div class="hero-decoration">
                <i class="material-icons">description</i>
            </div>

        </div>


        <!-- =====================================================
             FLASH MESSAGE
             ===================================================== -->

        <?php if (session()->getFlashdata('msg')): ?>

            <div class="mb-3">

                <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?> laporan-alert">

                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                    >
                        <i class="material-icons">close</i>
                    </button>

                    <?= session()->getFlashdata('msg') ?>

                </div>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             MAIN CARD
             ===================================================== -->

        <div class="laporan-main-card">

            <div class="laporan-section-header">

                <div class="section-header-left">

                    <div class="section-header-icon">
                        <i class="material-icons">description</i>
                    </div>

                    <div>

                        <h4>
                            Laporan Kehadiran Personel
                        </h4>

                        <p>
                            Tentukan tanggal laporan yang ingin ditampilkan.
                        </p>

                    </div>

                </div>

                <div class="section-badge">
                    BID TIK
                </div>

            </div>


            <form
                action="<?= base_url('admin/laporan/generate'); ?>"
                method="post"
                id="formLaporan"
            >

                <?= csrf_field() ?>

                <div class="laporan-form-body">

                    <!-- =================================================
                         FILTER TANGGAL
                         ================================================= -->

                    <div class="filter-box">

                        <div class="filter-description">

                            <div class="filter-icon">
                                <i class="material-icons">
                                    calendar_month
                                </i>
                            </div>

                            <div>

                                <h5>
                                    Periode Laporan
                                </h5>

                                <p>
                                    Pilih tanggal untuk menentukan data kehadiran
                                    yang akan ditampilkan pada laporan.
                                </p>

                            </div>

                        </div>


                        <div>

                            <label
                                for="tanggal"
                                class="filter-label"
                            >
                                TANGGAL LAPORAN
                            </label>

                            <div class="date-input-wrapper">

                                <i class="material-icons">
                                    calendar_today
                                </i>

                                <input
                                    type="date"
                                    name="tanggal"
                                    id="tanggal"
                                    class="form-control date-input"
                                    value="<?= date('Y-m-d'); ?>"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         STATUS ABSENSI
                         ================================================= -->

                    <div class="status-section">

                        <div class="status-section-title">

                            <h5>
                                Status Absensi dalam Laporan
                            </h5>

                            <span>
                                9 kategori
                            </span>

                        </div>


                        <div class="status-grid">

                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        check_circle
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">HADIR</p>
                                    <p class="status-desc">
                                        Personel hadir
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        work
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">DINAS</p>
                                    <p class="status-desc">
                                        Sedang menjalankan dinas
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        directions_run
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">
                                        LEPAS DINAS
                                    </p>
                                    <p class="status-desc">
                                        Personel lepas dinas
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        beach_access
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">CUTI</p>
                                    <p class="status-desc">
                                        Personel sedang cuti
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        healing
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">SAKIT</p>
                                    <p class="status-desc">
                                        Personel sedang sakit
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        description
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">IZIN</p>
                                    <p class="status-desc">
                                        Personel mendapatkan izin
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        schedule
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">
                                        TERLAMBAT
                                    </p>
                                    <p class="status-desc">
                                        Personel datang terlambat
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        school
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">DIK</p>
                                    <p class="status-desc">
                                        Personel dalam pendidikan
                                    </p>
                                </div>
                            </div>


                            <div class="status-card">
                                <div class="status-icon">
                                    <i class="material-icons">
                                        military_tech
                                    </i>
                                </div>

                                <div>
                                    <p class="status-name">BKO</p>
                                    <p class="status-desc">
                                        Personel BKO
                                    </p>
                                </div>
                            </div>

                        </div>


                        <!-- =================================================
                             POIN APEL
                             ================================================= -->

                        <div class="apel-info">

                            <div class="apel-icon">
                                <i class="material-icons">
                                    military_tech
                                </i>
                            </div>

                            <div>

                                <h5>
                                    Poin Apel
                                </h5>

                                <p>
                                    Data poin apel akan menjadi bagian dari laporan
                                    bersama rekapitulasi kehadiran personel.
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         ACTION
                         ================================================= -->

                    <div class="action-area">

                        <div class="action-header">

                            <div class="action-title">
                                Pilihan Laporan
                            </div>

                            <div class="action-description">
                                Pilih format atau kirim laporan
                            </div>

                        </div>


                        <div class="action-buttons">

                            <!-- PDF -->
                            <button
                                type="submit"
                                name="type"
                                value="pdf"
                                class="btn btn-laporan btn-pdf"
                            >
                                <i class="material-icons btn-icon">
                                    picture_as_pdf
                                </i>

                                <span>
                                    Generate PDF
                                </span>
                            </button>


                            <!-- DOC -->
                            <button
                                type="submit"
                                name="type"
                                value="doc"
                                class="btn btn-laporan btn-doc"
                            >
                                <i class="material-icons btn-icon">
                                    description
                                </i>

                                <span>
                                    Generate DOC
                                </span>
                            </button>


                            <!-- WHATSAPP -->
                            <button
                                type="submit"
                                formaction="<?= base_url('admin/laporan/kirim-wa'); ?>"
                                name="type"
                                value="whatsapp"
                                class="btn btn-laporan btn-wa"
                                onclick="return konfirmasiWhatsApp();"
                            >
                                <i class="material-icons btn-icon">
                                    send
                                </i>

                                <span>
                                    Kirim WhatsApp
                                </span>
                            </button>

                        </div>

                    </div>


                    <!-- =================================================
                         NOTE
                         ================================================= -->

                    <div class="laporan-note">

                        Laporan dibuat berdasarkan data kehadiran personel
                        pada tanggal yang dipilih.

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
    function konfirmasiWhatsApp() {

        const tanggal = document.getElementById('tanggal').value;

        if (!tanggal) {

            alert(
                'Silakan pilih tanggal laporan terlebih dahulu.'
            );

            return false;
        }

        return confirm(
            'Kirim rekap laporan kehadiran melalui WhatsApp untuk tanggal ' +
            tanggal +
            '?'
        );
    }
</script>


<?= $this->endSection() ?>