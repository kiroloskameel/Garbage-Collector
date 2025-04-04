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


    currentPage = 1;
    totalPages = Math.ceil(filteredData.length / itemsPerPage);
    displayInvoices(filteredData);

    if (filter === "") {
        displayInvoices(allData);
    }
});


  // Event listener for "Next" button click
  document.getElementById("nextPageBtn").addEventListener("click", function() {
      if (currentPage < totalPages) {
          currentPage++;
          displayInvoices(allData);
      }
  });

  // Fetch invoices when DOM content is loaded
  fetchInvoices();
});
