document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        event.preventDefault(); // منع تقديم النموذج بشكل افتراضي

        // تحقق من صحة البيانات
        if (!this.checkValidity()) {
            return;
        }

        // احصل على بيانات النموذج
        const formData = new FormData(this);

        // إرسال بيانات التسجيل إلى الخادم باستخدام AJAX
        fetch('signup_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())  // استخدم response.text() لعرض الرد النصي الكامل
        .then(text => {
            try {
                const data = JSON.parse(text);
                const successMessage = document.getElementById('successMessage');
                const errorMessage = document.getElementById('errorMessage');
                
                if (data.success) {
                    // تم التسجيل بنجاح، قم بعرض رسالة النجاح
                    successMessage.textContent = data.message;
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';

                    // إعادة التوجيه إلى صفحة تسجيل الدخول بعد 3 ثوانٍ
                    setTimeout(function() {
                        window.location.href = 'http://localhost:8080/garbage%20mangement%20project/2-log&sign/1-login%20&sign%20for%20client-admin/login_user.html';
                    }, 1000); // 1000 ميلي ثانية = 1 ثانية
                } else {
                    // فشل التسجيل، قم بعرض رسالة الخطأ
                    errorMessage.textContent = data.message;
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';
                }
            } catch (e) {
                console.error('Parsing error:', e);
                console.error('Server response:', text);
            }
        })
        .catch(error => console.error('Fetch error:', error));
    });
});
