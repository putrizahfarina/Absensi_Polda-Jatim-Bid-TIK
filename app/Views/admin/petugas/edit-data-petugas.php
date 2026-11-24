
<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title">
                            <b>Form Edit Petugas</b>
                        </h4>
                        <p class="card-category">
                            Perbarui informasi akun petugas
                        </p>
                    </div>

                    <div class="card-body mx-5 my-3">

                        <?php
                        $validation = \Config\Services::validation();

                        $username = old('username')
                            ?? ($oldInput['username'] ?? $data['username']);

                        $email = old('email')
                            ?? ($oldInput['email'] ?? $data['email']);
                        ?>

                        <?php if (session()->getFlashdata('msg')): ?>
                            <div class="pb-2">
                                <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
                                    <button type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <?= session()->getFlashdata('msg') ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/petugas/edit') ?>"
                            method="post">

                            <?= csrf_field() ?>

                            <!-- ID PETUGAS -->
                            <input
                                type="hidden"
                                name="id"
                                value="<?= esc($data['id']) ?>"
                            >

                            <!-- USERNAME -->
                            <div class="form-group mt-4">
                                <label for="username">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    id="username"
                                    class="form-control <?= $validation->getError('username') ? 'is-invalid' : '' ?>"
                                    name="username"
                                    placeholder="username123"
                                    value="<?= esc($username) ?>"
                                    required
                                >

                                <div class="invalid-feedback">
                                    <?= $validation->getError('username') ?>
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group mt-4">
                                <label for="email">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    class="form-control <?= $validation->getError('email') ? 'is-invalid' : '' ?>"
                                    name="email"
                                    placeholder="email@example.com"
                                    value="<?= esc($email) ?>"
                                    required
                                >

                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            </div>

                            <!-- PASSWORD BARU -->
                            <div class="form-group mt-4">
                                <label for="password">
                                    Password Baru
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    class="form-control <?= $validation->getError('password') ? 'is-invalid' : '' ?>"
                                    name="password"
                                    placeholder="Masukkan password baru"
                                    autocomplete="new-password"
                                >

                                <small class="form-text text-muted">
                                    Kosongkan jika tidak ingin mengganti password.
                                </small>

                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            </div>

                            <!-- ROLE -->
                            <div class="form-group mt-4">
                                <label for="role">
                                    Role
                                </label>

                                <input
                                    type="text"
                                    id="role"
                                    class="form-control"
                                    value="Super Admin"
                                    readonly
                                >

                                <small class="form-text text-muted">
                                    Role akun ditetapkan sebagai Super Admin.
                                </small>
                            </div>

                            <!-- TOMBOL SIMPAN -->
                            <button
                                type="submit"
                                class="btn btn-primary btn-block mt-4">

                                <i class="material-icons">save</i>
                                Simpan Perubahan

                            </button>

                            <!-- TOMBOL KEMBALI -->
                            <a
                                href="<?= base_url('admin/petugas') ?>"
                                class="btn btn-secondary btn-block">

                                <i class="material-icons">arrow_back</i>
                                Kembali

                            </a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
