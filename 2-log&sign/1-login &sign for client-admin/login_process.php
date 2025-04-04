<?php
session_start();

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $role = $user['ROLE'];
    if ($role == 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: http://localhost:8080/garbage%20mangement%20project/admin%20pages/1-admin%20dashboard/");
        exit;
    } else {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: http://localhost:8080/garbage%20mangement%20project/client%20pages/1-client%20dashbord/INDEX%20CLIENT.php");
        exit;
    }
  } else {
    // فشل تسجيل الدخول
    echo json_encode(array("success" => false, "message" => "Invalid email or password"));
    exit;
  }
}
?>
