<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// التحقق من وجود طلب POST لتحديث الفاتورة
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceId = $_POST["invoice_id"];
    $collectionDays = $_POST["collectionDays"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $zone = $_POST["zone"];
    $packagePrice = $_POST["packagePrice"];
    $createdAt = $_POST["createdAt"];
    $packageExpiryDate = $_POST["packageExpiryDate"];

    // استعداد الاستعلام لتحديث الفاتورة
    $update_sql = "UPDATE invoices SET collection_days='$collectionDays', name='$name', email='$email', zone='$zone', package_price='$packagePrice', created_at='$createdAt', package_expiry_date='$packageExpiryDate' WHERE id = $invoiceId";

    // تنفيذ الاستعلام
    if ($conn->query($update_sql) === TRUE) {
        echo "تم تحديث الفاتورة بنجاح";
    } else {
        echo "حدث خطأ أثناء تحديث الفاتورة: " . $conn->error;
    }
}

// التحقق من وجود طلب POST لحذف الفاتورة
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_btn"]) && isset($_POST["invoice_id"])) {
    $invoiceId = $_POST["invoice_id"];
    
    // استعداد الاستعلام لحذف الفاتورة
    $delete_sql = "DELETE FROM invoices WHERE id = $invoiceId";

    if ($conn->query($delete_sql) === TRUE) {
        echo "تم حذف الفاتورة بنجاح.";
    } else {
        echo "حدث خطأ أثناء حذف الفاتورة: " . $conn->error;
    }
}

// إغلاق اتصال قاعدة البيانات
$conn->close();
?>
