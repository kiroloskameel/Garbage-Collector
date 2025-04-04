<?php
session_start();

// معلومات الاتصال بقاعدة البيانات
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// جلب البيانات من النموذج
$binOwner = $_POST['binOwner'];
$email = $_POST['email'];
$capacity = $_POST['capacity'];
$zone = $_POST['zone'];
$address = $_POST['address'];

// قيمة افتراضية لحقل distance
$default_distance = 0;

// استعداد الاستعلام لإدراج البيانات في جدول البيانات
$sql = "INSERT INTO bin (binOwner, email, capacity, zone, address, distance) 
        VALUES ('$binOwner', '$email', '$capacity', '$zone', '$address', '$default_distance')";

if ($conn->query($sql) === TRUE) {
    echo "تم تسجيل البيانات بنجاح.";   echo '<script>alert("The data has been recorded successfully");
    window.location.href = "http://localhost:8080/garbage%20mangement%20project/client%20pages/9-client%20form%20for%20smartBin%20service/";
   </script>';
    
} else {
    echo "حدث خطأ أثناء تسجيل البيانات: " . $conn->error;
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
