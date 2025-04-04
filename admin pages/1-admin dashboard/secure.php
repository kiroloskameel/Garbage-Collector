<?php
session_start();

// تحقق مما إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
    // إذا لم يكن قد سجل الدخول، أعد توجيهه إلى صفحة تسجيل الدخول
    header("Location: http://localhost:8080/garbage%20mangement%20project/2-log&sign/1-login%20&sign%20for%20client-admin/login_user.html");
    exit();
}
?>
