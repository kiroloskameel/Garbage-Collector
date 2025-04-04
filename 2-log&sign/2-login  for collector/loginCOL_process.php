<?php
session_start();

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM collector WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['zone'] = $row['zone'];

        $zone = $row['zone'];
        $bin_sql = "SELECT * FROM bin WHERE zone='$zone'";
        $bin_result = $conn->query($bin_sql);
        $bins = array();
        if ($bin_result->num_rows > 0) {
            while ($bin_row = $bin_result->fetch_assoc()) {
                $bins[] = $bin_row;
            }
        }

        echo json_encode(array("success" => true, "zone" => $zone, "bins" => $bins));
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid email or password"));
    }
}

$conn->close();
?>
