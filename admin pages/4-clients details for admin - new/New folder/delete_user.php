<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_btn"]) && isset($_POST["id"])) {
    $id = $_POST["id"];
    
    $delete_sql = "DELETE FROM invoices WHERE id = $id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "تم حذف البيانات بنجاح.";
    } else {
        echo "حدث خطأ أثناء حذف البيانات: " . $conn->error;
    }
}

$conn->close();
?>
