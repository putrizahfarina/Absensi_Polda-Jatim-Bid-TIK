function updateRekap() {
    const counts = {
        HADIR: 0,
        DINAS: 0,
        "LEPAS DINAS": 0,
        CUTI: 0,
        SAKIT: 0,
        IZIN: 0,
        TERLAMBAT: 0,
        DIK: 0,
        BKO: 0
    };

    // Ambil semua status yang sedang dipilih
    const checkedRadios = document.querySelectorAll(
        'input[type="radio"][name^="status["]:checked'
    );

    checkedRadios.forEach((radio) => {
        const val = radio.value.trim().toUpperCase();

        if (Object.prototype.hasOwnProperty.call(counts, val)) {
            counts[val]++;
        }
    });

    // Tampilkan hasil rekap
    document.getElementById("count_hadir").innerText =
        counts["HADIR"];

    document.getElementById("count_dinas").innerText =
        counts["DINAS"];

    document.getElementById("count_lepas_dinas").innerText =
        counts["LEPAS DINAS"];

    document.getElementById("count_cuti").innerText =
        counts["CUTI"];

    document.getElementById("count_sakit").innerText =
        counts["SAKIT"];

    document.getElementById("count_izin").innerText =
        counts["IZIN"];

    document.getElementById("count_terlambat").innerText =
        counts["TERLAMBAT"];

    document.getElementById("count_dik").innerText =
        counts["DIK"];

    document.getElementById("count_bko").innerText =
        counts["BKO"];

    // Total personel yang mempunyai status
    document.getElementById("count_total").innerText =
        checkedRadios.length;
}


// Jalankan ketika halaman pertama dibuka
document.addEventListener("DOMContentLoaded", function () {
    updateRekap();
});