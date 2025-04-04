<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// التحقق من وجود طلب POST لتحديث الفاتورة
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceId = $_POST["invoice_id"];
    $collectionDate = $_POST["collectionDate"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $zone = $_POST["zone"];
    $packagePrice = $_POST["packagePrice"];
    $createdAt = $_POST["createdAt"];

    // استعداد الاستعلام لتحديث الفاتورة
    $update_sql = "UPDATE invoices SET collection_date='$collectionDate', name='$name', email='$email', zone='$zone', package_price='$packagePrice', created_at='$createdAt' WHERE id = $invoiceId";

    // تنفيذ الاستعلام
    if ($conn->query($update_sql) === TRUE) {
        echo "تم تحديث الفاتورة بنجاح";
    } else {
        echo "حدث خطأ أثناء تحديث الفاتورة: " . $conn->error;
    }
}

// إغلاق اتصال قاعدة البيانات
$conn->close();
?>
