<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 600px;">
        <h3 class="mb-3">Import Data Personel</h3>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('admin/data-personel/import') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="file_excel" class="form-label">Upload File CSV</label>
                <input class="form-control" type="file" id="file_excel" name="file_excel" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-success">Unggah Data</button>
            <a href="<?= base_url('admin/data-personel') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>