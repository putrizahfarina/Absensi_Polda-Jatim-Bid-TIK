<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content'); ?>
<!-- CDN FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Style Perbaikan Z-Index Modal & Placeholder -->
<style>
    #searchInput::placeholder {
        color: #ffffff !important;
        opacity: 0.9; 
    }
    .modal {
        z-index: 1060 !important;
    }
    .modal-backdrop {
        z-index: 1050 !important;
    }
</style>

<!-- Container Utama -->
<div style="position: relative; padding: 10px 24px 40px 24px; margin-top: 50px; font-family: 'Segoe UI', Roboto, sans-serif; color: #e2e8f0; box-sizing: border-box;">

    <!-- Judul Halaman & Tombol Aksi -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #ffffff; margin: 0 0 6px 0; letter-spacing: -0.5px;">Data Personel</h1>
            <p style="color: #94a3b8; font-size: 14px; margin: 0;"><span id="totalPersonel" style="color: #ffffff; font-weight: 600;"><?= count($personel ?? []); ?></span> personel terdaftar</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="<?= base_url('admin/data-personel/cetak-qr'); ?>" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 9px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-qrcode"></i> CETAK QR
            </a>
            
            <button type="button" 
                    class="btn btn-light text-dark font-weight-bold px-4 py-2" 
                    style="border-radius: 8px; font-size: 13px; text-transform: uppercase; cursor: pointer;"
                    data-toggle="modal" 
                    data-target="#modalTambahPersonel"
                    data-bs-toggle="modal" 
                    data-bs-target="#modalTambahPersonel">
                <i class="fas fa-plus mr-1"></i> Tambah
            </button>

            <button type="button" 
                    class="btn btn-outline-warning font-weight-bold px-3 py-2" 
                    style="border-radius: 8px; font-size: 13px;"
                    data-toggle="modal" 
                    data-target="#modalDataSampah"
                    data-bs-toggle="modal" 
                    data-bs-target="#modalDataSampah">
                <i class="fas fa-trash-arrow-up mr-1"></i> Data Terhapus
            </button>
        </div>
    </div>

    <!-- Notifikasi / Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle" style="font-size: 18px;"></i>
                <span><?= session()->getFlashdata('success'); ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #34d399; cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
                <span><?= session()->getFlashdata('error'); ?></span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #f87171; cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Filter & Pencarian -->
    <div style="background: linear-gradient(to right, #0b0f19 0%, #4c0519 60%, #881337 100%); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px; position: relative; display: flex; align-items: center;">
                <i class="fas fa-search" style="position: absolute; left: 14px; color: #94a3b8; font-size: 14px; pointer-events: none;"></i>
                <input type="text" id="searchInput" placeholder="Cari nama / NRP..." style="width: 100%; background: rgba(15, 23, 42, 0.7) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; border-radius: 6px; padding: 10px 14px 10px 38px; color: #ffffff !important; font-size: 13px; outline: none; box-sizing: border-box;">
            </div>
            <div style="width: 200px;">
                <select id="urFilterSelect" style="width: 100%; background: #0f172a !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; border-radius: 6px; padding: 10px 14px; color: #ffffff !important; font-size: 13px; outline: none; cursor: pointer; box-sizing: border-box;">
                    <option value="">Semua UR</option>
                    <option value="URMINTU">URMINTU</option>
                    <option value="URRES">URRES</option>
                    <option value="URSABHARA">URSABHARA</option>
                    <option value="BID TIK">BID TIK</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background: rgba(30, 41, 59, 0.9); border-bottom: 1px solid rgba(245, 244, 244, 0.1);">
                        <th style="padding: 14px 20px; color: #ffffff; font-size: 12px; font-weight: 600; width: 60px;">NO</th>
                        <th style="padding: 14px 20px; color: #ffffff; font-size: 12px; font-weight: 600;">NRP</th>
                        <th style="padding: 14px 20px; color: #ffffff; font-size: 12px; font-weight: 600;">NAMA</th>
                        <th style="padding: 14px 20px; color: #ffffff; font-size: 12px; font-weight: 600;">PANGKAT</th>
                        <th style="padding: 14px 20px; color: #ffffff; font-size: 12px; font-weight: 600;">UR</th>
                        <th style="padding: 14px 20px; color: #ffffff; font-size: 12px; font-weight: 600; text-align: right;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($personel)): ?>
                        <?php $no = 1; foreach ($personel as $p): ?>
                            <tr class="personel-row-item" data-ur="<?= esc($p['satker'] ?? ''); ?>" style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                                <td style="padding: 16px 20px; color: #64748b;"><?= $no++; ?></td>
                                <td class="nrp-val" style="padding: 16px 20px; color: #ffffff; font-weight: 600;"><?= esc($p['nrp_nip']); ?></td>
                                <td class="nama-val" style="padding: 16px 20px; color: #ffffff; font-weight: 600;"><?= esc($p['nama']); ?></td>
                                <td class="pangkat-val" style="padding: 16px 20px; color: #94a3b8;"><?= esc($p['pangkat']); ?></td>
                                <td style="padding: 16px 20px;">
                                    <span style="background: rgba(255, 255, 255, 0.1); color: #e2e8f0; border: 1px solid rgba(255,255,255,0.15); padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                        <?= esc($p['satker'] ?? 'URMINTU'); ?>
                                    </span>
                                </td>
                                <td style="padding: 16px 20px; text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 14px;">
                                        <button type="button" 
                                                style="background: transparent; border: none; color: #94a3b8; cursor: pointer; padding: 0; font-size: 16px; outline: none;" 
                                                data-toggle="modal" 
                                                data-target="#modalQR<?= $p['id']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalQR<?= $p['id']; ?>" 
                                                title="Lihat QR Code">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>

                                        <button type="button" 
                                                style="background: transparent; border: none; color: #94a3b8; cursor: pointer; padding: 0; font-size: 16px; outline: none;" 
                                                data-toggle="modal" 
                                                data-target="#modalEdit<?= $p['id']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEdit<?= $p['id']; ?>" 
                                                title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <button type="button" 
                                                onclick="konfirmasiHapus('<?= base_url('admin/data-personel/delete/' . $p['id']) ?>', '<?= esc($p['nama']) ?>')"
                                                style="background: transparent; border: none; color: #ef4444; cursor: pointer; padding: 0; font-size: 16px; outline: none;" 
                                                title="Hapus Data">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr id="noMatchRow" style="display: none;">
                            <td colspan="6" style="text-align: center; color: #64748b; padding: 48px; font-size: 14px;">
                                <i class="fas fa-search-minus mb-2" style="font-size: 24px; display: block; color: #475569;"></i>
                                Tidak ada data personel yang cocok dengan kata kunci atau filter Anda.
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #64748b; padding: 48px; font-size: 14px;">Belum ada data personel terdaftar</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= CONTAINER MODAL EDIT & QR ================= -->
<?php if (!empty($personel)): ?>
    <?php foreach ($personel as $p): ?>
        <!-- MODAL LIHAT QR CODE -->
        <div class="modal fade" id="modalQR<?= $p['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 380px;">
                <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); background-color: #ffffff; text-align: center;">
                    <div class="modal-header border-0 pt-4 px-4 pb-0 justify-content-between">
                        <h5 class="modal-title font-weight-bold" style="font-size: 18px; color: #0f172a !important; margin: 0;">QR Code Personel</h5>
                        <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 24px; border: none; background: transparent; outline: none; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-4 py-3">
                        <?php if (!empty($p['qr_code']) && file_exists(FCPATH . $p['qr_code'])) : ?>
                            <img src="<?= base_url($p['qr_code']); ?>" alt="QR Code" style="max-width: 180px; width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; padding: 8px;">
                        <?php else : ?>
                            <div style="padding: 20px; background: #f8fafc; border-radius: 8px; color: #64748b; font-size: 13px;">QR Code belum tersedia</div>
                        <?php endif; ?>
                        <h6 style="font-weight: 700; color: #0f172a; margin-top: 14px; margin-bottom: 2px; font-size: 16px;"><?= esc($p['nama']); ?></h6>
                        <p style="color: #64748b; font-size: 13px; margin: 0;">NRP: <?= esc($p['nrp_nip']); ?></p>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 justify-content-center">
                        <?php if (!empty($p['qr_code']) && file_exists(FCPATH . $p['qr_code'])) : ?>
                            <a href="<?= base_url($p['qr_code']); ?>" download="QR_<?= esc($p['nrp_nip']); ?>.png" class="btn px-4 py-2 font-weight-bold w-100" style="border-radius: 8px; font-size: 13px; background-color: #0f172a; border: none; color: #ffffff; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-download"></i> Unduh QR
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL EDIT PERSONEL -->
        <div class="modal fade" id="modalEdit<?= $p['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
                <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); background-color: #ffffff;">
                    <div class="modal-header border-0 pt-4 px-4 pb-2" style="background: #ffffff; position: relative;">
                        <div>
                            <h5 class="modal-title font-weight-bold" style="font-size: 20px; color: #0f172a !important; margin: 0;">Edit Personel</h5>
                            <p class="text-muted mb-0" style="font-size: 13px; color: #64748b !important;">Perbarui data personel</p>
                        </div>
                        <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px; font-size: 24px; border: none; background: transparent; outline: none; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('admin/data-personel/update/' . $p['id']); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="modal-body px-4 py-3" style="background: #ffffff; text-align: left;">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">NRP</label>
                                <input type="text" name="nrp_nip" class="form-control px-3 py-2" value="<?= esc($p['nrp_nip']); ?>" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control px-3 py-2" value="<?= esc($p['nama']); ?>" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                            </div>
                            <div style="display: flex; gap: 12px;" class="mb-3">
                                <div style="flex: 1;">
                                    <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">Pangkat</label>
                                    <select name="pangkat" class="form-control px-3" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; height: 42px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                        <?php 
                                            $pangkats = ['BRIPDA', 'BRIPTU', 'BRIPKA', 'AIPDA', 'AIPTU', 'IPDA', 'IPTU', 'AKP', 'KOMPOL', 'AKBP', 'KOMBES POL'];
                                            foreach($pangkats as $pkt):
                                        ?>
                                            <option value="<?= $pkt; ?>" <?= ($p['pangkat'] == $pkt) ? 'selected' : ''; ?>><?= $pkt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">UR</label>
                                    <input type="text" name="satker" class="form-control px-3 py-2" value="<?= esc($p['satker']); ?>" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background: #ffffff; display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" class="btn px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13px; border: 1px solid #cbd5e1; color: #334155; background: #ffffff;">
                                Batal
                            </button>
                            <button type="submit" class="btn px-4 py-2 font-weight-bold" style="border-radius: 8px; font-size: 13px; background-color: #0f172a; border: none; color: #ffffff;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- MODAL DAFTAR DATA TERHAPUS / RECYCLE BIN -->
