<?php
// معلومات الاتصال بقاعدة البيانات
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// التحقق من وجود طلب POST لتحديث البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $collector_id = $_POST["collector_id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $zone = $_POST["zone"];

    // استعداد الاستعلام لتحديث البيانات
    $update_sql = "UPDATE collector SET username='$username', email='$email', address='$address', phone='$phone', zone='$zone' WHERE collector_id = $collector_id";

    // تنفيذ الاستعلام
    if ($conn->query($update_sql) === TRUE) {
        echo "تم تحديث البيانات بنجاح";
    } else {
        echo "حدث خطأ أثناء تحديث البيانات: " . $conn->error;
    }
}

// إغلاق اتصال قاعدة البيانات
$conn->close();
?>