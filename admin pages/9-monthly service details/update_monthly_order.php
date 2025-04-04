<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $collection_days = mysqli_real_escape_string($conn, $_POST["collection_days"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $zone = mysqli_real_escape_string($conn, $_POST["zone"]);
    $package_price = mysqli_real_escape_string($conn, $_POST["package_price"]);
    $created_at = mysqli_real_escape_string($conn, $_POST["created_at"]);
    $package_expiry_date = mysqli_real_escape_string($conn, $_POST["package_expiry_date"]); 

    $update_invoice_sql = "UPDATE invoices SET collection_days='$collection_days', name='$name', email='$email', zone='$zone', package_price='$package_price', created_at='$created_at', package_expiry_date='$package_expiry_date' WHERE id = $id";

    try {
        if ($conn->query($update_invoice_sql) === TRUE) {
            echo "Invoice data updated successfully";
        } else {
            throw new Exception("Error updating invoice: " . $conn->error);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    $conn->close();
} else {
    echo "Invalid request";
}
?>
