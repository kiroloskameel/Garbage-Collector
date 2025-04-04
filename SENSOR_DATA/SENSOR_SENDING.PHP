<?php

$hostname = "localhost"; 
$username = "mostafa";
$password = "mostafa_932003";
$database = "garbage collection";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) { 
    $response = array("status" => "error", "message" => "Connection failed: " . mysqli_connect_error());
    echo json_encode($response);
    exit(); 
} 

if(isset($_POST["distance"]) && isset($_POST["id"])) {

    $id = $_POST["id"];
    $d = $_POST["distance"];

    // التحقق مما إذا كان هناك سجل بالفعل مع ال "id" المحدد
    $check_sql = "SELECT * FROM bin WHERE Bin_id='$id'";
    $check_result = mysqli_query($conn, $check_sql);
    if(mysqli_num_rows($check_result) > 0) {
        // إذا وجد السجل، قم بتحديثه
        $currentTime = date("Y-m-d H:i:s");

        $update_sql = "UPDATE bin SET distance='$d', sending_time='$currentTime' WHERE Bin_id='$id'";

        if (mysqli_query($conn, $update_sql)) { 
            $response = array("status" => "success", "message" => "Record updated successfully");
        } else { 
            $response = array("status" => "error", "message" => "Error: " . $update_sql . "<br>" . mysqli_error($conn));
        }
    } else {
        $response = array("status" => "error", "message" => "No record found for id $id");
    }
} else {
    $response = array("status" => "error", "message" => "Invalid input");
}

echo json_encode($response);

?>
