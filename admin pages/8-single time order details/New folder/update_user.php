<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $zone = $_POST["zone"];
    $phone = $_POST["phone"];

    $update_sql = "UPDATE invoices SET name='$username', email='$email', address='$address', zone='$zone', phone='$phone' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$conn->close();
?>
