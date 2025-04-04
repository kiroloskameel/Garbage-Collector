<?php
// معلومات الاتصال بقاعدة البيانات
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bin_id = $_POST["bin_id"];
    $binOwner = $_POST["binOwner"];
    $capacity = $_POST["capacity"];
    $zone = $_POST["zone"];
    $address = $_POST["address"];
    $distance = $_POST["distance"];

    // Prepare update statement
    $update_sql = "UPDATE bin SET binOwner='$binOwner', capacity='$capacity', zone='$zone', address='$address', distance='$distance' WHERE Bin_id = $bin_id";

    // Execute update
    if ($conn->query($update_sql) === TRUE) {
        echo "Bin updated successfully";
    } else {
        echo "Error updating bin: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>