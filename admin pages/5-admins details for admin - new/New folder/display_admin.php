<?php
// معلومات الاتصال بقاعدة البيانات
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// التحقق من دور المستخدم
session_start();
if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] !== 'admin') {
    // عرض رسالة بأنه لا توجد بيانات للعملاء
    echo "No admins data available.";
    exit;
}




// الاستعلام لجلب بيانات العملاء فقط
$sql = "SELECT user_id, username, email, password, address, phone FROM users WHERE  ROLE = 'admin'";
$result = $conn->query($sql);

$rows = array(); // Initialize an array to store the rows

if ($result->num_rows > 0) {
    // Loop through each row and add it to the $rows array
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    // عرض رسالة بأنه لا توجد بيانات للعملاء
    echo "No admins data available.";
}

// Close the database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($rows); // Encode the array as JSON and echo it
?>
