<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= uri_string() === 'scan/pulang'
            ? 'Absensi Pulang - Bid TIK'
            : 'Absensi Pemindai QR - Bid TIK'
        ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Library QR Scanner -->
    <script
        src="https://unpkg.com/html5-qrcode"
        type="text/javascript">
    </script>

    <style>
        body {
            background: #212529;
            color: white;
            min-height: 100vh;
        }

        .scanner-container {
            max-width: 500px;
            margin: 0 auto;
        }

        #reader {
            width: 100%;
            max-width: 450px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .manual-input {
            max-width: 450px;
            margin: 20px auto;
        }

        #alertResult {
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }

        .mode-title {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
</head>

<body class="text-center p-4">

<?php
    // ==========================================
    // CEK MODE ABSENSI BERDASARKAN URL
    // ==========================================

    $isPulang = uri_string() === 'scan/pulang';

    if ($isPulang) {

        // Untuk halaman /scan/pulang
        $processUrl = base_url('scan/prosesScanPulang');
        $modeTitle = 'Absensi Pulang';
        $instruction = 'Arahkan kamera ke QR Code personel untuk absen pulang';

    } else {

        // Untuk halaman /scan
        $processUrl = base_url('scan/prosesScan');
        $modeTitle = 'Absensi Masuk';
        $instruction = 'Arahkan kamera ke QR Code personel';
    }
?>

<div class="container scanner-container">

    <h2 class="mb-2">
        Sistem Absensi Bid TIK
    </h2>

    <p class="mode-title mb-1">
        <?= $modeTitle ?>
    </p>

    <p class="text-light">
        <?= $instruction ?>
    </p>


    <!-- ==========================================
         CAMERA SCANNER
    =========================================== -->

    <div id="reader"></div>


    <!-- ==========================================
         HASIL ABSENSI
    =========================================== -->

    <div id="alertResult" class="mt-3"></div>


    <hr class="my-4">


    <!-- ==========================================
         INPUT MANUAL
    =========================================== -->

    <p class="text-light">
        Atau masukkan NRP / NIP secara manual
    </p>

    <form id="formScan" class="manual-input">

        <input
            type="text"
            id="nrp_nip"
            name="nrp_nip"
            class="form-control form-control-lg text-center"
            placeholder="Masukkan NRP / NIP"
            autocomplete="off"
            required
        >

        <button
            type="submit"
            class="btn btn-primary btn-lg w-100 mt-3"
        >
            <?= $isPulang ? 'Absen Pulang' : 'Absen Masuk' ?>
        </button>

    </form>

</div>


<script>

    // ==========================================
    // MODE ABSENSI
    // ==========================================

    const isPulang = <?= $isPulang ? 'true' : 'false' ?>;

    // URL proses otomatis berdasarkan halaman
    const processUrl = '<?= $processUrl ?>';

    console.log('Mode Pulang:', isPulang);
    console.log('URL Proses:', processUrl);


    // ==========================================
    // MENCEGAH QR TERBACA BERKALI-KALI
    // ==========================================

    let scanProcessing = false;


    // ==========================================
    // TAMPILKAN NOTIFIKASI
    // ==========================================

    function tampilkanNotif(response) {

        let alertClass = 'alert-danger';

        if (response.status === 'success') {
            alertClass = 'alert-success';
        }

        if (response.status === 'warning') {
            alertClass = 'alert-warning';
        }

        $('#alertResult').html(
            '<div class="alert ' +
            alertClass +
            ' alert-dismissible fade show" role="alert">' +
            '<strong>' +
            (response.status === 'success'
                ? '✓ Berhasil'
                : response.status === 'warning'
                    ? '⚠ Perhatian'
                    : '✕ Gagal'
            ) +
            '</strong><br>' +
            response.message +
            '</div>'
        );
    }


    // ==========================================
    // PROSES ABSENSI
    // ==========================================

    function prosesAbsensi(nrp) {

        if (!nrp || scanProcessing) {
            return;
        }

        scanProcessing = true;

        console.log('Mengirim NRP/NIP:', nrp);
        console.log('Ke URL:', processUrl);

        $.post(
            processUrl,
            {
                nrp_nip: nrp
            },

            function(response) {

                console.log('Response:', response);

                tampilkanNotif(response);

                // Kosongkan input
                $('#nrp_nip').val('');

                /*
                 * Setelah proses selesai, izinkan scan lagi.
                 *
                 * Tetapi diberi jeda agar satu QR tidak
                 * terbaca berkali-kali oleh kamera.
                 */
                setTimeout(function() {
                    scanProcessing = false;
                }, 3000);

            },

            'json'

        ).fail(function(xhr) {

            console.log('Error:', xhr.responseText);

            $('#alertResult').html(
                '<div class="alert alert-danger">' +
                '<strong>✕ Gagal</strong><br>' +
                'Terjadi kesalahan saat memproses absensi.' +
                '</div>'
            );

            setTimeout(function() {
                scanProcessing = false;
            }, 3000);

        });
    }


    // ==========================================
    // INPUT MANUAL
    // ==========================================

    $('#formScan').on('submit', function(e) {

        e.preventDefault();

        let nrp = $('#nrp_nip').val().trim();

        if (nrp !== '') {

            prosesAbsensi(nrp);

        }

    });


    // ==========================================
    // QR CODE SCANNER
    // ==========================================

    function onScanSuccess(decodedText, decodedResult) {

        console.log('================================');
        console.log('QR TERBACA');
        console.log('Isi QR:', decodedText);
        console.log('Mode pulang:', isPulang);
        console.log('Endpoint:', processUrl);
        console.log('================================');

        if (scanProcessing) {
            return;
        }

        // Jalankan proses sesuai mode
        prosesAbsensi(decodedText);
    }


    function onScanFailure(error) {
        // Tidak perlu menampilkan error setiap frame.
    }


    // ==========================================
    // JALANKAN KAMERA
    // ==========================================

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,

            qrbox: {
                width: 250,
                height: 250
            },

            rememberLastUsedCamera: true,

            showTorchButtonIfSupported: true
        },

        false
    );


    html5QrcodeScanner.render(
        onScanSuccess,
        onScanFailure
    );

</script>

</body>
</html>