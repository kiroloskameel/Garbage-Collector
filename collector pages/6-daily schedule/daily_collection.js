document.addEventListener("DOMContentLoaded", function() {
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages = 0;
    let allData = [];

    function displayData(data) {
        const tableBody = document.getElementById("dailyCollectionTableBody");
        tableBody.innerHTML = "";

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const displayData = data.slice(startIndex, endIndex);

        displayData.forEach(item => {
            if (item.status === 'not collected') {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.type}</td>
                    <td>${item.name || item.binOwner}</td>
                    <td>${item.email || ""}</td>
                    <td>${item.zone}</td>
                    <td>${item.address}</td>
                    <td>${item['Fill Percentage']}</td>
                    <td>${item.status}</td>
                    <td>
                        <button class="collect-btn" data-id="${item.id}" data-type="${item.type}" style="background-color: ${item.status === 'collected' ? 'green' : 'yellow'}">
                            ${item.status === 'collected' ? 'Collected' : 'Mark as Collected'}
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            }
        });

        updatePaginationButtons(data.length);
    }

    function updatePaginationButtons(totalItems) {
        const prevPageBtn = document.getElementById("prevPageBtn");
        const nextPageBtn = document.getElementById("nextPageBtn");

        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
    }

    function fetchData() {
        fetch("daily_collection_data.php")
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    allData = data.filter(item => item.status === 'not collected'); // Filter to only include 'not collected' items
                    totalPages = Math.ceil(allData.length / itemsPerPage);
                    displayData(allData);
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    }

    document.getElementById("prevPageBtn").addEventListener("click", function() {
        if (currentPage > 1) {
            currentPage--;
            displayData(allData);
        }
    });

    document.getElementById("nextPageBtn").addEventListener("click", function() {
        if (currentPage < totalPages) {
            currentPage++;
            displayData(allData);
        }
    });

    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toUpperCase();
        const filteredData = allData.filter(item => {
            return (
                (item.name && item.name.toUpperCase().includes(filter)) ||
                (item.binOwner && item.binOwner.toUpperCase().includes(filter)) ||
                (item.email && item.email.toUpperCase().includes(filter)) ||
                (item.zone && item.zone.toUpperCase().includes(filter)) ||
                (item.address && item.address.toUpperCase().includes(filter))
            );
        });

        currentPage = 1;
        totalPages = Math.ceil(filteredData.length / itemsPerPage);
        displayData(filteredData);

        if (filter === "") {
            displayData(allData);
        }
    });

    document.addEventListener("click", function(event) {
        if (event.target && event.target.classList.contains("collect-btn")) {
            const id = event.target.getAttribute("data-id");
            const type = event.target.getAttribute("data-type");

            console.log("Sending data:", { id: id, type: type }); // Added debug statement

            fetch("update_collection_status.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: id, type: type })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response data:", data); // Added debug statement
                if (data.success) {
                    // Remove the collected item from allData
                    allData = allData.filter(item => item.id !== parseInt(id));
                    // Recalculate totalPages
                    totalPages = Math.ceil(allData.length / itemsPerPage);
                    // Display the updated data
                    displayData(allData);
                } else {
                    console.error("Error updating status:", data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });

    fetchData();
});
