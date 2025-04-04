<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// Check user role
session_start();
if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] !== 'client') {
    // Display a message if no client data available
    echo "No clients data available.";
    exit;
}

// SQL query to retrieve client data along with service package from invoices table
$sql = "SELECT u.user_id, u.username, u.email, u.password, u.address, u.phone, i.service_package
        FROM users u
        INNER JOIN invoices i ON u.email = i.email
        WHERE u.ROLE = 'client'";

$result = $conn->query($sql);

$rows = array(); // Initialize an array to store the rows

if ($result->num_rows > 0) {
    // Loop through each row and add it to the $rows array
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    // Display a message if no client data available
    echo "No clients data available.";
}

// Close the database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($rows); // Encode the array as JSON and echo it
?>
