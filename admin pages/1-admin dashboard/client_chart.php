<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// الحصول على رقم الشهر الحالي
$currentMonth = date('m');

// استعلام SQL
$sql = "SELECT DAY(signup_date) AS registration_day, COUNT(*) AS client_count
        FROM users
        WHERE ROLE = 'client' AND MONTH(signup_date) = $currentMonth
        GROUP BY DAY(signup_date)
        ORDER BY signup_date";

$result = $conn->query($sql);

// إنشاء مصفوفة لتخزين البيانات
$data = array();

// فحص وعرض النتائج إذا كانت هناك صفوف
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// إرجاع البيانات بتنسيق JSON
echo json_encode($data);

// إغلاق الاتصال
$conn->close();
?>
