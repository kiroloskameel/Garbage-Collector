<?php
// اتصال بقاعدة البيانات (قم بتغيير المعلومات وفقًا لموقعك)
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// تحقق مما إذا كانت هناك متغيرات مرسلة بالطلب
if (isset($_GET['id'])) {
    $invoiceId = $_GET['id'];

    // استعلام لاسترداد البيانات للفاتورة المحددة
    $sql = "SELECT * FROM invoices WHERE id = $invoiceId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // استرداد البيانات كمصفوفة متعددة الأبعاد
        $invoiceData = $result->fetch_assoc();

        // إغلاق اتصال قاعدة البيانات
        $conn->close();

        // إعداد البيانات بتنسيق JSON للعرض
        header('Content-Type: application/json');
        echo json_encode($invoiceData);
    } else {
        echo json_encode(["error" => "Invoice not found!"]);
    }
} else {
    echo json_encode(["error" => "Invalid request!"]);
}

?>
