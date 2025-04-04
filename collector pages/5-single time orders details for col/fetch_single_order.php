<?php
session_start();
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// Check if the collector is logged in and get the zone from session
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $collector_zone = $_SESSION['zone'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, collection_date, name, email, zone, package_price, created_at, status FROM invoices WHERE service_package = 'one_time' AND zone = ?");
    $stmt->bind_param('s', $collector_zone);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array(); // Initialize an array to store the result
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row; // Store each row of the result
    }

    $stmt->close();
    echo json_encode($rows); // Convert the result array to JSON
} else {
    echo json_encode(array("error" => "Not logged in"));
}

$conn->close();
?>
