function updateRekap() {
  const counts = {
    Hadir: 0,
    Izin: 0,
    Sakit: 0,
    "Dinas Luar": 0,
    Alfa: 0,
    "Lepas Dinas": 0,
    Terlambat: 0,
    Pendidikan: 0,
    BKO: 0,
  };

  // Hitung semua radio button status yang dicentang
  const checkedRadios = document.querySelectorAll(
    'input[type="radio"][name^="status["]:checked',
  );

  checkedRadios.forEach((radio) => {
    const val = radio.value;
    if (counts.hasOwnProperty(val)) {
      counts[val]++;
    }
  });

  // Update teks angka pada elemen rekap di layar bawah
  document.getElementById("count_hadir").innerText = counts["Hadir"];
  document.getElementById("count_izin").innerText = counts["Izin"];
  document.getElementById("count_sakit").innerText = counts["Sakit"];
  document.getElementById("count_dinas").innerText = counts["Dinas Luar"];
  document.getElementById("count_alfa").innerText = counts["Alfa"];
  document.getElementById("count_lepas").innerText = counts["Lepas Dinas"];
  document.getElementById("count_terlambat").innerText = counts["Terlambat"];
  document.getElementById("count_pendidikan").innerText = counts["Pendidikan"];
  document.getElementById("count_bko").innerText = counts["BKO"];

  // Total Personel terdata
  document.getElementById("count_total").innerText = checkedRadios.length;
}

// Jalankan saat halaman pertama kali diload
document.addEventListener("DOMContentLoaded", function () {
  updateRekap();
});
