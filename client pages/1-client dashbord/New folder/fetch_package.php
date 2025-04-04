<?php
    include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');


// الحصول على البريد الإلكتروني من الطلب
$email = isset($_POST['email']) ? $_POST['email'] : '';

if ($email) {
    // تحضير استعلام SQL
    $stmt = $conn->prepare("SELECT service_package FROM invoices WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($service_package);
    
    if ($stmt->fetch()) {
        echo "الباقة المحجوزة: " . htmlspecialchars($service_package);
    } else {
        echo "لا توجد باقة محجوزة لهذا البريد الإلكتروني.";
    }
    
    $stmt->close();
} else {
    echo "الرجاء إدخال بريد إلكتروني صحيح.";
}

$conn->close();
?>
