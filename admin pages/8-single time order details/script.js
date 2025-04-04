document.addEventListener("DOMContentLoaded", function() {
  const itemsPerPage = 8;
  let currentPage = 1;
  let totalPages = 0;
  let allData = [];

  // Function to display data in the table
  function displayInvoices(data) {
      const invoiceTableBody = document.getElementById("invoiceTableBody");
      invoiceTableBody.innerHTML = "";

      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const displayData = data.slice(startIndex, endIndex);

      displayData.forEach(invoice => {
          const row = document.createElement("tr");
          row.innerHTML = `
              <td>${invoice.collection_date}</td>
              <td>${invoice.name}</td>
              <td>${invoice.email}</td>
              <td>${invoice.zone}</td>
              <td>${invoice.package_price}</td>
              <td>${invoice.created_at}</td>
              <td>${invoice.status}</td>
              <td>
                  <button class="btn btn-primary btn-update" data-invoice-id="${invoice.id}">Update</button>
                  <button class="btn btn-danger btn-delete" data-invoice-id="${invoice.id}">Delete</button>
              </td>
          `;
          invoiceTableBody.appendChild(row);
      });

      updatePaginationButtons(data.length);
  }


  
  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("keyup", function() {
      const filter = searchInput.value.toUpperCase();
      const table = document.getElementById("invoiceTable");
      const rows = table.getElementsByTagName("tr");
      let filteredData = [];

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
          if (found) {
              filteredData.push(allData[i - 1]);
          }
      }

      currentPage = 1;
      totalPages = Math.ceil(filteredData.length / itemsPerPage);
      displayInvoices(filteredData);

      if (filter === "") {
          displayInvoices(allData);
      }
  });

  // Function to update pagination buttons
  function updatePaginationButtons(totalItems) {
      const prevPageBtn = document.getElementById("prevPageBtn");
      const nextPageBtn = document.getElementById("nextPageBtn");

      prevPageBtn.disabled = currentPage === 1;
      nextPageBtn.disabled = currentPage === totalPages;
  }

  // Fetching data
  function fetchInvoices() {
      fetch("display_single_order.php")
          .then(response => response.json())
          .then(data => {
              if (data.error) {
                  alert(data.error);
              } else {
                  allData = data;
                  totalPages = Math.ceil(allData.length / itemsPerPage);
                  displayInvoices(allData);
              }
          })
          .catch(error => console.error("Error fetching invoices:", error));
  }

  // Event listener for "Next" button click
  document.getElementById("nextPageBtn").addEventListener("click", function() {
      if (currentPage < totalPages) {
          currentPage++;
          displayInvoices(allData);
      }
  });

  // Event listener for "Previous" button click
  document.getElementById("prevPageBtn").addEventListener("click", function() {
      if (currentPage > 1) {
          currentPage--;
          displayInvoices(allData);
      }
  });

  // Event listener for Update and Delete buttons
  document.addEventListener("click", function(event) {
      if (event.target.classList.contains("btn-delete")) {
          const invoiceId = event.target.getAttribute("data-invoice-id");
          deleteInvoice(invoiceId);
      } else
      if (event.target.classList.contains("btn-update")) {
          const invoiceId = event.target.getAttribute("data-invoice-id");
          const row = event.target.parentElement.parentElement;
          const name = row.children[1].innerText;
          const email = row.children[2].innerText;
          const zone = row.children[3].innerText;
          const status = row.children[6].innerText;
          openEditModal(invoiceId, name, email, zone, status); 

      }
      
  });

  // Function to open the edit modal with appropriate invoice data
  function openEditModal(invoiceId, name, email, zone, status) {
    document.getElementById("updateInvoiceId").value = invoiceId;
    document.getElementById("nameInput").value = name;
    document.getElementById("emailInput").value = email;
    document.getElementById("zoneInput").value = zone;
        document.getElementById("statusInput").value = status;

    $('#editInvoiceModal').modal('show');
}


  // Event listener to save changes
  const saveChangesBtn = document.querySelector("#saveChangesBtn");
if (saveChangesBtn) {
    saveChangesBtn.addEventListener("click", function(event) {
        event.preventDefault();
        saveChanges();
    });
} else {
    console.error("Cannot find 'Save Changes' button.");
}


  // Function to save changes
  function saveChanges() {
    const id = document.getElementById("updateInvoiceId").value;
    const name = document.getElementById("nameInput").value;
    const email = document.getElementById("emailInput").value;
    const zone = document.getElementById("zoneInput").value;
    const status = document.getElementById("statusInput").value;

    fetch("update_order.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${id}&name=${name}&email=${email}&zone=${zone}&status=${status}`
    })
    .then(response => response.text())
    .then(message => {
        alert(message);
        fetchInvoices();
        $('#editInvoiceModal').modal('hide');
    })
    .catch(error => console.error("Error updating invoice:", error));
}


  // Function to delete an invoice
  function deleteInvoice(invoiceId) {
      fetch("delete_order.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `delete_btn=1&invoice_id=${invoiceId}`
      })
          .then(response => response.text())
          .then(message => {
              alert(message);
              fetchInvoices();
          })
          .catch(error => console.error("Error deleting invoice:", error));
  }

  // Fetch invoices when DOM content is loaded
  fetchInvoices();
});
