document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault(); // منع تقديم النموذج بشكل افتراضي

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const address = document.getElementById('address').value;
    const phone = document.getElementById('phone').value;
    const zone = document.getElementById('zone').value;

    // إرسال بيانات التسجيل إلى الخادم باستخدام AJAX
    fetch('signup_process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            email: email,
            password: password,
            address: address,
            phone: phone,
            zone: zone
        })
    })
    .then(response => response.json())
    // .then(data => {
    //     if (data.success) {
    //         // تم التسجيل بنجاح، قم بتخزين معلومات العميل في session
    //         sessionStorage.setItem('clientData', JSON.stringify(data.client));
    //         // قم بتوجيه المستخدم إلى الصفحة التالية (على سبيل المثال، صفحة العميل)
    //         window.location.href = 'http://localhost/garbage%20mangement%20project/2-login%20&sign%20for%20client/login_user.html';
    //     } else {
    //         // فشل التسجيل، قم بعرض رسالة الخطأ
    //         alert(data.message);
    //     }
    // })
    // .catch(error => console.error('Error:', error));
});
