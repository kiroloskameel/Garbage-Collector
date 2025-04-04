document.addEventListener("DOMContentLoaded", function() {
  const itemsPerPage = 8;
  let currentPage = 1;
  let totalPages = 0;

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
      <td>${invoice.id}</td>
      <td>${invoice.service_package}</td>
      <td>${invoice.name}</td>
      <td>${invoice.email}</td>
      <td>${invoice.zone}</td>
      <td>${invoice.package_price}</td>
      <td>${invoice.created_at}</td>
      <td>${invoice.package_expiry_date}</td>
      <td>${invoice.status}</td>
      <td>
          <button class="btn btn-danger btn-delete" data-invoice-id="${invoice.id}">Delete</button>
          <button class="btn btn-primary btn-print" data-invoice-id="${invoice.id}">Print</button>
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

  // Fetching data
  function fetchInvoices() {
    fetch("display_invoices.php")
      .then(response => response.json())
      .then(data => {
        totalPages = Math.ceil(data.length / itemsPerPage);
        displayInvoices(data);
      })
      .catch(error => console.error("Error fetching invoices:", error));
  }

  // Event listener for "Previous" button click
  document.getElementById("prevPageBtn").addEventListener("click", function() {
    if (currentPage > 1) {
      currentPage--;
      fetchInvoices();
    }
  });

  // Event listener for "Next" button click
  document.getElementById("nextPageBtn").addEventListener("click", function() {
    if (currentPage < totalPages) {
      currentPage++;
      fetchInvoices();
    }
  });

  // Event listener for "Delete" button click
  document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-delete")) {
      const invoiceId = event.target.getAttribute("data-invoice-id");
      deleteInvoice(invoiceId);
    }
  });

  // Function to delete an invoice
  function deleteInvoice(invoiceId) {
    fetch("delete_invoice.php", {
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

  // Event listener for "Print" button click
  document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-print")) {
        const invoiceId = event.target.getAttribute("data-invoice-id");
        printInvoice(invoiceId);
    }
});


  // Function to print an invoice
  function printInvoice(invoiceId) {
    // Fetch data for the selected invoice
    fetch("invoice.php?id=" + invoiceId)
        .then(response => response.json())
        .then(invoice => {
            // Create a new window for printing
            const printWindow = window.open("", "_blank");

            // Construct the HTML content for printing
            let htmlContent = `
                <html>
                    <head>
                        <title>Invoice</title>
                        <style>


                        
                            @media print {
                                body {
                                    font-family: Arial, sans-serif;
                                }
                                h1 {
                                    color: #333;
                                    text-align: center;
                                }
                                table {
                                    width: 100%;
                                    border-collapse: collapse;
                                }
                                th, td {
                                    border: 1px solid #ddd;
                                    padding: 8px;
                                    text-align: left;
                                }
                                tr:nth-child(even) {
                                    background-color: #f2f2f2;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <!-- Construct the invoice content using invoice data -->
                        <h1>Invoice</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>Invoices Number</th>
                                    <th>Service Package</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Zone</th>
                                    <th>Created At</th>
                                    <th>Package Expiry Date</th>

                                    <th>Package Price</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${invoice.id}</td>
                                    <td>${invoice.service_package}</td>
                                    <td>${invoice.name}</td>
                                    <td>${invoice.email}</td>
                                    <td>${invoice.zone}</td>
                                    <td>${invoice.created_at}</td>
                                    <td>${invoice.package_expiry_date}</td>

                                    <td>${invoice.package_price}</td>

                                </tr>
                            </tbody>
                        </table>
                    </body>
                </html>
            `;

            // Write the HTML content to the new window and print it
            printWindow.document.write(htmlContent);
            printWindow.document.close(); // Close document for IE compatibility
            printWindow.print(); // Print the window
        })
        .catch(error => console.error("Error printing invoice:", error));
  }
   // Search function
   const searchInput = document.getElementById("searchInput");
   searchInput.addEventListener("keyup", function() {
     const filter = searchInput.value.toUpperCase();
     const table = document.getElementById("userTable");
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

  // Fetch invoices when DOM content is loaded
  fetchInvoices();
});
 // Search function

 document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("keyup", function() {
      const filter = searchInput.value.toUpperCase();
      const table = document.getElementById("invoiceTable");
      const rows = table.getElementsByTagName("tr");

      for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
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
});

