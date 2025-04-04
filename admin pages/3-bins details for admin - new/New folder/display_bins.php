<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// الاستعلام لجلب البيانات
$sql = "SELECT Bin_id, binOwner , capacity, zone, address, distance FROM bin";
$result = $conn->query($sql);

$data = []; // مصفوفة لتخزين البيانات

if ($result->num_rows > 0) {
    // جلب البيانات وتخزينها في المصفوفة
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = "0 results";
}

// إغلاق اتصال قاعدة البيانات
$conn->close();

// تحويل المصفوفة إلى JSON وطباعتها
echo json_encode($data);
?>
