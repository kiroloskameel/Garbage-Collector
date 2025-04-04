
<?php
// معلومات الاتصال بقاعدة البيانات
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');
// إذا كانت الطلبية من نوع POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال البيانات من الطلب
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id']) && isset($data['admin_response'])) {
        // تحديث الرد في قاعدة البيانات
        $complaintId = $data['id'];
        $adminResponse = $data['admin_response'];
        $sql = "UPDATE complaints SET admin_response = '$adminResponse' WHERE id = $complaintId";

        if ($conn->query($sql) === TRUE) {
            // إرسال رد الاستجابة
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid data'));
    }
} else {
    // استعلم عن الشكاوي من قاعدة البيانات
    $sql = "SELECT * FROM complaints";
    $result = $conn->query($sql);

    $complaints = array();

    if ($result->num_rows > 0) {
        // إذا كان هناك نتائج، قم بتجميع البيانات في مصفوفة
        while($row = $result->fetch_assoc()) {
            $complaints[] = $row;
        }
    }

    // إرسال البيانات كاستجابة JSON
    header('Content-Type: application/json');
    echo json_encode($complaints);
}

// أغلق اتصال قاعدة البيانات هنا إذا كنت تستخدمه
?>