<div class="modal fade" id="modalDataSampah" tabindex="-1" aria-hidden="true" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="display: flex; align-items: center; min-height: calc(100vh - 3.5rem); margin: auto;">
        <div class="modal-content w-100" style="border-radius: 16px; border: none; background-color: #ffffff; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            
            <div class="modal-header border-0 pt-4 px-4 pb-2 justify-content-between">
                <div>
                    <h5 class="modal-title font-weight-bold" style="font-size: 20px; color: #0f172a;">Data Personel Tersembunyi / Terhapus</h5>
                    <p class="text-muted mb-0" style="font-size: 13px;">Klik tombol pulihkan untuk menampilkan kembali data ke tabel utama.</p>
                </div>
                <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 24px; border: none; background: transparent; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body px-4 py-3">
                <div style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-hover align-middle" style="font-size: 14px; width: 100%;">
                        <thead>
                            <tr style="background: #f8fafc; color: #64748b;">
                                <th>NRP</th>
                                <th>NAMA</th>
                                <th>PANGKAT</th>
                                <th>UR</th>
                                <th style="text-align: right;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $personelTerhapus = (new \App\Models\PersonelModel())->onlyDeleted()->findAll();
                            if (!empty($personelTerhapus)): 
                                foreach ($personelTerhapus as $pt): 
                            ?>
                                <tr>
                                    <td class="font-weight-bold" style="color: #0f172a;"><?= esc($pt['nrp_nip']); ?></td>
                                    <td style="color: #0f172a;"><?= esc($pt['nama']); ?></td>
                                    <td style="color: #64748b;"><?= esc($pt['pangkat']); ?></td>
                                    <td>
                                        <span class="badge bg-secondary px-2 py-1" style="font-size: 11px; text-transform: uppercase; border-radius: 4px;">
                                            <?= esc($pt['ur'] ?? $pt['ur_nama'] ?? $pt['satker'] ?? '-'); ?>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <button type="button" 
                                                class="btn btn-sm btn-success px-3 py-1 btn-pulihkan-data" 
                                                data-url="<?= base_url('admin/data-personel/restore/' . $pt['id']); ?>" 
                                                data-nama="<?= esc($pt['nama'] ?? ''); ?>"
                                                style="border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; border: none; cursor: pointer;">
                                            <i class="fas fa-rotate-left"></i> Pulihkan
                                        </button>
                                    </td>
                                </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Tidak ada data yang sedang disembunyikan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer border-0 px-4 pb-4 pt-2">
                <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL TAMBAH PERSONEL ================= -->
