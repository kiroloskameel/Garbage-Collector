

document.addEventListener("DOMContentLoaded", function() {
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages = 0;
  
    // Function to display data in the table
    function displayItems(data) {
      const userTableBody = document.getElementById("userTableBody");
      userTableBody.innerHTML = "";
  
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const displayData = data.slice(startIndex, endIndex);
  
      displayData.forEach(user => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${user.username}</td>
          <td>${user.email}</td>
          <td>${user.address}</td>
          <td>${user.phone}</td>
          <td>${user.service_package}</td>
          <td>
            <button class="btn btn-primary btn-update" data-user-id="${user.user_id}">Update</button>
            <button class="btn btn-danger btn-delete" data-user-id="${user.user_id}">Delete</button>
          </td>
        `;
        userTableBody.appendChild(row);
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
  
    // Retrieve initial data
    retrieveUserData();
  
    // Event listener for previous page button
    document.getElementById("prevPageBtn").addEventListener("click", function() {
      if (currentPage > 1) {
        currentPage--;
        retrieveUserData();
      }
    });
  
    // Event listener for next page button
    document.getElementById("nextPageBtn").addEventListener("click", function() {
      if (currentPage < totalPages) {
        currentPage++;
        retrieveUserData();
      }
    });
  
    // Event listener for delete or update row buttons
    document.addEventListener("click", function(event) {
      if (event.target.classList.contains("btn-delete")) {
        const userId = event.target.getAttribute("data-user-id");
        deleteUsers(userId);
      } else if (event.target.classList.contains("btn-update")) {
        const userId = event.target.getAttribute("data-user-id");
        document.getElementById("updateUserId").value = userId;
        $('#editUserModal').modal('show');
      }
    });
  
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
  
    // Retrieve data
    function retrieveUserData() {
      fetch("display_users.php")
        .then(response => response.json())
        .then(data => {
          totalPages = Math.ceil(data.length / itemsPerPage);
          displayItems(data);
        })
        .catch(error => console.error("Error fetching clients:", error));
    }
  
    // Function to delete user
    function deleteUsers(userId) {
      fetch("delete_user.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `delete_btn=1&user_id=${userId}`
      })
        .then(response => response.text())
        .then(message => {
          alert(message);
          retrieveUserData();
        })
        .catch(error => console.error("Error deleting user:", error));
    }
  });
  
  // Function to open the edit modal with appropriate user data
  function openEditModal(userId, username, email, address, phone) {
    document.getElementById("updateUserId").value = userId;
    document.getElementById("usernameInput").value = username;
    document.getElementById("emailInput").value = email;
    document.getElementById("addressInput").value = address;
    document.getElementById("phoneInput").value = phone;
    $('#editUserModal').modal('show');
  }
  
  // Event listener for edit buttons
  document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-update")) {
      const userId = event.target.getAttribute("data-user-id");
      const username = event.target.parentElement.parentElement.children[0].innerText;
      const email = event.target.parentElement.parentElement.children[1].innerText;
      const address = event.target.parentElement.parentElement.children[2].innerText;
      const phone = event.target.parentElement.parentElement.children[3].innerText;
      openEditModal(userId, username, email, address, phone);
    }
  });
  
  // Event listener for save changes button
  const saveChangesBtn = document.querySelector("#saveChangesBtn");
  if (saveChangesBtn) {
    saveChangesBtn.addEventListener("click", function() {
      saveChanges();
    });
  } else {
    console.error("Cannot find 'Save Changes' button.");
  }
  
// Function to save changes
function saveChanges() {
    const userId = document.getElementById("updateUserId").value;
    const username = document.getElementById("usernameInput").value;
    const email = document.getElementById("emailInput").value;
    const address = document.getElementById("addressInput").value;
    const phone = document.getElementById("phoneInput").value;

    fetch("update_user.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `user_id=${userId}&username=${username}&email=${email}&address=${address}&phone=${phone}` // Removed service_package parameter
    })
        .then(response => response.text())
        .then(message => {
            alert(message);
            retrieveUserData(); // Refresh data after saving changes
            $('#editUserModal').modal('hide');
            location.reload(); // Reload the page to show updated data
        })
        .catch(error => console.error("Error updating user:", error));
}

  