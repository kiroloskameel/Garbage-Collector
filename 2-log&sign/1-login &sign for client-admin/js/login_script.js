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
            // قم بتوجيه المستخدم إلى الصفحة المناسبة بناءً على دوره
            if (data.client.role === 'client') {
                window.location.href = 'http://localhost:8080/garbage%20mangement%20project/client%20pages/1-client%20dashbord/INDEX%20CLIENT.php';
            } else if (data.client.role === 'admin') {
                window.location.href = 'http://localhost:8080/garbage%20mangement%20project/admin%20pages/1-admin%20dashboard/';
            }
        } else {
            // فشل تسجيل الدخول، قم بعرض رسالة الخطأ
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