<div class="modal fade" id="modalTambahPersonel" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); background-color: #ffffff;">
            <div class="modal-header border-0 pt-4 px-4 pb-2" style="background: #ffffff; position: relative;">
                <div>
                    <h5 class="modal-title font-weight-bold" id="modalTambahLabel" style="font-size: 20px; color: #0f172a !important; margin: 0;">Tambah Personel</h5>
                    <p class="text-muted mb-0" style="font-size: 13px; color: #64748b !important;">Isi data personel baru</p>
                </div>
                <button type="button" class="close text-dark opacity-50" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px; font-size: 24px; border: none; background: transparent; outline: none; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url('admin/data-personel/store') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body px-4 py-3" style="background: #ffffff;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">NRP</label>
                        <input type="text" name="nrp_nip" class="form-control px-3 py-2" placeholder="Contoh: 12345678" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control px-3 py-2" placeholder="Contoh: Bripda Andi Pratama" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                    </div>

                    <div style="display: flex; gap: 12px;" class="mb-3">
                        <div style="flex: 1;">
                            <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">Pangkat</label>
                            <select name="pangkat" class="form-control px-3" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; height: 42px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                                <option value="" disabled selected>Pilih Pangkat</option>
                                <option value="BRIPDA">BRIPDA</option>
                                <option value="BRIPTU">BRIPTU</option>
                                <option value="BRIPKA">BRIPKA</option>
                                <option value="AIPDA">AIPDA</option>
                                <option value="AIPTU">AIPTU</option>
                                <option value="IPDA">IPDA</option>
                                <option value="IPTU">IPTU</option>
                                <option value="AKP">AKP</option>
                                <option value="KOMPOL">KOMPOL</option>
                                <option value="AKBP">AKBP</option>
                                <option value="KOMBES POL">KOMBES POL</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label class="font-weight-bold mb-1" style="font-size: 13px; color: #0f172a !important; display: block;">UR</label>
                            <input type="text" name="satker" class="form-control px-3 py-2" placeholder="Contoh: URMINTU" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; color: #0f172a !important; background: #ffffff !important; width: 100%; box-sizing: border-box;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background: #ffffff; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn px-4 py-2 font-weight-bold" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13px; border: 1px solid #cbd5e1; color: #334155; background: #ffffff;">
                        Batal
                    </button>
                    <button type="submit" class="btn px-4 py-2 font-weight-bold" style="border-radius: 8px; font-size: 13px; background-color: #0f172a; border: none; color: #ffffff;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Library SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Memindahkan semua modal ke <body> secara otomatis saat dibuka agar tidak tertutup backdrop
    if (typeof $ !== 'undefined') {
        $(document).on('show.bs.modal', '.modal', function () {
            $(this).appendTo('body');
        });
    } else {
        document.addEventListener('show.bs.modal', function (e) {
            document.body.appendChild(e.target);
        });
    }

    // Filter & Search
    const searchInput = document.getElementById('searchInput');
    const urFilterSelect = document.getElementById('urFilterSelect');
    const tableRows = document.querySelectorAll('.personel-row-item');
    const totalCountElem = document.getElementById('totalPersonel');
    const noMatchRow = document.getElementById('noMatchRow');

    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedUR = urFilterSelect ? urFilterSelect.value.toLowerCase().trim() : '';
        let visibleCount = 0;

        tableRows.forEach(row => {
            const nrpText = row.querySelector('.nrp-val') ? row.querySelector('.nrp-val').textContent.toLowerCase() : '';
            const namaText = row.querySelector('.nama-val') ? row.querySelector('.nama-val').textContent.toLowerCase() : '';
            const urText = (row.getAttribute('data-ur') || '').toLowerCase();

            const matchesSearch = nrpText.includes(searchTerm) || namaText.includes(searchTerm);
            const matchesUR = selectedUR === '' || urText === selectedUR || urText.includes(selectedUR);

            if (matchesSearch && matchesUR) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (totalCountElem) {
            totalCountElem.textContent = visibleCount;
        }

        if (noMatchRow) {
            noMatchRow.style.display = (visibleCount === 0 && tableRows.length > 0) ? '' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    if (urFilterSelect) {
        urFilterSelect.addEventListener('change', filterTable);
    }

    // Event listener untuk tombol Pulihkan Data Sampah
    document.querySelectorAll('.btn-pulihkan-data').forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            const nama = this.getAttribute('data-nama');

            Swal.fire({
                title: 'Pulihkan Data?',
                text: `Apakah Anda yakin ingin memulihkan data ${nama}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Pulihkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
});

// Function konfirmasi hapus data
function konfirmasiHapus(url, nama) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Apakah Anda yakin ingin menghapus data ${nama}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

<?= $this->endSection(); ?>