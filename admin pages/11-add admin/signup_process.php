<?php
$servername = "localhost";
$username = "yousssef";
$password = "f.b@c)TPO94c_WbW";
$dbname = "garbage collection";

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $zone = $_POST['zone'];

  // إضافة بيانات التسجيل إلى قاعدة البيانات
  $sql = "INSERT INTO users (username, email, password, address, phone, Zone)
  VALUES ('$username', '$email', '$password', '$address', '$phone', '$zone')";

  if ($conn->query($sql) === TRUE) {
    // تسجيل ناجح، قم بتحويل المستخدم إلى صفحة تسجيل الدخول
    echo json_encode(array("success" => true));
  } else {
    echo json_encode(array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error));
  }
}

$conn->close();
?>
