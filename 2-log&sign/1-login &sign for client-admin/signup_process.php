<?php
// تفعيل عرض الأخطاء في حالة وجودها
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// استقبال البيانات من النموذج
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$zone = $_POST['zone'] ?? '';
$role = 'client'; 

$response = array();

// تحقق من صحة البيانات
if (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
    $response['success'] = false;
    $response['message'] = "Invalid username.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['success'] = false;
    $response['message'] = "Invalid email.";
} elseif (strlen($password) < 6) {
    $response['success'] = false;
    $response['message'] = "Password must be at least 6 characters.";
} elseif (!preg_match("/^\d{11}$/", $phone)) {
    $response['success'] = false;
    $response['message'] = "Invalid phone number.";
} else {
    // التحقق مما إذا كان المستخدم مسجل بالفعل
    $sql_check_user = "SELECT * FROM users WHERE email = ?";
    $stmt_check_user = $conn->prepare($sql_check_user);
    $stmt_check_user->bind_param("s", $email);
    $stmt_check_user->execute();
    $result_check_user = $stmt_check_user->get_result();

    if ($result_check_user->num_rows > 0) {
        $response['success'] = false;
        $response['message'] = "This user is already registered.";
    } else {
        // إدخال بيانات المستخدم في قاعدة البيانات
        $sql_insert_user = "INSERT INTO users (username, email, password, address, phone, Zone, ROLE) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bind_param("sssssss", $username, $email, $password, $address, $phone, $zone, $role);

        if ($stmt_insert_user->execute()) {
            $response['success'] = true;
            $response['message'] = "User registered successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Error: " . $stmt_insert_user->error;
        }
        $stmt_insert_user->close();
    }
    $stmt_check_user->close();
}

// إرجاع الرد ك JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
