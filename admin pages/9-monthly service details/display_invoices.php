<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// الاستعلام لجلب البيانات
$stmt = $conn->prepare("SELECT id, collection_days, name, email, zone, package_price, created_at, package_expiry_date FROM invoices WHERE service_package = 'regular'");
$stmt->execute();
$result = $stmt->get_result();

$rows = array(); // Initialize an array to store the rows

if ($result->num_rows > 0) {
    // Loop through each row and add it to the $rows array
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($rows); // Encode the array as JSON and echo it
?>
