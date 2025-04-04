document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        event.preventDefault(); // منع تقديم النموذج بشكل افتراضي

        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const address = document.getElementById('address').value;
        const phone = document.getElementById('phone').value;

        // إرسال بيانات التسجيل إلى الخادم باستخدام AJAX
        fetch('signup_process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: username,
                email: email,
                password: password,
                address: address,
                phone: phone,
            })
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('message');
            if (data.success) {
                // تم التسجيل بنجاح، عرض رسالة نجاح
                messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            } else {
                // عرض رسالة خطأ
                messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
