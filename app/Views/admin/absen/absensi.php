<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content'); ?>

<!-- CSS Absensi -->

<link rel="stylesheet" href="<?= base_url('assets/css/absensi.css') ?>">

<div class="absensi-wrapper">

```
<form action="<?= base_url('admin/absensi/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <!-- =====================================================
         1. INPUT ABSENSI PERSONEL
         ===================================================== -->
    <div class="card-custom">

        <div class="card-title-custom">
            <i class="material-icons" style="color: #fde047;">list_alt</i>
            Input Absensi Personel
        </div>

        <div class="table-responsive-custom">

            <table class="table-custom">

                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">
                            No
                        </th>

                        <th style="width: 25%;">
                            Nama & NRP
                        </th>

                        <th style="width: 20%;">
                            Pangkat & Unit Kerja
                        </th>

                        <th style="width: 50%; text-align: center;">
                            Status Kehadiran
                        </th>
                    </tr>
                </thead>

                <tbody id="tabel_personel_body">

                    <?php
                    $daftar_personel = isset($personel) ? $personel : [];
                    $no = 1;
                    ?>

                    <?php if (empty($daftar_personel)): ?>

                        <tr>
                            <td colspan="4"
                                style="text-align: center; padding: 30px; color: #94a3b8;">

                                Belum ada data personel di database.
                                Silakan tambah data terlebih dahulu.

                            </td>
                        </tr>

                    <?php endif; ?>


                    <?php foreach ($daftar_personel as $p): ?>

                        <?php
                        $id = $p['id'];

                        /*
                         * Status default personel.
                         * Jika belum memiliki status hari ini,
                         * default diarahkan ke HADIR.
                         */
                        $def_status = isset($p['status_hari_ini'])
                            ? strtoupper(trim($p['status_hari_ini']))
                            : 'HADIR';
                        ?>

                        <tr>

                            <!-- Nomor -->
                            <td style="text-align: center; color: #cbd5e1;">
                                <?= $no++ ?>
                            </td>


                            <!-- Nama & NRP -->
                            <td>

                                <strong style="
                                    display: block;
                                    color: #ffffff;
                                    font-size: 14px;
                                ">
                                    <?= esc($p['nama']) ?>
                                </strong>

                                <small style="color: #94a3b8;">
                                    NRP/NIP:
                                    <?= esc($p['nrp_nip']) ?>
                                </small>

                                <input
                                    type="hidden"
                                    name="personel_id[]"
                                    value="<?= $id ?>"
                                >

                            </td>


                            <!-- Pangkat & Satker -->
                            <td>

                                <span style="
                                    display: block;
                                    color: #cbd5e1;
                                    font-weight: 500;
                                    font-size: 13px;
                                ">
                                    <?= esc($p['pangkat']) ?>
                                </span>

                                <span style="
                                    background: rgba(255,255,255,0.1);
                                    padding: 2px 6px;
                                    border-radius: 4px;
                                    font-size: 10px;
                                    font-weight: 600;
                                    color: #94a3b8;
                                    display: inline-block;
                                    margin-top: 2px;
                                ">
                                    <?= esc($p['satker']) ?>
                                </span>

                            </td>


                            <!-- STATUS -->
                            <td>

                                <div class="status-grid-container">

                                    <?php

                                    /*
                                     * 9 STATUS RESMI BID TIK
                                     */
                                    $statuses = [
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

                                    foreach ($statuses as $status):

                                        /*
                                         * Membuat ID radio yang aman
                                         * untuk nama status.
                                         */
                                        $class_suffix = strtolower(
                                            preg_replace(
                                                '/[^a-zA-Z0-9]+/',
                                                '_',
                                                $status
                                            )
                                        );
                                    ?>

                                        <div class="status-item-inline">

                                            <input
                                                type="radio"
                                                name="status[<?= $id ?>]"
                                                id="st_<?= $id ?>_<?= $class_suffix ?>"
                                                value="<?= esc($status) ?>"
                                                <?= $def_status === $status ? 'checked' : '' ?>
                                                onchange="updateRekap()"
                                            >

                                            <label
                                                for="st_<?= $id ?>_<?= $class_suffix ?>"
                                                class="status-btn-sm"
                                            >
                                                <?= esc($status) ?>
                                            </label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- =====================================================
         2. CATATAN / KEGIATAN HARI INI
         ===================================================== -->
    <div
        class="card-custom"
        style="margin-top: 20px;"
    >

        <div class="card-title-custom">

            <i
                class="material-icons"
                style="color: #34d399;"
            >
                event_note
            </i>

            Catatan / Deskripsi Kegiatan Hari Ini

        </div>


        <div class="row">

            <!-- Nama kegiatan -->
            <div class="col-md-6 mb-3">

                <label class="form-label-custom">
                    Nama Kegiatan
                </label>

                <input
                    type="text"
                    name="nama_kegiatan"
                    class="input-custom"
                    placeholder="Contoh: Apel Pagi / Giat Rutin"
                >

            </div>


            <!-- Waktu -->
            <div class="col-md-6 mb-3">

                <label class="form-label-custom">
                    Tanggal & Waktu Input
                </label>

                <input
                    type="text"
                    class="input-custom"
                    value="<?= date('d F Y - H:i') ?> WIB"
                    readonly
                    style="
                        background: rgba(0,0,0,0.2);
                        color: #94a3b8;
                        border-style: dashed;
                    "
                >

            </div>


            <!-- Deskripsi -->
            <div class="col-md-12 mb-2">

                <label class="form-label-custom">
                    Deskripsi / Uraian Kegiatan
                </label>

                <textarea
                    name="deskripsi_kegiatan"
                    rows="4"
                    class="textarea-custom"
                    placeholder="Tuliskan uraian kegiatan secara singkat dan jelas..."
                ></textarea>

            </div>

        </div>

    </div>


    <!-- =====================================================
         3. REKAP ABSENSI HARI INI
         ===================================================== -->
    <div
        class="card-custom"
        style="margin-top: 20px;"
    >

        <div class="card-title-custom">

            <i
                class="material-icons"
                style="color: #c084fc;"
            >
                pie_chart
            </i>

            Rekap Hari Ini

        </div>


        <div class="rekap-grid-bottom">

            <!-- HADIR -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-hadir"></span>
                    Hadir
                </span>

                <strong id="count_hadir">0</strong>
            </div>


            <!-- DINAS -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-dinas"></span>
                    Dinas
                </span>

                <strong id="count_dinas">0</strong>
            </div>


            <!-- LEPAS DINAS -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-lepas"></span>
                    Lepas Dinas
                </span>

                <strong id="count_lepas_dinas">0</strong>
            </div>


            <!-- CUTI -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-cuti"></span>
                    Cuti
                </span>

                <strong id="count_cuti">0</strong>
            </div>


            <!-- SAKIT -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-sakit"></span>
                    Sakit
                </span>

                <strong id="count_sakit">0</strong>
            </div>


            <!-- IZIN -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-izin"></span>
                    Izin
                </span>

                <strong id="count_izin">0</strong>
            </div>


            <!-- TERLAMBAT -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-terlambat"></span>
                    Terlambat
                </span>

                <strong id="count_terlambat">0</strong>
            </div>


            <!-- DIK -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-dik"></span>
                    DIK
                </span>

                <strong id="count_dik">0</strong>
            </div>


            <!-- BKO -->
            <div class="rekap-item-box">
                <span>
                    <span class="dot-indicator dot-bko"></span>
                    BKO
                </span>

                <strong id="count_bko">0</strong>
            </div>

        </div>


        <!-- TOTAL PERSONEL -->
        <div
            class="d-flex justify-content-between align-items-center mb-4 pb-3"
            style="
                border-bottom: 1px dashed rgba(255,255,255,0.15);
                font-weight: 700;
                font-size: 16px;
            "
        >

            <span style="color: #cbd5e1;">
                Total Personel Terdata
            </span>

            <span
                id="count_total"
                style="
                    color: #60a5fa;
                    font-size: 20px;
                "
            >
                0
            </span>

        </div>


        <!-- SIMPAN -->
        <button
            type="submit"
            class="btn-save-all"
        >

            <i class="material-icons">
                save
            </i>

            SIMPAN DATA ABSENSI & KEGIATAN

        </button>

    </div>


    <!-- =====================================================
         4. ABSENSI HARI INI
         ===================================================== -->
    <div
        class="card-custom"
        style="margin-top: 20px;"
    >

        <div
            class="d-flex justify-content-between align-items-center mb-4"
        >

            <div>

                <h5 style="
                    color: #ffffff;
                    margin: 0;
                    font-weight: 700;
                    font-size: 16px;
                ">
                    Absensi Hari Ini
                </h5>

                <small style="color: #94a3b8;">
                    <?= $totalTercatat ?> personel telah dicatat
                </small>

            </div>


            <?php if ($totalBelum > 0): ?>

                <span style="
                    background: rgba(245, 158, 11, 0.15);
                    color: #fbbf24;
                    border: 1px solid rgba(245, 158, 11, 0.3);
                    padding: 6px 14px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                ">

                    <i
                        class="material-icons"
                        style="font-size: 16px;"
                    >
                        error_outline
                    </i>

                    <?= $totalBelum ?> belum absen

                </span>

            <?php else: ?>

                <span style="
                    background: rgba(16, 185, 129, 0.15);
                    color: #34d399;
                    border: 1px solid rgba(16, 185, 129, 0.3);
                    padding: 6px 14px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                ">

                    <i
                        class="material-icons"
                        style="font-size: 16px;"
                    >
                        check_circle_outline
                    </i>

                    Semua sudah absen

                </span>

            <?php endif; ?>

        </div>


        <div class="list-absensi-container">

            <?php if (empty($absensiHariIni)): ?>

                <div style="
                    text-align: center;
                    padding: 25px;
                    color: #94a3b8;
                    background: rgba(0,0,0,0.15);
                    border-radius: 10px;
                    border: 1px dashed rgba(255,255,255,0.1);
                ">
                    Belum ada data absensi yang dicatat hari ini.
                </div>

            <?php else: ?>


                <?php foreach ($absensiHariIni as $absen): ?>

                    <?php

                    $statusText = !empty($absen['status'])
                        ? strtoupper(trim($absen['status']))
                        : 'HADIR';

                    /*
                     * Warna default HADIR
                     */
                    $bgColor = 'rgba(16, 185, 129, 0.15)';
                    $textColor = '#34d399';
                    $borderColor = 'rgba(16, 185, 129, 0.3)';


                    /*
                     * Status perhatian
                     */
                    if (
                        in_array(
                            $statusText,
                            [
                                'IZIN',
                                'SAKIT',
                                'TERLAMBAT',
                                'CUTI'
                            ]
                        )
                    ) {

                        $bgColor = 'rgba(245, 158, 11, 0.15)';
                        $textColor = '#fbbf24';
                        $borderColor = 'rgba(245, 158, 11, 0.3)';
                    }


                    /*
                     * Status non-hadir / khusus
                     */
                    elseif (
                        in_array(
                            $statusText,
                            [
                                'DINAS',
                                'LEPAS DINAS',
                                'DIK',
                                'BKO'
                            ]
                        )
                    ) {

                        $bgColor = 'rgba(239, 68, 68, 0.15)';
                        $textColor = '#f87171';
                        $borderColor = 'rgba(239, 68, 68, 0.3)';
                    }

                    ?>


                    <div
                        class="d-flex justify-content-between align-items-center p-3 mb-2"
                        style="
                            background: rgba(255,255,255,0.03);
                            border: 1px solid rgba(255,255,255,0.08);
                            border-radius: 10px;
                        "
                    >

                        <!-- Identitas -->
                        <div class="d-flex align-items-center gap-3">

                            <div style="
                                width: 40px;
                                height: 40px;
                                border-radius: 50%;
                                background: rgba(255,255,255,0.1);
                                color: #ffffff;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-weight: bold;
                                font-size: 16px;
                            ">
                                <?= strtoupper(substr($absen['nama'], 0, 1)) ?>
                            </div>


                            <div>

                                <strong style="
                                    color: #ffffff;
                                    display: block;
                                    font-size: 14px;
                                ">
                                    <?= esc($absen['nama']) ?>
                                </strong>

                                <small style="color: #94a3b8;">
                                    <?= esc($absen['nrp_nip']) ?>
                                    •
                                    <?= esc($absen['satker']) ?>
                                </small>

                            </div>

                        </div>


                        <!-- Status + Hapus -->
                        <div class="d-flex align-items-center gap-3">

                            <span style="
                                background: <?= $bgColor ?>;
                                color: <?= $textColor ?>;
                                border: 1px solid <?= $borderColor ?>;
                                padding: 4px 12px;
                                border-radius: 15px;
                                font-size: 12px;
                                font-weight: 600;
                            ">

                                • <?= esc($statusText) ?>

                            </span>


                            <a
                                href="<?= base_url('admin/absensi/hapus/' . $absen['id']) ?>"
                                onclick="return confirm('Yakin ingin menghapus data absen ini?')"
                                style="
                                    color: #f87171;
                                    text-decoration: none;
                                    font-size: 13px;
                                    font-weight: 500;
                                "
                            >
                                Hapus
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>

</form>
```

</div>

<!-- JavaScript Absensi -->

<script src="<?= base_url('assets/js/absensi.js') ?>"></script>

<?= $this->endSection(); ?>
