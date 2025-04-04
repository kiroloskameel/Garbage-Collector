<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');


$sql = "SELECT service_package, COUNT(*) as user_count FROM invoices GROUP BY service_package";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Add header row
    $data[] = ['Service Package', 'Number of Users'];
    // Fetch rows
    while($row = $result->fetch_assoc()) {
        $data[] = [$row['service_package'], (int)$row['user_count']];
    }
} else {
    echo "0 results";
}
$conn->close();

echo json_encode($data);
?>
