<?php
session_start();

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // Redirect the user to the login page if not logged in
  header("Location: http://localhost:8080/Zero%20Waste%20Website/2-login%20&sign%20for%20client-admin/login_user.html");
  exit;
}

// SQL query to retrieve complaints of the logged-in client
$email = $_SESSION['email'];
$sql = "SELECT * FROM complaints WHERE email='$email'";

$result = $conn->query($sql);

$complaints = array();

if ($result->num_rows > 0) {
    // Collect data into an array
    while($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
}

// Send data as JSON response
header('Content-Type: application/json');
echo json_encode($complaints);

// Close the database connection
$conn->close();
?>
