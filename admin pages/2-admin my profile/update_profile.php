<?php
session_start();

// التحقق من إرسال البيانات بواسطة طريقة POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

    // استقبال البيانات المحدثة من النموذج
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    // ازالة Selected Package من الاستعلام
    $sql = "UPDATE users SET username='$username', email='$email', address='$address', phone='$phone' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("update your profile successfully");
        window.location.href = "http://localhost:8080/garbage%20mangement%20project/admin%20pages/2-admin%20my%20profile/INDEX%20admin.php";
       </script>';
    } else {
        echo "حدث خطأ أثناء تحديث الملف: " . $conn->error;
    }

    // إغلاق الاتصال بقاعدة البيانات
    $conn->close();
} else {
    // إعادة التوجيه إلى صفحة العميل في حالة عدم استخدام النموذج الصحيح
    header("Location: admin_profile.php");
    exit;
}
?>
