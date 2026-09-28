<?= $this->extend('templates/starting_page_layout') ?>

<?= $this->section('content') ?>

<style>
    .main-panel{
        min-height:100vh;
        display:flex;
        align-items:center;
    }

    .content,
    .container-fluid{
        width:100%;
    }

    .cek-card{
        border:none;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 18px 40px rgba(0,0,0,.25);
    }

    .cek-header{
        background:#111111;
        color:#fff;
        padding:24px 28px;
    }

    .cek-header h4{
        margin:0;
        font-size:22px;
        font-weight:700;
    }

    .cek-header p{
        margin:6px 0 0;
        color:#d1d5db;
        font-size:14px;
    }

    .card-body{
        padding:28px;
    }

    .btn-riwayat{
        background:#111111 !important;
        color:#fff !important;
        border:none !important;
        border-radius:10px;
        font-weight:700;
        height:48px;
    }

    .btn-riwayat:hover{
        background:#000 !important;
    }

    .btn-kembali{
        background:#fff !important;
        color:#111 !important;
        border:2px solid #111 !important;
        border-radius:10px;
        font-weight:700;
        height:48px;
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none !important;
    }

    .btn-kembali:hover{
        background:#111 !important;
        color:#fff !important;
    }
</style>

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9 col-sm-12">

                    <div class="card cek-card">

                        <div class="cek-header">
                            <h4>Portal Cek Kehadiran</h4>
                            <p>Masukkan NIS dan Nomor HP orang tua untuk melihat riwayat</p>
                        </div>

                        <div class="card-body">

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('cek-kehadiran/view') ?>" method="post">

                                <?= csrf_field() ?>

                                <div class="form-group">
                                    <label>NIS Siswa</label>
                                    <input type="text"
                                           name="nis"
                                           class="form-control"
                                           required
                                           value="<?= old('nis') ?>">
                                </div>

                                <div class="form-group mt-4">
                                    <label>Nomor HP Orang Tua (Terdaftar)</label>
                                    <input type="text"
                                           name="no_hp"
                                           class="form-control"
                                           required
                                           value="<?= old('no_hp') ?>">

                                    <small class="text-muted">
                                        Gunakan nomor yang sama dengan yang menerima notifikasi WA.
                                    </small>
                                </div>

                                <button type="submit"
                                        class="btn btn-block btn-riwayat mt-4">
                                    Lihat Riwayat
                                </button>

                                <a href="<?= base_url() ?>"
                                   class="btn btn-block btn-kembali mt-2">
                                    Kembali
                                </a>

                            </form>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>