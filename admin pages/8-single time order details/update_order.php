<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $zone = mysqli_real_escape_string($conn, $_POST["zone"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]); 

    $update_user_sql = "UPDATE invoices SET name='$name', email='$email', zone='$zone', status='$status' WHERE id = $id";

    try {
        if ($conn->query($update_user_sql) === TRUE) {
            echo "User data updated successfully";
        } else {
            throw new Exception("Error updating user: " . $conn->error);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    $conn->close();
} else {
    echo "Invalid request";
}

?>
