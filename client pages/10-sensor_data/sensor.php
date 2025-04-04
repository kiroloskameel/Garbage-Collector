<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// استعلام لاسترداد أحدث قيمة المسافة من جدول sensor_data
$sql = "SELECT distance FROM sensor_data ORDER BY data_sending_time DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $distance = $row["distance"];
} else {
    $distance = "N/A";
}

mysqli_close($conn);
echo $distance;
?>
