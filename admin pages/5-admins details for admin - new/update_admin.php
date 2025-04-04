<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

    // Prepare update statement
    $update_sql = "UPDATE users SET username='$username', email='$email', address='$address', phone='$phone' WHERE user_id = $user_id";

    // Execute update
    if ($conn->query($update_sql) === TRUE) {
        echo "admin updated successfully";
    } else {
        echo "Error updating admin: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
