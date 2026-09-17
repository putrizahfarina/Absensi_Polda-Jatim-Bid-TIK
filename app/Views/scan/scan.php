<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Pemindai QR - Bid TIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-dark text-white text-center p-5">
    <div class="container" style="max-width: 500px;">
        <h2>Sistem Absensi Bid TIK</h2>
        <p class="text-muted">Arahkan QR Code atau ketik NRP / NIP di bawah ini</p>

        <form id="formScan" class="my-4">
            <input type="text" id="nrp_nip" name="nrp_nip" class="form-control form-control-lg text-center" placeholder="Masukkan NRP / NIP" autofocus required>
        </form>

        <div id="alertResult"></div>
    </div>

    <script>
        $('#formScan').on('submit', function(e) {
            e.preventDefault();
            let nrp = $('#nrp_nip').val();

            $.post('<?= base_url('scan/proses') ?>', { nrp_nip: nrp }, function(response) {
                let alertClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
                if(response.status === 'warning') alertClass = 'alert-warning';

                $('#alertResult').html('<div class="alert ' + alertClass + '">' + response.message + '</div>');
                $('#nrp_nip').val('').focus();
            });
        });
    </script>
</body>
</html>