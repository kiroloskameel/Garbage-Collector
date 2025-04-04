<?php
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

$data = json_decode(file_get_contents('php://input'), true);

// Debug statement to log received data
error_log(print_r($data, true));

// Check if data is received and valid
if (isset($data['id']) && isset($data['type'])) {
    $id = $data['id'];
    $type = $data['type'];

    // Debug statement to confirm variables
    error_log("ID: $id, Type: $type");

    // Prepare and execute SQL statement based on type
    if ($type == 'single' || $type == 'monthly') {
        $stmt_update = $conn->prepare("UPDATE invoices SET status = 'collected' WHERE id = ?");
        $stmt_update->bind_param('i', $id);
    } elseif ($type == 'smart_bin') {
        $stmt_update = $conn->prepare("UPDATE bin SET status = 'collected' WHERE Bin_id = ?");
        $stmt_update->bind_param('i', $id);
    } elseif ($type == 'regular') {
        $stmt_update = $conn->prepare("UPDATE invoices SET status = 'collected', collected_day = CURDATE() WHERE id = ?");
        $stmt_update->bind_param('i', $id);
    } else {
        error_log("Invalid type: $type"); // Added more informative debug statement
        echo json_encode(array('success' => false, 'message' => 'Invalid type'));
        $conn->close();
        exit();
    }

    // Execute the prepared statement
    if ($stmt_update->execute()) {
        echo json_encode(array('success' => true));
    } else {
        error_log("Failed to update status for ID: $id, Type: $type"); // Added debug statement
        echo json_encode(array('success' => false, 'message' => 'Failed to update status'));
    }

    // Close the prepared statement and database connection
    $stmt_update->close();
    $conn->close();
} else {
    error_log("Invalid data received: " . print_r($data, true)); // Added debug statement
    echo json_encode(array('success' => false, 'message' => 'Invalid data'));
    $conn->close();
}
?>
