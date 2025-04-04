<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// استعلام لجلب البيانات
$stmt = $conn->prepare("SELECT id, collection_date, name, email, zone, package_price, created_at, status FROM invoices WHERE service_package = 'one_time'");
$stmt->execute();
$result = $stmt->get_result();

$rows = array(); // تهيئة مصفوفة لتخزين الصفوف

if ($result->num_rows > 0) {
    // حلق عبر كل صف وأضفه إلى مصفوفة $rows
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    echo "0 نتائج";
}

// إغلاق اتصال قاعدة البيانات
$stmt->close();
$conn->close();

// إرجاع الاستجابة بصيغة JSON
header('Content-Type: application/json'); // تعيين نوع المحتوى إلى JSON
echo json_encode($rows); // ترميز المصفوفة ك JSON وطباعتها
?>
