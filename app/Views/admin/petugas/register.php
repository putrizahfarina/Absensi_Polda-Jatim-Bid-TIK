
<?php
// Cari role Super Admin dari daftar role yang tersedia
$superAdminRoleValue = '';

foreach ($roles as $role) {
    if (strtolower(trim($role->label())) === 'super admin') {
        $superAdminRoleValue = $role->value;
        break;
    }
}
?>

<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header card-header-info mb-48">
                        <h4 class="card-title">
                            <?= lang('Auth.register') ?>
                        </h4>
                        <p class="card-category">
                            Buat akun petugas
                        </p>
                    </div>

                    <div class="card-body mx-5 my-3">

                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <form action="<?= base_url('admin/petugas/register') ?>"
                              method="post">

                            <?= csrf_field() ?>

                            <!-- EMAIL -->
                            <div class="form-group mt-4">
                                <label for="email">
                                    <?= lang('Auth.email') ?>
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                                    name="email"
                                    placeholder="example@email.com"
                                    value="<?= esc(old('email')) ?>"
                                    required
                                >

                                <?php if (session('errors.email')) : ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.email')) ?>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- USERNAME -->
                            <div class="form-group mt-4">
                                <label for="username">
                                    <?= lang('Auth.username') ?>
                                </label>

                                <input
                                    type="text"
                                    id="username"
                                    class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                                    name="username"
                                    placeholder="yourusername"
                                    value="<?= esc(old('username')) ?>"
                                    required
                                >

                                <?php if (session('errors.username')) : ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.username')) ?>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- PASSWORD -->
                            <div class="form-group mt-4">
                                <label for="password">
                                    <?= lang('Auth.password') ?>
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                                    autocomplete="new-password"
                                    required
                                >

                                <?php if (session('errors.password')) : ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.password')) ?>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- KONFIRMASI PASSWORD -->
                            <div class="form-group mt-4">
                                <label for="pass_confirm">
                                    <?= lang('Auth.passwordConfirm') ?>
                                </label>

                                <input
                                    type="password"
                                    id="pass_confirm"
                                    name="pass_confirm"
                                    class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>"
                                    autocomplete="new-password"
                                    required
                                >

                                <?php if (session('errors.pass_confirm')) : ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.pass_confirm')) ?>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- ROLE SUPER ADMIN -->
                            <div class="form-group mt-4">
                                <label>Role</label>

                                <?php if ($superAdminRoleValue !== '') : ?>

                                    <input
                                        type="hidden"
                                        name="role"
                                        value="<?= esc($superAdminRoleValue) ?>"
                                    >

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="Super Admin"
                                        readonly
                                    >

                                <?php else : ?>

                                    <div class="alert alert-danger">
                                        Role Super Admin tidak ditemukan.
                                        Periksa konfigurasi role pada sistem.
                                    </div>

                                <?php endif ?>

                                <?php if (session('errors.role')) : ?>
                                    <div class="text-danger">
                                        <?= esc(session('errors.role')) ?>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- TOMBOL REGISTER -->
                            <button
                                type="submit"
                                class="btn btn-info btn-block mt-4"
                                <?= $superAdminRoleValue === '' ? 'disabled' : '' ?>
                            >
                                <?= lang('Auth.register') ?>
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
