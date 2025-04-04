document.addEventListener("DOMContentLoaded", function() {
  const itemsPerPage = 8;
  let currentPage = 1;
  let totalPages = 0;

  // وظيفة عرض البيانات في الجدول
  function displayItems(data) {
    // احصل على جسم الجدول
    const binTableBody = document.getElementById("collectorTableBody");
    binTableBody.innerHTML = "";

    // حساب نطاق العرض
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const displayData = data.slice(startIndex, endIndex);

    // عرض البيانات في الجدول
    displayData.forEach(collector => {
      const row = document.createElement("tr");
      row.innerHTML = `
       <td>${collector.username}</td>
       <td>${collector.email}</td>
       <td>${collector.address}</td>
       <td>${collector.phone}</td>
       <td>${collector.zone}</td>
       <td>
         <button class="btn btn-primary btn-update" data-collector-id="${collector.collector_id}">Update</button>
         <button class="btn btn-danger btn-delete" data-collector-id="${collector.collector_id}">Delete</button>
       </td>
      `;
      collectorTableBody.appendChild(row);
     });
   
     updatePaginationButtons(data.length);
    }

  // وظيفة تحديث أزرار التنقل بين الصفحات
  function updatePaginationButtons(totalItems) {
    const prevPageBtn = document.getElementById("prevPageBtn");
    const nextPageBtn = document.getElementById("nextPageBtn");

    prevPageBtn.disabled = currentPage === 1;
    nextPageBtn.disabled = currentPage === totalPages;
  }

  // استرجاع البيانات الأولى
  fetchcollectors();

  // استماع لحدث النقر على الزر السابق
  document.getElementById("prevPageBtn").addEventListener("click", function() {
    if (currentPage > 1) {
      currentPage--;
      fetchcollectors();
    }
  });

  // استماع لحدث النقر على الزر التالي
  document.getElementById("nextPageBtn").addEventListener("click", function() {
    if (currentPage < totalPages) {
      currentPage++;
      fetchcollectors();
    }
  });

  // استماع لحدث النقر على الأزرار لحذف أو تحديث الصف
  document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-delete")) {
      const collectorId = event.target.getAttribute("data-collector-id");
      deletecollector(collectorId);
    } else if (event.target.classList.contains("btn-update")) {
      const collectorId = event.target.getAttribute("data-collector-id");
      // تحديث نموذج التحرير
      document.getElementById("updatecollectorId").value = collectorId;
      $('#editCollectorModal').modal('show');
    }
  });

  // وظيفة البحث
  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("keyup", function() {
    const filter = searchInput.value.toUpperCase();
    const table = document.getElementById("collectorTable");
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

  // استرجاع البيانات
  function fetchcollectors() {
    fetch("display_col.php")
      .then(response => response.json())
      .then(data => {
        totalPages = Math.ceil(data.length / itemsPerPage);
        displayItems(data);
      })
      .catch(error => console.error("Error fetching collectors:", error));
  }

  // وظيفة حذف الصندوق
  function deletecollector(collectorId) {
    fetch("delete_col.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `delete_btn=1&collector_id=${collectorId}`
    })
      .then(response => response.text())
      .then(message => {
        alert(message);
        fetchcollectors();
      })
      .catch(error => console.error("Error deleting collector:", error));
  }

 
});

// Function to open the edit modal with appropriate collector data
function openEditModal(collectorId, username, email, address, phone, zone) {
  document.getElementById("updateCollectorId").value = collectorId;
  document.getElementById("usernameInput").value = username;
  document.getElementById("emailInput").value = email;
  document.getElementById("addressInput").value = address;
  document.getElementById("phoneInput").value = phone;
  document.getElementById("zoneInput").value = zone;
  $('#editCollectorModal').modal('show');
 }

// Add event listener to edit buttons
document.addEventListener("click", function(event) {
  if (event.target.classList.contains("btn-update")) {
   const collectorId = event.target.getAttribute("data-collector-id");
   const username = event.target.parentElement.parentElement.children[0].innerText;
   const email = event.target.parentElement.parentElement.children[1].innerText;
   const address = event.target.parentElement.parentElement.children[2].innerText;
   const phone = event.target.parentElement.parentElement.children[3].innerText;
   const zone = event.target.parentElement.parentElement.children[4].innerText;
   openEditModal(collectorId, username, email, address, phone, zone);
  }
 });

// Add event listener to save changes button
const saveChangesBtn = document.querySelector("#saveChangesBtn");
if (saveChangesBtn) {
  saveChangesBtn.addEventListener("click", function() {
    saveChanges();
  });
} else {
  console.error("Cannot find 'Save Changes' button.");
}


// Function to save changes
// Function to save changes
function saveChanges() {
  const collectorId = document.getElementById("updateCollectorId").value;
  const username = document.getElementById("usernameInput").value;
  const email = document.getElementById("emailInput").value;
  const address = document.getElementById("addressInput").value;
  const phone = document.getElementById("phoneInput").value;
  const zone = document.getElementById("zoneInput").value;
  
  fetch("update_col.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `collector_id=${collectorId}&username=${username}&email=${email}&address=${address}&phone=${phone}&zone=${zone}` // Ensure field names match database column names
  })
   .then(response => response.text())
   .then(message => {
    alert(message);
    fetchcollectors(); // Refresh data after saving changes
    $('#editCollectorModal').modal('hide');
    location.reload(); // Reload the page after saving changes
   })
   .catch(error => console.error("Error updating collector:", error));
}
