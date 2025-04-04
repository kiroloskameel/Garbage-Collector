<?php
$servername = "localhost";
$username = "mostafa";
$password = "mostafa_932003";
$dbname = "garbage collection";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sensorId = $_POST['sensorId'];
    $distance = $_POST['distance'];

    $sql = "SELECT * FROM sensor_data WHERE id = $sensorId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $updateSql = "UPDATE sensor_data SET distance = $distance WHERE id = $sensorId";
        if ($conn->query($updateSql) === TRUE) {
            echo "Distance updated successfully.";
        } else {
            echo "Error updating distance: " . $conn->error;
        }
    } else {
        echo "Sensor ID not found.";
    }
}

$conn->close();
?>
