<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');
// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_btn"]) && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
    
    // Prepare delete statement
    $delete_sql = "DELETE FROM users WHERE user_id = $user_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "تم حذف البيانات بنجاح.";
    } else {
        echo "حدث خطأ أثناء حذف البيانات: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
