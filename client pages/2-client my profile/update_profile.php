<?php
session_start();

// التحقق من إرسال البيانات بواسطة طريقة POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تأكيد تضمين ملف الاتصال بقاعدة البيانات
    include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

    // استقبال البيانات المحدثة من النموذج
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $zone = $_POST['zone'];
    // ازالة Selected Package من الاستعلام
    $sql = "UPDATE users SET username='$username', email='$email', address='$address', phone='$phone', Zone='$zone' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        
        echo '<script>alert("update your profile successfully");
        window.location.href = "INDEX CLIENT.php";
       </script>';
    } else {
        echo "حدث خطأ أثناء تحديث الملف: " . $conn->error;
    }

    // إغلاق الاتصال بقاعدة البيانات
    $conn->close();
} else {
    // إعادة التوجيه إلى صفحة العميل في حالة عدم استخدام النموذج الصحيح
    header("Location: client_profile.php");
    exit;
}
?>
