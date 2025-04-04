<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

$sql = "INSERT INTO contact us. (Name, Email, Message) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);

$formData = json_decode(file_get_contents('php://input'), true);

$stmt->bind_param("sss", $formData['name'], $formData['email'], $formData['message']);

if ($stmt->execute() === TRUE) {
  echo "تم إنشاء سجل شكوى جديد بنجاح";
} else {
  echo "خطأ: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();

?>