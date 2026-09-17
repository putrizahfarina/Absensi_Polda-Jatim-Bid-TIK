document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const urFilterSelect = document.getElementById("urFilterSelect");
  const tableRows = document.querySelectorAll(".personel-row-item");
  const totalCountElem = document.getElementById("totalPersonel");

  function filterTable() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const selectedUR = urFilterSelect.value.toLowerCase().trim();
    let visibleCount = 0;

    tableRows.forEach((row) => {
      const nrpText = row.querySelector(".nrp-val").textContent.toLowerCase();
      const namaText = row.querySelector(".nama-val").textContent.toLowerCase();
      const urText = row.getAttribute("data-ur").toLowerCase();

      const matchesSearch =
        nrpText.includes(searchTerm) || namaText.includes(searchTerm);
      const matchesUR = selectedUR === "" || urText.includes(selectedUR);

      if (matchesSearch && matchesUR) {
        row.style.display = "";
        visibleCount++;
      } else {
        row.style.display = "none";
      }
    });

    if (totalCountElem) {
      totalCountElem.textContent = visibleCount;
    }
  }

  if (searchInput) {
    searchInput.addEventListener("input", filterTable);
  }
  if (urFilterSelect) {
    urFilterSelect.addEventListener("change", filterTable);
  }
});
