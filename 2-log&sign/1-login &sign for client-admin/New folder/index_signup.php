<?php
session_start(); // بدء الجلسة

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

$usernameError = $emailError = $passwordError = $addressError = $phoneError = $zoneError = "";

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$zone = $_POST['zone'] ?? '';
$role = 'client'; 

$valid = true;

// Validate username
if (strlen($username) < 3) {
    $usernameError = "Username must be at least 3 characters long";
    $valid = false;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = "Please enter a valid email address";
    $valid = false;
}

// Validate password
if (strlen($password) < 6) {
    $passwordError = "Password must be at least 6 characters long";
    $valid = false;
}

// Validate phone
if (!preg_match('/^\d{11}$/', $phone)) {
    $phoneError = "Phone number must be 11 digits";
    $valid = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($valid) {
        // التحقق من وجود البريد الإلكتروني في قاعدة البيانات
        $sql_check_user = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result_check_user = $conn->query($sql_check_user);

        if ($result_check_user->num_rows > 0) {
            $emailError = "This email is already registered";
        } else {
            // إضافة بيانات التسجيل إلى قاعدة البيانات
            $sql_insert_user = "INSERT INTO users (username, email, password, address, phone, Zone, ROLE) 
            VALUES ('$username', '$email', '$password', '$address', '$phone', '$zone', '$role')";

            if ($conn->query($sql_insert_user) === TRUE) {
                // تسجيل ناجح، تخزين رسالة النجاح في الجلسة
                $_SESSION['successMessage'] = "Client registered successfully!";
                header("Location: " . $_SERVER['PHP_SELF']); // Reload the page
                exit();
            } else {
                echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
            }
        }
    }
}

// عرض رسالة النجاح إذا كانت موجودة في الجلسة
$successMessage = "";
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']); // حذف الرسالة بعد العرض
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Sign Up</h2>
        <form id="signupForm" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <div class="error"><?php echo $usernameError; ?></div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <div class="error"><?php echo $emailError; ?></div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="error"><?php echo $passwordError; ?></div>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <div class="error"><?php echo $addressError; ?></div>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <div class="error"><?php echo $phoneError; ?></div>

            <label for="zone">Zone:</label>
            <input type="text" id="zone" name="zone" required>
            <div class="error"><?php echo $zoneError; ?></div>

            <button type="submit">Sign Up</button>
            <?php if (!empty($successMessage)) { echo '<div class="success">'.$successMessage.'</div>'; } ?>
        </form
