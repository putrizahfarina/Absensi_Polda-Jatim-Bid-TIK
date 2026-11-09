<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content'); ?>
<!-- CDN FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Reset CSS dasar & Font */
    .personel-page-wrapper {
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        color: #1e293b;
        padding: 16px;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Modal Z-Index fix */
    .modal {
        z-index: 1060 !important;
    }
    .modal-backdrop {
        z-index: 1050 !important;
    }


    .user-superadmin-header .user-text {
        color: #ef4444; /* Warna merah */
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-superadmin-header .grid-icon {
        color: #64748b;
        font-size: 16px;
        cursor: pointer;
    }

    /* Header Banner khas Absensi Bid TIK */
    .header-banner-tik {
        background: linear-gradient(135deg, #7f1d1d 0%, #450a0a 100%);
        border-radius: 14px;
        padding: 24px;
        color: #ffffff;
        margin-top: 40px;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px -5px rgba(127, 29, 29, 0.4);
        position: relative;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .header-banner-tik::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .badge-subsystem {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #fca5a5;
        margin-bottom: 8px;
    }

    .badge-subsystem::before {
        content: '';
        width: 6px;
        height: 6px;
        background-color: #ef4444;
        border-radius: 50%;
    }

    /* Kartu Utama Berwarna Putih */
    .main-card-white {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        width: 100%;
        box-sizing: border-box;
    }

    /* Input & Filter Controls */
    .custom-input-light {
        width: 100%;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px;
        padding: 8px 12px 8px 36px;
        color: #0f172a !important;
        font-size: 13px;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .custom-input-light:focus {
        border-color: #991b1b !important;
        box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1);
    }

    .custom-select-light {
        width: 100%;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px;
        padding: 8px 12px;
        color: #0f172a !important;
        font-size: 13px;
        outline: none;
        cursor: pointer;
        box-sizing: border-box;
    }

    /* Tabel Light Mode */
    .table-container-responsive {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-personel-light {
        width: 100%;
        border-collapse: collapse;
        color: #334155;
        table-layout: fixed; 
    }

    .table-personel-light thead th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 12px 10px;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        word-wrap: break-word;
    }

    .table-personel-light tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-personel-light tbody tr:nth-child(even) { background-color: #f8fafc; }
    .table-personel-light tbody tr:hover { background-color: #f1f5f9 !important; }

    .table-personel-light tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        font-size: 0.82rem;
        border-bottom: 1px solid #e2e8f0;
        word-wrap: break-word; 
        overflow: hidden;
    }

    /* Custom Badges */
    .badge-subbid {
        background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
        padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 600;
        display: inline-block; max-width: 100%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;
    }

    .badge-ur {
        background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;
        padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 600;
        display: inline-block; max-width: 100%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;
    }

    .btn-action-icon {
        background: #f1f5f9; border: 1px solid #cbd5e1; cursor: pointer;
        padding: 5px 7px; border-radius: 6px; font-size: 12px; display: inline-flex;
        align-items: center; justify-content: center;
    }

    /* Tombol Paginasi */
    .page-btn-custom {
        min-width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.85rem; font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;
        background: #ffffff; color: #475569; transition: all 0.2s; cursor: pointer;
    }
    .page-btn-custom:hover:not(.disabled) { background: #f1f5f9; color: #0f172a; }
    .page-btn-custom.active { background: #991b1b; color: #ffffff; border-color: #991b1b; }
    .page-btn-custom.disabled { opacity: 0.5; cursor: not-allowed; }
</style>

<div class="personel-page-wrapper">


    <!-- HEADER BANNER MERAH MARUN -->
    <div class="header-banner-tik">
        <!-- Struktur Flexbox Column (Atas-Bawah) -->
        <div style="display: flex; flex-direction: column; gap: 20px; position: relative; z-index: 2;">
            
            <!-- Bagian Teks Judul (ATAS) -->
            <div>
                <div class="badge-subsystem">Sistem Informasi Bidang TIK</div>
                <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 0 0 4px 0; letter-spacing: -0.5px;">
                    Data Personel Bid TIK
                </h1>
                <p style="color: #fca5a5; font-size: 13px; margin: 0;">
                    Kelola database personel dan QR Code                                                          
                </p>
            </div>
            
            <!-- Bagian Tombol Aksi (BAWAH) -->
            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                <a href="<?= base_url('admin/data-personel/cetak-qr'); ?>" 
                   style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff; padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fas fa-qrcode"></i> Cetak QR
                </a>

                <button type="button" 
                        class="btn btn-light text-dark font-weight-bold px-3 py-2" 
                        style="border-radius: 8px; font-size: 12px; background-color: #9ca3af; color: #1f2937; text-transform: uppercase; cursor: pointer; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                        data-toggle="modal" data-target="#modalTambahPersonel"
                        data-bs-toggle="modal" data-bs-target="#modalTambahPersonel">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>

                <button type="button"
                        class="btn btn-danger font-weight-bold px-3 py-2"
                        style="border-radius: 8px; font-size: 12px; text-transform: uppercase; cursor: pointer; background-color: #dc2626; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                        data-toggle="modal" data-target="#modalImportPersonel"
                        data-bs-toggle="modal" data-bs-target="#modalImportPersonel">
                    <i class="fas fa-file-import mr-1"></i> Import Excel
                </button>

                <a href="<?= base_url('admin/data-personel/export'); ?>" 
                   class="btn btn-success font-weight-bold px-3 py-2" 
                   style="border-radius: 8px; font-size: 12px; text-transform: uppercase; text-decoration: none; color: white; background-color: #10b981; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fas fa-file-export mr-1"></i> Export Excel
                </a>

                <button type="button" 
                        class="btn btn-outline-light font-weight-bold px-3 py-2" 
                        style="border-radius: 8px; font-size: 12px; background-color: #a3a3a3; color: white; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                        data-toggle="modal" data-target="#modalDataSampah"
                        data-bs-toggle="modal" data-bs-target="#modalDataSampah">
                    <i class="fas fa-trash-arrow-up mr-1"></i> Data Terhapus
                </button>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI FLASH MESSAGE -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
            <div style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-check-circle" style="font-size: 16px; color: #10b981;"></i><span><?= session()->getFlashdata('success'); ?></span></div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 16px; line-height: 1;">&times;</button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
            <div style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-exclamation-circle" style="font-size: 16px; color: #ef4444;"></i><span><?= session()->getFlashdata('error'); ?></span></div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 16px; line-height: 1;">&times;</button>
        </div>
    <?php endif; ?>

    <!-- MAIN CONTAINER CARD -->
    <div class="main-card-white">
        
        <!-- BARIS PENCARIAN & FILTER -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; gap: 10px; flex: 1; max-width: 500px;">
                <div style="position: relative; flex: 1;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px;"></i>
                    <input type="text" id="searchInput" class="custom-input-light" placeholder="Cari nama / NRP...">
                </div>

                <div style="width: 150px;">
                    <select id="urFilterSelect" class="custom-select-light">
                        <option value="">Semua UR</option>
                        <option value="URMINTU">URMINTU</option>
                        <option value="URREN">URREN</option>
                        <option value="URKEU">URKEU</option>
                        <option value="URPULLAHTA">URPULLAHTA</option>
                        <option value="URINTI">URINTI</option>
                        <option value="URYANDUKNIS">URYANDUKNIS</option>
                        <option value="URJARKOM">URJARKOM</option>
                        <option value="URYANKOM">URYANKOM</option>
                        <option value="URHARKAN">URHARKAN</option>
                    </select>
                </div>
            </div>

            <div style="color: #64748b; font-size: 13px; font-weight: 500;">
                Total <strong id="totalPersonel" style="color: #0f172a;"><?= count($personel ?? []); ?></strong> personel
            </div>
        </div>

        <!-- TABEL DATA PERSONEL (PAS DENGAN UKURAN KARTU) -->
        <div class="table-container-responsive">
            <table class="table-personel-light">
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">NO</th>
                        <th style="width: 30%; text-align: center;">NAMA</th>
                        <th style="width: 15%; text-align: center;">PANGKAT</th>
                        <th style="width: 15%; text-align: center;">NRP</th>
                        <th style="width: 14%; text-align: center;">SUBBID</th>
                        <th style="width: 11%; text-align: center;">UR</th>
                        <th style="width: 10%; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($personel)): ?>
                        <?php $no = 1; foreach ($personel as $p): ?>
                            <tr class="personel-row-item" data-ur="<?= esc($p['ur'] ?? $p['satker'] ?? ''); ?>">
                                <td class="nomor-urut" style="color: #94a3b8; font-weight: 500; text-align: center;"><?= $no++; ?></td>
                                <td class="nama-val" style="font-weight: 700; color: #0f172a;"><?= esc($p['nama']); ?></td>
                                <td class="pangkat-val" style="color: #64748b; font-weight: 500;">
                                    <?= esc(trim(str_replace('/', '', $p['pangkat']))); ?>
                                </td>
                                <td class="nrp-val" style="font-weight: 700; color: #334155;"><?= esc($p['nrp_nip']); ?></td>
                                <td><span class="badge-subbid"><?= esc($p['subbid'] ?? '—'); ?></span></td>
                                <td><span class="badge-ur"><?= esc($p['ur'] ?? $p['satker'] ?? '—'); ?></span></td>
                                <td style="text-align: center;">
                                    <div style="display: flex; justify-content: center; align-items: center; gap: 6px;">
                                        <button type="button" class="btn-action-icon" style="color: #475569;"
                                                data-toggle="modal" data-target="#modalQR<?= $p['id']; ?>" 
                                                data-bs-toggle="modal" data-bs-target="#modalQR<?= $p['id']; ?>" title="Lihat QR Code">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon" style="color: #2563eb;"
                                                data-toggle="modal" data-target="#modalEdit<?= $p['id']; ?>" 
                                                data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['id']; ?>" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon" style="color: #ef4444; background: #fef2f2; border-color: #fecaca;"
                                                onclick="konfirmasiHapus('<?= base_url('admin/data-personel/delete/' . $p['id']) ?>', '<?= esc($p['nama']) ?>')" title="Hapus Data">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr id="noMatchRow" style="display: none;">
                            <td colspan="7" style="text-align: center; color: #64748b; padding: 30px; font-size: 13px;">
                                <i class="fas fa-search-minus mb-2" style="font-size: 20px; display: block; color: #cbd5e1;"></i>
                                Tidak ada data personel yang cocok dengan pencarian Anda.
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align: center; color: #64748b; padding: 30px; font-size: 13px;">Belum ada data personel terdaftar</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- CONTAINER TOMBOL PAGINASI -->
        <div class="d-flex justify-content-end align-items-center mt-3" style="width: 100%;">
            <div id="paginationButtons" style="display: flex; gap: 4px; flex-wrap: wrap;"></div>
        </div>

    </div>
</div>

<!-- ================== SEMUA MODAL ================== -->

<!-- CONTAINER MODAL EDIT & QR -->
<?php if (!empty($personel)): ?>
    <?php foreach ($personel as $p): ?>
        <!-- MODAL QR CODE -->
        <div class="modal fade" id="modalQR<?= $p['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 360px;">
                <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15); background-color: #ffffff; text-align: center;">
                    <div class="modal-header border-0 pt-4 px-4 pb-0 justify-content-between">
                        <h5 class="modal-title font-weight-bold" style="font-size: 18px; color: #0f172a !important; margin: 0;">QR Code Personel</h5>
                        <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-4 py-3">
                        <?php if (!empty($p['qr_code']) && file_exists(FCPATH . $p['qr_code'])) : ?>
                            <img src="<?= base_url($p['qr_code']); ?>" alt="QR Code" style="max-width: 170px; width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; padding: 8px;">
                        <?php else : ?>
                            <div style="padding: 20px; background: #f8fafc; border-radius: 8px; color: #64748b; font-size: 13px;">QR Code belum tersedia</div>
                        <?php endif; ?>
                        <h6 style="font-weight: 700; color: #0f172a; margin-top: 12px; margin-bottom: 2px; font-size: 15px;"><?= esc($p['nama']); ?></h6>
                        <p style="color: #64748b; font-size: 13px; margin: 0;">NRP: <?= esc($p['nrp_nip']); ?></p>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 justify-content-center">
                        <?php if (!empty($p['qr_code']) && file_exists(FCPATH . $p['qr_code'])) : ?>
                            <a href="<?= base_url($p['qr_code']); ?>" download="QR_<?= esc($p['nrp_nip']); ?>.png" class="btn px-4 py-2 font-weight-bold w-100" style="border-radius: 8px; font-size: 13px; background-color: #991b1b; border: none; color: #ffffff; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-download"></i> Unduh QR
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL EDIT PERSONEL -->
        <div class="modal fade" id="modalEdit<?= $p['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 550px;">
                <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15); background-color: #ffffff;">
                    <div class="modal-header border-0 pt-4 px-4 pb-2" style="background: #ffffff; position: relative;">
                        <div>
                            <h5 class="modal-title font-weight-bold" style="font-size: 18px; color: #0f172a !important; margin: 0;">Edit Personel</h5>
                            <p class="text-muted mb-0" style="font-size: 12px; color: #64748b !important;">Perbarui data personel</p>
                        </div>
                        <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px; font-size: 24px; border: none; background: transparent; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('admin/data-personel/update/' . $p['id']); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="modal-body px-4 py-3" style="background: #ffffff; text-align: left;">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">NRP</label>
                                <input type="text" name="nrp_nip" class="form-control px-3 py-2" value="<?= esc($p['nrp_nip']); ?>" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control px-3 py-2" value="<?= esc($p['nama']); ?>" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                            </div>
                            <div style="display: flex; gap: 10px;" class="mb-3">
                                <div style="flex: 1;">
                                    <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">Pangkat</label>
                                    <select name="pangkat" class="form-control px-3" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; height: 38px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                        <?php 
                                            $pangkats = ['BRIPDA', 'BRIPTU', 'BRIPKA', 'AIPDA', 'AIPTU', 'IPDA', 'IPTU', 'AKP', 'KOMPOL', 'AKBP', 'KOMBES POL', 'PEMBINA', 'PENATA', 'PENATA TK. I', 'PENGATUR', 'PENGATUR TK. I', 'PPPK'];
                                            foreach($pangkats as $pkt):
                                        ?>
                                            <option value="<?= $pkt; ?>" <?= ($p['pangkat'] == $pkt) ? 'selected' : ''; ?>><?= $pkt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">Subbid</label>
                                    <select name="subbid" class="form-control px-3" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; height: 38px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                        <option value="" disabled <?= empty($p['subbid']) ? 'selected' : ''; ?>>Pilih Subbid</option>
                                        <?php 
                                            $subbids = ['KABID TIK', 'KASUBBIDTEKKOM', 'KASUBBIDTEKINFO', 'KASUBBAGRENMIN', 'SUBBAGRENMIN', 'SUBBIDTEKINFO', 'SUBBIDTEKKOM'];
                                            foreach($subbids as $sb):
                                        ?>
                                            <option value="<?= $sb; ?>" <?= (($p['subbid'] ?? '') == $sb) ? 'selected' : ''; ?>><?= $sb; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">UR</label>
                                    <select name="ur" class="form-control px-3" style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; height: 38px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                        <option value="" disabled <?= empty($p['ur']) && empty($p['satker']) ? 'selected' : ''; ?>>Pilih UR</option>
                                        <?php 
                                            $urs = ['URMINTU', 'URREN', 'URKEU', 'URPULLAHTA', 'URINTI', 'URYANDUKNIS', 'URJARKOM', 'URYANKOM', 'URHARKAN'];
                                            $currentUr = $p['ur'] ?? $p['satker'] ?? '';
                                            foreach($urs as $u):
                                        ?>
                                            <option value="<?= $u; ?>" <?= ($currentUr == $u) ? 'selected' : ''; ?>><?= $u; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background: #ffffff; display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" class="btn px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 12px; border: 1px solid #cbd5e1; color: #334155; background: #ffffff;">
                                Batal
                            </button>
                            <button type="submit" class="btn px-4 py-2 font-weight-bold" style="border-radius: 8px; font-size: 12px; background-color: #991b1b; border: none; color: #ffffff;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- MODAL DAFTAR DATA TERHAPUS -->
<div class="modal fade" id="modalDataSampah" tabindex="-1" aria-hidden="true" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="display: flex; align-items: center; min-height: calc(100vh - 3.5rem); margin: auto;">
        <div class="modal-content w-100" style="border-radius: 16px; border: none; background-color: #ffffff; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pt-4 px-4 pb-2 justify-content-between">
                <div>
                    <h5 class="modal-title font-weight-bold" style="font-size: 18px; color: #0f172a;">Data Personel Tersembunyi / Terhapus</h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">Klik tombol pulihkan untuk menampilkan kembali data ke tabel utama.</p>
                </div>
                <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="table-responsive px-4">
                <table class="table align-middle" style="width: 100%;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-size: 11px; font-weight: 700;">
                            <th class="py-2" style="width: 80px;">NRP</th>
                            <th class="py-2">NAMA</th>
                            <th class="py-2">PANGKAT</th>
                            <th class="py-2">SUBBID</th>
                            <th class="py-2">UR</th>
                            <th class="py-2 text-end" style="text-align: right;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $personelTerhapus = (new \App\Models\PersonelModel())->onlyDeleted()->findAll();
                        if (!empty($personelTerhapus)): 
                            foreach ($personelTerhapus as $pt): 
                        ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="font-weight-bold py-3" style="color: #0f172a; font-size: 13px;"><?= esc($pt['nrp_nip']); ?></td>
                                <td style="color: #0f172a; font-weight: 600; font-size: 13px;"><?= esc($pt['nama']); ?></td>
                                <td style="color: #64748b; font-size: 13px;"><?= esc($pt['pangkat']); ?></td>
                                <td><span class="badge bg-light text-dark border px-2 py-1" style="font-size: 10px; text-transform: uppercase; border-radius: 4px;"><?= esc($pt['subbid'] ?? '—'); ?></span></td>
                                <td><span class="badge bg-secondary px-2 py-1" style="font-size: 10px; text-transform: uppercase; border-radius: 4px;"><?= esc($pt['ur'] ?? $pt['satker'] ?? '—'); ?></span></td>
                                <td style="text-align: right;" class="py-3">
                                    <button type="button" class="btn btn-sm btn-success px-3 py-1 btn-pulihkan-data" 
                                            data-url="<?= base_url('admin/data-personel/restore/' . $pt['id']); ?>" data-nama="<?= esc($pt['nama'] ?? ''); ?>"
                                            style="border-radius: 6px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; border: none; cursor: pointer;">
                                        <i class="fas fa-rotate-left"></i> Pulihkan
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="6" class="text-center text-muted py-4" style="font-size: 13px;">Tidak ada data yang sedang disembunyikan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-2">
                <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 12px;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PERSONEL -->
<div class="modal fade" id="modalTambahPersonel" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15); background-color: #ffffff;">
            <div class="modal-header border-0 pt-4 px-4 pb-2" style="background: #ffffff; position: relative;">
                <div>
                    <h5 class="modal-title font-weight-bold" id="modalTambahLabel" style="font-size: 18px; color: #0f172a !important; margin: 0;">Tambah Personel</h5>
                    <p class="text-muted mb-0" style="font-size: 12px; color: #64748b !important;">Isi data personel baru</p>
                </div>
                <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px; font-size: 24px; border: none; background: transparent; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/data-personel/store') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body px-4 py-3" style="background: #ffffff;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">NRP</label>
                        <input type="text" name="nrp_nip" class="form-control px-3 py-2" placeholder="Contoh: 12345678" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control px-3 py-2" placeholder="Contoh: Bripda Andi Pratama" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                    </div>
                    <div style="display: flex; gap: 10px;" class="mb-3">
                        <div style="flex: 1;">
                            <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">Pangkat</label>
                            <select name="pangkat" class="form-control px-3" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; height: 38px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                <option value="" disabled selected>Pilih Pangkat</option>
                                <option value="BRIPDA">BRIPDA</option>
                                <option value="BRIPTU">BRIPTU</option>
                                <option value="BRIPKA">BRIPKA</option>
                                <option value="AIPDA">AIPDA</option>
                                <option value="AIPTU">AIPTU</option>
                                <option value="IPDA">IPDA</option>
                                <option value="IPTU">IPTU</option>
                                <option value="KOMPOL">KOMPOL</option>
                                <option value="AKBP">AKBP</option>
                                <option value="KOMBES POL">KOMBES POL</option>
                                <option value="PEMBINA">PEMBINA</option>
                                <option value="PENATA">PENATA</option>
                                <option value="PENATA TK. I">PENATA TK. I</option>
                                <option value="PENGATUR">PENGATUR</option>
                                <option value="PENGATUR TK. I">PENGATUR TK. I</option>
                                <option value="PPPK">PPPK</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">Subbid</label>
                            <select name="subbid" class="form-control px-3" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; height: 38px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                <option value="" disabled selected>Pilih Subbid</option>
                                <option value="SUBBIDTEKKOM">KABID TIK</option>
                                <option value="SUBBIDTEKKOM">KASUBBIDTEKKOM</option>
                                <option value="SUBBIDTEKKOM">KASUBBIDTEKINFO</option>
                                <option value="SUBBIDTEKKOM">KASUBBAGRENMIN</option>
                                <option value="SUBBIDTEKKOM">SUBBIDTEKKOM</option>
                                <option value="SUBBIDTEKINFO">SUBBIDTEKINFO</option>
                                <option value="SUBBAGRENMIN">SUBBAGRENMIN</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label class="font-weight-bold mb-1" style="font-size: 12px; color: #0f172a !important; display: block;">UR</label>
                            <select name="ur" class="form-control px-3" style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; height: 38px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                <option value="" disabled selected>Pilih UR</option>
                                <option value="URMINTU">URMINTU</option>
                                <option value="URREN">URREN</option>
                                <option value="URKEU">URKEU</option>
                                <option value="URPULLAHTA">URPULLAHTA</option>
                                <option value="URINTI">URINTI</option>
                                <option value="URYANDUKNIS">URYANDUKNIS</option>
                                <option value="URJARKOM">URJARKOM</option>
                                <option value="URYANKOM">URYANKOM</option>
                                <option value="URHARKAN">URHARKAN</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background: #ffffff; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 12px; border: 1px solid #cbd5e1; color: #334155; background: #ffffff;">Batal</button>
                    <button type="submit" class="btn px-4 py-2 font-weight-bold" style="border-radius: 8px; font-size: 12px; background-color: #991b1b; border: none; color: #ffffff;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL IMPORT EXCEL -->
<div class="modal fade" id="modalImportPersonel" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 480px;">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15); background-color: #ffffff;">
            <div class="modal-header border-0 pt-4 px-4 pb-2" style="background: #ffffff; position: relative;">
                <div>
                    <h5 class="modal-title font-weight-bold" id="modalImportLabel" style="font-size: 18px; color: #0f172a; margin: 0;">Import Data Personel</h5>
                    <p class="text-muted mb-0" style="font-size: 12px; color: #64748b;">Tambahkan banyak data personel melalui Excel</p>
                </div>
                <button type="button" class="close text-dark" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px; font-size: 24px; border: none; background: transparent; cursor: pointer;">&times;</button>
            </div>
            <form id="formImportPersonel" action="<?= base_url('admin/data-personel/import'); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body px-4 py-3" style="background: #ffffff;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-2" style="font-size: 12px; color: #0f172a; display: block;">Pilih File Excel</label>
                        <input type="file" name="file_excel" id="file_excel" accept=".xlsx,.xls,.csv" required style="display: none;">
                        <label for="file_excel" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px 16px; background-color: #f1f5f9; border: 2px dashed #cbd5e1; border-radius: 8px; color: #334155; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-sizing: border-box;" onmouseover="this.style.borderColor='#991b1b'; this.style.backgroundColor='#e2e8f0';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.backgroundColor='#f1f5f9';">
                            <i class="fas fa-file-excel" style="color: #10b981; font-size: 15px;"></i><span>PILIH FILE EXCEL</span>
                        </label>
                        <div id="fileInfoBox" style="display: none; margin-top: 10px; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 12px; color: #0f172a; align-items: center; justify-content: space-between;">
                            <span style="display: flex; align-items: center; gap: 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1;">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i><strong id="namaFileExcel">Belum ada file.</strong>
                            </span>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span id="ukuranFileExcel" style="color: #64748b; font-size: 11px;"></span>
                                <button type="button" id="btnBatalFile" style="background: transparent; border: none; color: #ef4444; cursor: pointer; padding: 0; outline: none;" title="Batal pilih file"><i class="fas fa-times-circle" style="font-size: 14px;"></i></button>
                            </div>
                        </div>
                    </div>
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 10px 12px; border-radius: 8px;">
                        <p style="font-size: 11px; color: #1e40af; font-weight: 700; margin-bottom: 4px;"><i class="fas fa-info-circle"></i> Format Kolom Excel</p>
                        <p style="font-size: 11px; color: #1e3a8a; margin: 0; line-height: 1.6;">NAMA | PANGKAT | NRP/NIP | JABATAN</p>
                    </div>
                    <p class="mt-3 mb-0" style="font-size: 11px; color: #64748b;">Format file yang diterima: .xlsx, .xls, atau .csv.</p>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background: #ffffff; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 12px; border: 1px solid #cbd5e1; color: #334155; background: #ffffff;">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 py-2 font-weight-bold" style="border-radius: 8px; font-size: 12px; background-color: #dc2626; border: none;"><i class="fas fa-file-import mr-1"></i> Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Library SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined') {
        $(document).on('show.bs.modal', '.modal', function () { $(this).appendTo('body'); });
    } else {
        document.addEventListener('show.bs.modal', function (e) { document.body.appendChild(e.target); });
    }

    // --- LOGIKA FILTER DAN PAGINASI CLIENT-SIDE --- //
    const searchInput = document.getElementById('searchInput');
    const urFilterSelect = document.getElementById('urFilterSelect');
    const tableRows = Array.from(document.querySelectorAll('.personel-row-item'));
    const totalCountElem = document.getElementById('totalPersonel');
    const noMatchRow = document.getElementById('noMatchRow');
    const paginationButtons = document.getElementById('paginationButtons');

    const rowsPerPage = 15;
    let currentPage = 1;
    let currentFilteredData = [...tableRows];

    function renderTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedUR = urFilterSelect ? urFilterSelect.value.toLowerCase().trim() : '';

        currentFilteredData = [];

        tableRows.forEach(row => {
            const nrpText = row.querySelector('.nrp-val') ? row.querySelector('.nrp-val').textContent.toLowerCase() : '';
            const namaText = row.querySelector('.nama-val') ? row.querySelector('.nama-val').textContent.toLowerCase() : '';
            const urText = (row.getAttribute('data-ur') || '').toLowerCase();

            const matchesSearch = nrpText.includes(searchTerm) || namaText.includes(searchTerm);
            const matchesUR = selectedUR === '' || urText === selectedUR || urText.includes(selectedUR);

            if (matchesSearch && matchesUR) {
                currentFilteredData.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        if (totalCountElem) { totalCountElem.textContent = currentFilteredData.length; }

        if (noMatchRow) {
            noMatchRow.style.display = (currentFilteredData.length === 0 && tableRows.length > 0) ? '' : 'none';
        }

        const totalPages = Math.ceil(currentFilteredData.length / rowsPerPage);
        if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
        if (currentPage === 0 && totalPages > 0) currentPage = 1;

        displayTablePage();
    }

    function displayTablePage() {
        currentFilteredData.forEach(row => row.style.display = 'none');

        if (currentFilteredData.length === 0) {
            renderPaginationControls();
            return;
        }

        const startIdx = (currentPage - 1) * rowsPerPage;
        const endIdx = startIdx + rowsPerPage;
        const pageData = currentFilteredData.slice(startIdx, endIdx);

        let number = startIdx + 1;
        pageData.forEach(row => {
            row.style.display = '';
            const tdNo = row.querySelector('.nomor-urut');
            if(tdNo) tdNo.textContent = number;
            number++;
        });

        renderPaginationControls();
    }

    function renderPaginationControls() {
        if(!paginationButtons) return;
        paginationButtons.innerHTML = '';
        
        const totalRows = currentFilteredData.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        if(totalPages <= 1) return;

        // Tombol Previous
        const prevBtn = document.createElement('button');
        prevBtn.className = `page-btn-custom ${currentPage === 1 ? 'disabled' : ''}`;
        prevBtn.type = 'button';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prevBtn.onclick = () => { if(currentPage > 1) { currentPage--; displayTablePage(); } };
        paginationButtons.appendChild(prevBtn);

        // Deret Angka Halaman
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) { startPage = Math.max(1, endPage - 4); }

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.className = `page-btn-custom ${i === currentPage ? 'active' : ''}`;
            btn.type = 'button';
            btn.innerText = i;
            btn.onclick = () => { currentPage = i; displayTablePage(); };
            paginationButtons.appendChild(btn);
        }

        // Tombol Next
        const nextBtn = document.createElement('button');
        nextBtn.className = `page-btn-custom ${currentPage === totalPages ? 'disabled' : ''}`;
        nextBtn.type = 'button';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        nextBtn.onclick = () => { if(currentPage < totalPages) { currentPage++; displayTablePage(); } };
        paginationButtons.appendChild(nextBtn);
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1; 
            renderTable();
        });
    }
    if (urFilterSelect) {
        urFilterSelect.addEventListener('change', () => {
            currentPage = 1;
            renderTable();
        });
    }

    renderTable();


    // INPUT EXCEL FILE UPLOAD LOGIC
    const inputExcel = document.getElementById('file_excel');
    const namaFileExcel = document.getElementById('namaFileExcel');
    const ukuranFileExcel = document.getElementById('ukuranFileExcel');
    const fileInfoBox = document.getElementById('fileInfoBox');
    const formImport = document.getElementById('formImportPersonel');
    const btnBatalFile = document.getElementById('btnBatalFile');

    if (inputExcel) {
        inputExcel.addEventListener('change', function () {
            const file = this.files && this.files[0];
            
            if (!file) {
                if (fileInfoBox) fileInfoBox.style.display = 'none';
                return;
            }

            const allowedExtensions = ['xlsx', 'xls', 'csv'];
            const extension = file.name.split('.').pop().toLowerCase();
            
            if (!allowedExtensions.includes(extension)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Sesuai', text: 'Silakan pilih file Excel .xlsx, .xls, atau .csv.' });
                this.value = '';
                if (fileInfoBox) fileInfoBox.style.display = 'none';
                return;
            }

            let fileSize = (file.size / 1024).toFixed(1) + ' KB';
            if (file.size > 1024 * 1024) fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';

            if (namaFileExcel) namaFileExcel.textContent = file.name;
            if (ukuranFileExcel) ukuranFileExcel.textContent = '(' + fileSize + ')';
            if (fileInfoBox) fileInfoBox.style.display = 'flex';
        });
    }

    if (btnBatalFile && inputExcel) {
        btnBatalFile.addEventListener('click', function () {
            inputExcel.value = '';
            if (fileInfoBox) fileInfoBox.style.display = 'none';
        });
    }

    if (formImport) {
        formImport.addEventListener('submit', function (e) {
            if (!inputExcel || !inputExcel.files || inputExcel.files.length === 0) {
                e.preventDefault();
                Swal.fire({ icon: 'warning', title: 'File Belum Dipilih', text: 'Silakan klik tombol PILIH FILE EXCEL terlebih dahulu.' });
            }
        });
    }

    document.querySelectorAll('.btn-pulihkan-data').forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            const nama = this.getAttribute('data-nama');

            Swal.fire({
                title: 'Pulihkan Data?', text: `Apakah Anda yakin ingin memulihkan data ${nama}?`,
                icon: 'question', showCancelButton: true, confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b', confirmButtonText: 'Ya, Pulihkan!', cancelButtonText: 'Batal'
            }).then((result) => { if (result.isConfirmed) { window.location.href = url; } });
        });
    });
});

function konfirmasiHapus(url, nama) {
    Swal.fire({
        title: 'Hapus Data?', text: `Apakah Anda yakin ingin menghapus data ${nama}?`,
        icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
    }).then((result) => { if (result.isConfirmed) { window.location.href = url; } });
}
</script>

<?= $this->endSection(); ?>