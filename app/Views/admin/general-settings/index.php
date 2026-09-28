<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <?= view('admin/_messages'); ?>

                <div class="card">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title"><b>Pengaturan Sistem</b></h4>
                    </div>

                    <div class="card-body mx-5 my-3">

                        <form action="<?= base_url('admin/general-settings/update'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Nama Instansi -->
                            <div class="form-group mt-4">
                                <label for="school_name">Nama Instansi</label>
                                <input type="text"
                                    id="school_name"
                                    class="form-control <?= invalidFeedback('school_name') ? 'is-invalid' : ''; ?>"
                                    name="school_name"
                                    placeholder="Polda Jawa Timur"
                                    value="<?= $generalSettings->school_name; ?>"
                                    required>

                                <div class="invalid-feedback">
                                    <?= invalidFeedback('school_name'); ?>
                                </div>
                            </div>

                            <!-- Bidang -->
                            <div class="form-group mt-4">
                                <label for="school_year">Bidang / Satuan Kerja</label>
                                <input type="text"
                                    id="school_year"
                                    class="form-control <?= invalidFeedback('school_year') ? 'is-invalid' : ''; ?>"
                                    name="school_year"
                                    placeholder="Bid TIK Polda Jawa Timur"
                                    value="<?= $generalSettings->school_year; ?>"
                                    required>

                                <div class="invalid-feedback">
                                    <?= invalidFeedback('school_year'); ?>
                                </div>
                            </div>

                            <!-- Jam Apel -->
                            <div class="form-group mt-4">
                                <label for="jam_masuk_limit">Batas Jam Apel Pagi (Personel dianggap terlambat setelah jam ini)</label>
                                <input type="time"
                                    id="jam_masuk_limit"
                                    class="form-control"
                                    name="jam_masuk_limit"
                                    value="<?= $generalSettings->jam_masuk_limit; ?>"
                                    required>

                                <small class="text-muted">
                                    Format HH:MM. Contoh: 07:15
                                </small>
                            </div>

                            <!-- Jam Pulang -->
                            <div class="form-group mt-4">
                                <label for="jam_pulang_standard">Batas Jam Pulang (Personel dianggap belum absen setelah jam ini)</label>
                                <input type="time"
                                    id="jam_pulang_standard"
                                    class="form-control"
                                    name="jam_pulang_standard"
                                    value="<?= $generalSettings->jam_pulang_standard; ?>"
                                    required>

                                <small class="text-muted">
                                    Format HH:MM. Contoh: 16:00
                                </small>
                            </div>

                            <!-- Hari Dinas -->
                            <div class="form-group mt-4">
                                <label>Hari Dinas</label>

                                <div class="row">
                                    <?php
                                    $hariList = [
                                        '1' => 'Senin',
                                        '2' => 'Selasa',
                                        '3' => 'Rabu',
                                        '4' => 'Kamis',
                                        '5' => "Jumat",
                                        '6' => 'Sabtu',
                                        '7' => 'Minggu'
                                    ];

                                    $hariKerja = !empty($generalSettings->hari_kerja)
                                        ? explode(',', $generalSettings->hari_kerja)
                                        : ['1','2','3','4','5'];

                                    foreach ($hariList as $val => $label):
                                        $checked = in_array($val, $hariKerja) ? 'checked' : '';
                                    ?>

                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="hari_kerja[]"
                                                    value="<?= $val ?>"
                                                    <?= $checked ?>>

                                                <?= $label ?>

                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <?php endforeach; ?>
                                </div>

                                <small class="text-muted">
                                    Pilih hari yang merupakan hari dinas personel.
                                </small>
                            </div>

                            <div class="row">

                                <!-- Nama Aplikasi -->
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <label for="copyright">Nama Aplikasi</label>

                                        <input type="text"
                                            id="copyright"
                                            class="form-control <?= invalidFeedback('copyright') ? 'is-invalid' : ''; ?>"
                                            name="copyright"
                                            placeholder="SIPATIK"
                                            value="<?= $generalSettings->copyright; ?>"
                                            required>

                                        <div class="invalid-feedback">
                                            <?= invalidFeedback('copyright'); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Logo Instansi</label>

                                        <div style="margin-bottom:10px;border:1px solid #eee;padding:10px;width:auto;">
                                            <img id="logo"
                                                src="<?= getLogo(); ?>"
                                                alt="logo"
                                                style="max-width:250px;max-height:250px;">
                                        </div>

                                        <div class="display-block">
                                            <button type="button"
                                                onclick="$('#logo-upload').trigger('click');"
                                                class="btn btn-danger btn-sm btn-file-upload">
                                                Ganti Logo
                                            </button>

                                            <input type="file"
                                                id="logo-upload"
                                                name="logo"
                                                size="40"
                                                accept="image/jpg,image/jpeg,image/png,image/gif,image/svg+xml"
                                                onchange="$('#upload-file-info1').html($(this).val().replace(/.*[\\/\\\\]/,''));">

                                            <span class="text-sm text-secondary">
                                                (.png, .jpg, .jpeg, .gif, .svg)
                                            </span>
                                        </div>

                                        <span class="label label-info" id="upload-file-info1"></span>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-danger btn-block">
                                Simpan Pengaturan
                            </button>

                        </form>

                        <hr>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>