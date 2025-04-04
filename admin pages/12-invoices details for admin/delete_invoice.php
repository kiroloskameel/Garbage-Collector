<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// التحقق من وجود طلب POST لحذف البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_btn"]) && isset($_POST["invoice_id"])) {
    $invoice_id = $_POST["invoice_id"];
    
    // استعداد الاستعلام لحذف البيانات
    $delete_sql = "DELETE FROM invoices WHERE id = $invoice_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "تم حذف البيانات بنجاح.";
    } else {
        echo "حدث خطأ أثناء حذف البيانات: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
