<?php
session_start();
// Connect to database
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// Get the collector's zone from session

// Fetch bins belonging to the collector's zone
$sql = "SELECT binOwner, capacity, address, distance FROM bin";
$result = $conn->query($sql);

$rows = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = ($row['distance'] > 70) ? 'NOT COLLECTED' : 'COLLECTED';
        $row['status'] = $status;
        $rows[] = $row;
    }
}

// Return JSON response
echo json_encode($rows);

$conn->close();
?>
