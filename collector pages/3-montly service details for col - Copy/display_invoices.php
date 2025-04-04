<?php
session_start();
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// Check if the collector is logged in and get the zone from session
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $collector_zone = $_SESSION['zone'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, collection_days, name, email, zone, package_price, created_at, package_expiry_date FROM invoices WHERE service_package = 'regular' AND zone = ?");
    $stmt->bind_param('s', $collector_zone);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array(); // Initialize an array to store the rows

    if ($result->num_rows > 0) {
        // Loop through each row and add it to the $rows array
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        echo json_encode(array()); // Return an empty array if no results found
    }

    // Close the database connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json'); // Set the content type to JSON
    echo json_encode($rows); // Encode the array as JSON and echo it
} else {
    // If not logged in, return an error message
    echo json_encode(array("error" => "Not logged in"));
}
?>
