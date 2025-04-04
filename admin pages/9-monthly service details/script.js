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
                <td>${invoice.collection_days}</td>
                <td>${invoice.name}</td>
                <td>${invoice.email}</td>
                <td>${invoice.zone}</td>
                <td>${invoice.package_price}</td>
                <td>${invoice.created_at}</td>
                <td>${invoice.package_expiry_date}</td>
                <td>
                    <button class="btn btn-primary btn-update" data-invoice-id="${invoice.id}">Update</button>
                    <button class="btn btn-danger btn-delete" data-invoice-id="${invoice.id}">Delete</button>
                </td>
            `;
            invoiceTableBody.appendChild(row);
        });
  
        updatePaginationButtons(data.length);
    }
  
    // Function to update pagination buttons
    function updatePaginationButtons(totalItems) {
        const prevPageBtn = document.getElementById("prevPageBtn");
        const nextPageBtn = document.getElementById("nextPageBtn");
  
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
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
          });

  
    // Fetching data
    function fetchInvoices() {
        fetch("display_monthly_order.php")
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
            const collection_days = row.children[0].innerText;
            const name = row.children[1].innerText;
            const email = row.children[2].innerText;
            const zone = row.children[3].innerText;
            const package_price = row.children[4].innerText;
            const created_at = row.children[5].innerText;
            const package_expiry_date = row.children[6].innerText;
            openEditModal(invoiceId, collection_days, name, email, zone, package_price, created_at, package_expiry_date); 
  
        }
        
    });
  
    // Function to open the edit modal with appropriate invoice data
    function openEditModal(invoiceId, collection_days, name, email, zone, package_price, created_at, package_expiry_date) {
      document.getElementById("updateInvoiceId").value = invoiceId;
      document.getElementById("collection_daysInput").value = collection_days;
      document.getElementById("nameInput").value = name;
      document.getElementById("emailInput").value = email;
      document.getElementById("zoneInput").value = zone;
      document.getElementById("package_priceInput").value = package_price;
      document.getElementById("created_atInput").value = created_at;
      document.getElementById("packageExpiryDateInput").value = package_expiry_date;
  
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
      const collection_days = document.getElementById("collection_daysInput").value;
      const name = document.getElementById("nameInput").value;
      const email = document.getElementById("emailInput").value;
      const zone = document.getElementById("zoneInput").value;
      const package_price = document.getElementById("package_priceInput").value;
      const created_at = document.getElementById("created_atInput").value;
      const package_expiry_date = document.getElementById("packageExpiryDateInput").value;
  
      fetch("update_monthly_order.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `id=${id}&collection_days=${collection_days}&name=${name}&email=${email}&zone=${zone}&package_price=${package_price}&created_at=${created_at}&package_expiry_date=${package_expiry_date}`
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
        fetch("delete_MONTHLY.php", {
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
