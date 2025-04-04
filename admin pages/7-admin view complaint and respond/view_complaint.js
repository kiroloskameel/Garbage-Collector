document.addEventListener('DOMContentLoaded', function() {
    const itemsPerPage = 7;
    let currentPage = 1;
    let totalPages = 0;
    let allComplaints = []; // ستحتوي على البيانات الكلية
    let filteredData = []; // سيحتوي على البيانات المفلترة بناءً على البحث

    // استرجاع البيانات الأولى عند تحميل الصفحة
    fetchComplaints();

    // دالة لاسترجاع بيانات الشكاوى من ملف PHP
    function fetchComplaints() {
        fetch('get_complaints.php')
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
        const endIndex = Math.min(startIndex + itemsPerPage, data.length);
        const displayData = data.slice(startIndex, endIndex);

        // عرض البيانات في الجدول
        displayData.forEach(complaint => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${complaint.name}</td>
                <td>${complaint.email}</td>
                <td>${complaint.complaint}</td>
                <td>${complaint.created_at}</td>
                <td>${complaint.admin_response || 'No response yet'}</td>
                <td><textarea id="response_${complaint.id}" rows="3" cols="30"></textarea><br><button onclick="submitResponse(${complaint.id})">Submit Response</button></td>
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

// وظيفة لإرسال الرد من قبل المسؤول
function submitResponse(complaintId) {
    const responseTextarea = document.getElementById(`response_${complaintId}`);
    const adminResponse = responseTextarea.value.trim();

    // إرسال البيانات إلى الخادم
    fetch('get_complaints.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: complaintId,
            admin_response: adminResponse
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // إذا تم إرسال الرد بنجاح، يمكنك تنفيذ الإجراء المطلوب هنا، مثلاً إعادة تحميل البيانات أو إظهار رسالة نجاح
            document.getElementById('messageContainer').innerHTML = '<div class="success-message">Admin response submitted successfully</div>';
            setTimeout(function() {
                location.reload();
            }, 1000); // إعادة تحميل الصفحة بعد 1 ثانية
        } else {
            // إذا فشلت عملية إرسال الرد، يمكنك إظهار رسالة خطأ للمستخدم أو اتخاذ إجراء آخر حسب الحاجة
            const messageContainer = document.getElementById('messageContainer');
            messageContainer.innerHTML = '<div class="error-message">Failed to submit admin response</div>';
        }
    })
    
}

