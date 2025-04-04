document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // منع تقديم النموذج بشكل افتراضي

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // إرسال بيانات تسجيل الدخول إلى الخادم باستخدام AJAX
    fetch('login_process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // تم تسجيل الدخول بنجاح، قم بتخزين معلومات العميل في session
            sessionStorage.setItem('clientData', JSON.stringify(data.client));
            // قم بتوجيه المستخدم إلى الصفحة التالية (على سبيل المثال، صفحة العميل)
            window.location.href = 'http://localhost/garbage%20mangement%20project/3-client%20home%20(js&php)/client_home.html';
        } else {
            // فشل تسجيل الدخول، قم بعرض رسالة الخطأ
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
