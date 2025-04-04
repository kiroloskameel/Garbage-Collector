<?php
// معلومات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "mostafa";
$password = "mostafa_932003";
$dbname = "garbage collection";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
