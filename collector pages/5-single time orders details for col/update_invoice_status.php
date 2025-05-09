<?php
session_start();
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $invoiceId = $data['invoiceId'];

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $status = '';

    $stmt_check = $conn->prepare("SELECT status FROM invoices WHERE id = ?");
    $stmt_check->bind_param('i', $invoiceId);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
      $stmt_check->bind_result($currentStatus);
      $stmt_check->fetch();

      $status = ($currentStatus === 'collected') ? 'not collected' : 'collected';

      $stmt_check->close();

      $stmt_update = $conn->prepare("UPDATE invoices SET status = ? WHERE id = ?");
      $stmt_update->bind_param('si', $status, $invoiceId);

      if ($stmt_update->execute()) {
        echo json_encode(array("success" => true, "status" => $status));
      } else {
        echo json_encode(array("success" => false, "message" => "Failed to update invoice status"));
      }

      $stmt_update->close();
    } else {
      echo json_encode(array("success" => false, "message" => "Invoice not found"));
    }

    $conn->close();
  } else {
    echo json_encode(array("success" => false, "message" => "Not logged in"));
  }
} else {
  echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
