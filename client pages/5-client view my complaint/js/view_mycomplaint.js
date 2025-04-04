document.addEventListener("DOMContentLoaded", function() {
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages = 0;
    let allComplaints = []; // ستحتوي على البيانات الكلية
    let filteredData = []; // سيحتوي على البيانات المفلترة بناءً على البحث

    // استرجاع البيانات الأولى عند تحميل الصفحة
    fetchComplaints();

    // دالة لاسترجاع بيانات الشكاوى من ملف PHP
    function fetchComplaints() {
        fetch('GET_INFO.php')
            .then(response => response.json())
            .then(complaints => {
                allComplaints = complaints; // حفظ البيانات الكلية
                displayItems(allComplaints); // عرض البيانات في الجدول
            })
            .catch(error => console.error('Error fetching complaints:', error));
    }

    // دالة لعرض البيانات في الجدول
    function displayItems(data) {
        const complaintTableBody = document.querySelector('#complaintTable tbody');
        complaintTableBody.innerHTML = ""; // إفراغ جسم الجدول

        // حساب نطاق العرض
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const displayData = data.slice(startIndex, endIndex);

        // عرض البيانات في الجدول
        displayData.forEach(complaint => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${complaint.complaint}</td>
                <td>${complaint.created_at}</td>
                <td>${complaint.admin_response || 'No response yet'}</td>
            `;
            complaintTableBody.appendChild(row);
        });

        updatePaginationButtons(data.length);
    }

    // دالة لتحديث أزرار التنقل بين الصفحات
    function updatePaginationButtons(totalItems) {
        totalPages = Math.ceil(totalItems / itemsPerPage);
        const prevPageBtn = document.getElementById("prevPage");
        const nextPageBtn = document.getElementById("nextPage");

        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
    }

    // استماع لحدث النقر على الزر السابق
    document.getElementById("prevPage").addEventListener("click", function() {
        if (currentPage > 1) {
            currentPage--;
            displayItems(filteredData.length ? filteredData : allComplaints);
        }
    });

    // استماع لحدث النقر على الزر التالي
    document.getElementById("nextPage").addEventListener("click", function() {
        if (currentPage < totalPages) {
            currentPage++;
            displayItems(filteredData.length ? filteredData : allComplaints);
        }
    });

    // وظيفة البحث
    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.trim().toLowerCase(); // تحويل النص إلى حروف صغيرة
        filteredData = allComplaints.filter(complaint => {
            return (
                (complaint.complaint && complaint.complaint.toLowerCase().includes(searchTerm)) || 
                (complaint.created_at && complaint.created_at.toLowerCase().includes(searchTerm)) ||
                (complaint.admin_response && complaint.admin_response.toLowerCase().includes(searchTerm))
            );
        });

        currentPage = 1; // إعادة الصفحة إلى الصفحة الأولى بعد البحث
        displayItems(filteredData);
    });
});
