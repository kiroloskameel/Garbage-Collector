document.addEventListener("DOMContentLoaded", function() {
  const itemsPerPage = 8;
  let currentPage = 1;
  let totalPages = 0;

  // وظيفة عرض البيانات في الجدول
  function displayItems(data) {
    const binTableBody = document.getElementById("binTableBody");
    binTableBody.innerHTML = "";

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const displayData = data.slice(startIndex, endIndex);

    displayData.forEach(bin => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${bin.binOwner}</td>
        <td>${bin.capacity}</td>
        <td>${bin.zone}</td>
        <td>${bin.address}</td>
        <td>${bin.distance}%</td>
        <td>${bin.status}</td>
        <td>
          <button class="btn btn-primary btn-update" data-bin-id="${bin.Bin_id}">Update</button>
          <button class="btn btn-danger btn-delete" data-bin-id="${bin.Bin_id}">Delete</button>
        </td>
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

  document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-delete")) {
      const binId = event.target.getAttribute("data-bin-id");
      deleteBin(binId);
    } else if (event.target.classList.contains("btn-update")) {
      const binId = event.target.getAttribute("data-bin-id");
      const binOwner = event.target.parentElement.parentElement.children[0].innerText;
      const capacity = event.target.parentElement.parentElement.children[1].innerText;
      const zone = event.target.parentElement.parentElement.children[2].innerText;
      const address = event.target.parentElement.parentElement.children[3].innerText;
      const distance = event.target.parentElement.parentElement.children[4].innerText;
      const status = event.target.parentElement.parentElement.children[5].innerText;
      openEditModal(binId, binOwner, capacity, zone, address, distance, status);
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

  function deleteBin(binId) {
    fetch("delete_bin.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `delete_btn=1&bin_id=${binId}`
    })
      .then(response => response.text())
      .then(message => {
        alert(message);
        fetchBins();
      })
      .catch(error => console.error("Error deleting bin:", error));
  }

  function openEditModal(binId, binOwner, capacity, zone, address, distance, status) {
    document.getElementById("updateBinId").value = binId;
    document.getElementById("binOwnerInput").value = binOwner;
    document.getElementById("capacityInput").value = capacity;
    document.getElementById("zoneInput").value = zone;
    document.getElementById("addressInput").value = address;
    document.getElementById("distanceInput").value = distance;
    document.getElementById("statusInput").value = status;
    $('#editBinModal').modal('show');
  }

  const saveChangesBtn = document.querySelector("#saveChangesBtn");
  if (saveChangesBtn) {
    saveChangesBtn.addEventListener("click", function() {
      saveChanges();
    });
  } else {
    console.error("Cannot find 'Save Changes' button.");
  }

  function saveChanges() {
    const binId = document.getElementById("updateBinId").value;
    const binOwner = document.getElementById("binOwnerInput").value;
    const capacity = document.getElementById("capacityInput").value;
    const zone = document.getElementById("zoneInput").value;
    const address = document.getElementById("addressInput").value;
    const distance = document.getElementById("distanceInput").value;
    const status = document.getElementById("statusInput").value;

    fetch("update_bin.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `bin_id=${binId}&binOwner=${binOwner}&capacity=${capacity}&zone=${zone}&address=${address}&distance=${distance}&status=${status}`
    })
      .then(response => response.text())
      .then(message => {
        alert(message);
        fetchBins();
        $('#editBinModal').modal('hide');
        location.reload();
      })
      .catch(error => console.error("Error updating bin:", error));
  }
});
