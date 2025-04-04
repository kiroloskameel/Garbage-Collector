<?php
session_start();

// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // تم تسجيل الدخول، قم بتضمين ملف الاتصال بقاعدة البيانات
    include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

    // استعراض بيانات العميل من قاعدة البيانات
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // عرض بيانات العميل
        $row = $result->fetch_assoc();
        
        // التحقق من دور المستخدم
        if ($row['ROLE'] === 'client') {
            // عرض بيانات العميل
            $email = $row['email'];
            $address = $row['address'];
            $phone = $row['phone'];
            $zone = $row['Zone'];
            
            // التحقق مما إذا كان المفتاح موجودًا قبل عرضه
            $selected_package = isset($row['selected_package']) ? $row['selected_package'] : "لا يوجد باقة محددة";
            
            // استعلام SQL لاسترداد بيانات الباقة المحجوزة
            $invoice_sql = "SELECT * FROM invoices WHERE email='$email'";
            $invoice_result = $conn->query($invoice_sql);

            if ($invoice_result->num_rows > 0) {
                $invoice_row = $invoice_result->fetch_assoc();
                
                // استرجاع بيانات الباقة المحجوزة اعتمادًا على نوع الباقة
                if ($selected_package === 'regular') {
                    $collection_days = $invoice_row['collection_days'];
                    $created_at = $invoice_row['created_at'];
                    $package_expiry_date = $invoice_row['package_expiry_date'];
                } elseif ($selected_package === 'vip') {
                    // استعلام SQL لاسترداد بيانات العميل من جدول invoices
                    $bin_sql = "SELECT distance FROM bin WHERE email='$email'";
                    $bin_result = $conn->query($bin_sql);
                    $bin_row = $bin_result->fetch_assoc();
                    
                    // استرجاع بيانات الباقة المحجوزة للباقة VIP
                    $distance = $bin_row['distance'];
                    $created_at = $invoice_row['created_at'];
                    $package_expiry_date = $invoice_row['package_expiry_date'];
                } elseif ($selected_package === 'one_time') {
                    $collection_date = $invoice_row['collection_date'];
                    $status = $invoice_row['status'];
                }
            }
        } else {
            // إعادة التوجيه إلى صفحة غير مصرح للوصول
            header("Location: http://localhost:8080/garbage%20mangement%20project/2-log&sign/1-login%20&sign%20for%20client-admin/login_user.html");
            exit;
        }
    } else {
        echo "لا يمكن العثور على بيانات العميل";
    }
} else {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد قام بتسجيل الدخول
    header("Location: http://localhost:8080/garbage%20mangement%20project/2-log&sign/1-login%20&sign%20for%20client-admin/login_user.html");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>crud dashboard</title>
</head>
<body>
<div class="col-md-3">
    <div class="services-box text-center border border-1 py-5">
        <div class="serviceMini-box mb-3">
            <div class="ser-icon">
                <i class="fa-solid fa-trash-can fs-2 mb-4 main-color"></i>
            </div>
            <h6 class="fw-bold main-color">MY SERVICE</h6>
        </div>
        <p class="m-auto text-muted"><?php echo $selected_package; ?></p>
        <?php if ($selected_package === 'regular'): ?>
            <p class="m-auto text-muted">Collection Days: <?php echo $collection_days; ?></p>
            <p class="m-auto text-muted">Created At: <?php echo $created_at; ?></p>
            <p class="m-auto text-muted">Package Expiry Date: <?php echo $package_expiry_date; ?></p>
        <?php elseif ($selected_package === 'vip'): ?>
            <p class="m-auto text-muted">Distance: <?php echo $distance; ?></p>
            <p class="m-auto text-muted">Created At: <?php echo $created_at; ?></p>
            <p class="m-auto text-muted">Package Expiry Date: <?php echo $package_expiry_date; ?></p>
        <?php elseif ($selected_package === 'one_time'): ?>
            <p class="m-auto text-muted">Collection Date: <?php echo $collection_date; ?></p>
            <p class="m-auto text-muted">Status: <?php echo $status; ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
