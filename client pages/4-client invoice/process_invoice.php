<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

session_start();

// تحقق من تسجيل دخول المستخدم كعميل
if (isset($_SESSION['loggedin']) && isset($_SESSION['role']) && $_SESSION['loggedin'] && $_SESSION['role'] == 'client') {
    // استخدم بيانات المستخدم المخزنة في الجلسة لملء حقول معلومات المستخدم
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
}

// التحقق مما إذا كان النموذج قد تم إرساله
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جمع بيانات النموذج من $_POST
    $service_package = $_POST["service_package"];
    $collection_days = isset($_POST["collection_day"]) ? implode(",", $_POST["collection_day"]) : "";
    $collection_date = $_POST["collection_date"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $address = $_POST["address"];
    $zone = $_POST["Zone"];
    $street = $_POST["street"];
    $house_number = $_POST["house_number"];
    $postcode = $_POST["postcode"];
    $package_price = $_POST["package_price"]; // تمرير قيمة package_price

    // تحديد تاريخ انتهاء الباقة (بعد 30 يومًا من تاريخ التسجيل)
    $expiry_date = date('Y-m-d', strtotime($collection_date . ' + 30 days'));

    // التحقق مما إذا كان المستخدم مسجل بالفعل بواسطة البريد الإلكتروني
    $sql_check_email = "SELECT * FROM invoices WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // يوجد بالفعل مستخدم مسجل بنفس البريد الإلكتروني
        while ($row = mysqli_fetch_assoc($result_check_email)) {
            $existing_package = $row['service_package'];
            $package_expiry_date = $row['package_expiry_date'];
    
            // التحقق من أن الباقة المسجل بها هي VIP Monthly Collection with smart bin أو Regular Monthly Collection
            if (($existing_package == 'VIP Monthly Collection with smart bin' || $existing_package == 'Regular Monthly Collection') && $package_expiry_date != null && $package_expiry_date >= date('Y-m-d')) {
                // موعد انتهاء الباقة لم ينته بعد
                echo "User is already subscribed to VIP or Regular package and package has not expired yet.";
                exit; // انهاء التنفيذ بعد اظهار الرسالة
            }
        }
    }
    
    // تحقق من عدم تعريف الدالة قبل تعريفها
    if (!function_exists('insertInvoice')) {
        // دالة إدراج الفاتورة في قاعدة البيانات
        function insertInvoice($conn, $service_package, $collection_days, $collection_date, $name, $email, $password, $address, $zone, $street, $house_number, $postcode, $expiry_date, $package_price) {
            // استعد الاستعلام لإدراج البيانات في قاعدة البيانات مع تضمين تاريخ انتهاء الباقة وسعر الباقة
            $sql = "INSERT INTO invoices (service_package, collection_days, collection_date, name, email, password, address, zone, street, house_number, postcode, package_expiry_date, package_price, status) 
                    VALUES ('$service_package', '$collection_days', '$collection_date', '$name', '$email', '$password', '$address', '$zone', '$street', '$house_number', '$postcode', '$expiry_date', '$package_price', 'not collected')";

            // قم بتنفيذ الاستعلام
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Invoice created successfully");
                 window.location.href = "index.html";
                </script>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    // السماح بالتسجيل
    insertInvoice($conn, $service_package, $collection_days, $collection_date, $name, $email, $password, $address, $zone, $street, $house_number, $postcode, $expiry_date, $package_price);

    // أغلق الاتصال بقاعدة البيانات
    mysqli_close($conn);
}
?>