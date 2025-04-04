document.addEventListener("DOMContentLoaded", function() {
  const itemsPerPage = 8;
  let currentPage = 1;
  let totalPages = 0;

  function displayItems(data) {
      const binTableBody = document.getElementById("binTableBody");
      binTableBody.innerHTML = "";

      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const displayData = data.slice(startIndex, endIndex);

      displayData.forEach(bin => {
          const row = document.createElement("tr");
          row.innerHTML = `
              <td>${bin.Bin_id}</td>
              <td>${bin.binOwner}</td>
              <td>${bin.capacity}</td>
              <td>${bin.zone}</td>
              <td>${bin.address}</td>
              <td>${bin.distance}%</td>
              <td>${bin.status}</td>
          `;
          binTableBody.appendChild(row);
      });

      updatePaginationButtons(data.length);
  }

  function updatePaginationButtons(totalItems) {
      const prevPageBtn = document.getElementById("prevPageBtn");
      const nextPageBtn = document.getElementById("nextPageBtn");

      prevPageBtn.disabled = currentPage === 1;
      nextPageBtn.disabled = currentPage === totalPages;
  }

  fetchBins();

  document.getElementById("prevPageBtn").addEventListener("click", function() {
      if (currentPage > 1) {
          currentPage--;
          fetchBins();
      }
  });

  document.getElementById("nextPageBtn").addEventListener("click", function() {
      if (currentPage < totalPages) {
          currentPage++;
          fetchBins();
      }
  });

  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("keyup", function() {
      const filter = searchInput.value.toUpperCase();
      const table = document.getElementById("binTable");
      const rows = table.getElementsByTagName("tr");

      for (let i = 1; i < rows.length; i++) {
          const cells = rows[i].getElementsByTagName("td");
          let found = false;
          for (let j = 0; j < cells.length; j++) {
              const cell = cells[j];
              if (cell) {
                  const textValue = cell.textContent || cell.innerText;
                  if (textValue.toUpperCase().indexOf(filter) > -1) {
                      found = true;
                      break;
                  }
              }
          }
          rows[i].style.display = found ? "" : "none";
      }
  });

  function fetchBins() {
      fetch("display_bins.php")
          .then(response => response.json())
          .then(data => {
              totalPages = Math.ceil(data.length / itemsPerPage);
              displayItems(data);
          })
          .catch(error => console.error("Error fetching bins:", error));
  }
});