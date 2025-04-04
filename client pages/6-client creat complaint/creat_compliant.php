<?php
// معلومات الاتصال بقاعدة البيانات
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');


// احصل على البيانات المرسلة من النموذج
$name = $_POST['name'];
$email = $_POST['email'];
$complaint = $_POST['complaint'];

// قم بتنفيذ استعلام SQL لحفظ الشكوى في قاعدة البيانات
$sql = "INSERT INTO complaints (name, email, complaint) VALUES ('$name', '$email', '$complaint')";

// قم بتنفيذ الاستعلام
// إذا كان لديك اتصال مثالي بقاعدة البيانات وتحقق من نجاح التنفيذ
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Complaint submitted successfully");
    window.location.href = "http://localhost:8080/garbage%20mangement%20project/client%20pages/6-client%20creat%20complaint/";
   </script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// اغلق الاتصال بقاعدة البيانات هنا إذا كنت تستخدمه
?>
