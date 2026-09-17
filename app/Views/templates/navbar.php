<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">

    <div class="container-fluid">

        <!-- Spacer agar navbar tidak menabrak dashboard -->
        <div class="navbar-wrapper">
            <span class="navbar-spacer"></span>
        </div>

        <!-- Toggle Mobile -->
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navigation-index"
            aria-controls="navigation-index"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>

        </button>

        <!-- Menu kanan -->
        <div
            class="collapse navbar-collapse justify-content-end"
            id="navigation-index">

            <ul class="navbar-nav">

                <!-- ==============================
                     MENU SCAN
                     ============================== -->
                <li class="nav-item dropdown">

                    <a
                        class="nav-link"
                        href="javascript:;"
                        id="navbarDropdownScan"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                        <i class="material-icons">qr_code</i>

                        <p class="d-lg-none d-md-block">
                            Scan
                        </p>

                    </a>

                    <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="navbarDropdownScan">

                        <a
                            class="dropdown-item"
                            href="<?= base_url('scan/masuk'); ?>">
                            Absen masuk
                        </a>

                        <a
                            class="dropdown-item"
                            href="<?= base_url('scan/pulang'); ?>">
                            Absen pulang
                        </a>

                    </div>

                </li>


                <!-- ==============================
                     MENU ACCOUNT
                     ============================== -->
                <li class="nav-item dropdown">

                    <a
                        class="nav-link <?= is_superadmin() ? 'text-danger' : ''; ?>"
                        href="javascript:;"
                        id="navbarDropdownProfile"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                        <i class="material-icons">person</i>

                        <p class="d-lg-none d-md-block">
                            Account
                        </p>

                        <span>
                            User : <?= user()->username; ?>
                        </span>

                    </a>


                    <!-- Dropdown Account -->
                    <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="navbarDropdownProfile">

                        <a
                            class="dropdown-item"
                            href="#">
                            Email: <?= user()->email; ?>
                        </a>


                        <div class="dropdown-item">

                            <div>Role:</div>

                            <?php foreach (user()->getGroups() ?? [] as $g): ?>

                                <?php
                                $badge = match ($g) {
                                    'superadmin' => 'danger',
                                    'admin'      => 'success',
                                    'kepsek'     => 'warning',
                                    'scanner'    => 'info',
                                    'guru'       => 'secondary',
                                    default      => 'secondary',
                                };
                                ?>

                                <span
                                    class="h6 badge badge-<?= $badge ?> text-capitalize mx-1 my-auto">

                                    <?= getUserRole($g) ?>

                                </span>

                            <?php endforeach; ?>


                            <?php if (is_wali_kelas()): ?>

                                <span
                                    class="h6 badge badge-primary text-capitalize mx-1 my-auto">

                                    Wali Kelas

                                </span>

                            <?php endif; ?>

                        </div>


                        <div class="dropdown-divider"></div>


                        <!-- Logout -->
                        <a
                            class="dropdown-item"
                            href="<?= base_url('/logout'); ?>">

                            Log Out

                        </a>

                    </div>

                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- ==========================================
     STYLE NAVBAR
     ========================================== -->
<style>

    /* ------------------------------------------
       Navbar utama
       ------------------------------------------ */

    .navbar.fixed-top {
        min-height: 70px !important;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }


    /* ------------------------------------------
       Hilangkan judul default dari template
       Dashboard akan menggunakan judul custom
       ------------------------------------------ */

    .navbar-wrapper {
        min-height: 55px !important;
    }


    .navbar-spacer {
        display: block;
        width: 180px;
        height: 50px;
    }


    /* ------------------------------------------
       Menu kanan
       ------------------------------------------ */

    .navbar .navbar-nav {
        display: flex;
        align-items: center;
    }


    .navbar .navbar-nav .nav-item {
        margin-top: 8px;
    }


    /* ------------------------------------------
       Ikon
       ------------------------------------------ */

    .navbar .material-icons {
        position: relative;
        top: 2px;
        font-size: 24px;
    }


    /* ------------------------------------------
       Tulisan User
       ------------------------------------------ */

    .navbar .navbar-nav .nav-link span {
        position: relative;
        top: 2px;
    }


    /* ------------------------------------------
       Link navbar
       ------------------------------------------ */

    .navbar .navbar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 5px;
    }


    /* ------------------------------------------
       Dashboard tidak tertutup navbar
       ------------------------------------------ */

    .main-panel {
        padding-top: 15px !important;
    }


    /* ------------------------------------------
       Dropdown
       ------------------------------------------ */

    .navbar .dropdown-menu {
        margin-top: 8px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }


    .navbar .dropdown-item {
        padding: 10px 18px;
    }


    .navbar .dropdown-item:hover {
        background-color: #f5f5f5;
    }


    /* ------------------------------------------
       Mobile
       ------------------------------------------ */

    @media (max-width: 991px) {

        .navbar-wrapper {
            min-height: 45px !important;
        }

        .navbar-spacer {
            width: 100px;
            height: 40px;
        }

        .navbar .navbar-nav .nav-item {
            margin-top: 0;
        }

    }

</style>

<!-- End Navbar -->