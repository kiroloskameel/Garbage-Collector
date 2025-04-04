<?php
session_start();
include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $collector_zone = $_SESSION['zone'];
    $today = date('l'); // Get today's day of the week

    // Fetch single orders not collected
    $stmt_single = $conn->prepare("SELECT id, name, email, zone, address, 'not collected' AS status, 'single' AS type, '--' AS `Fill Percentage` FROM invoices WHERE service_package = 'one_time' AND status = 'not collected' AND zone = ?");
    $stmt_single->bind_param('s', $collector_zone);
    $stmt_single->execute();
    $result_single = $stmt_single->get_result();

    $rows = array();
    while ($row = $result_single->fetch_assoc()) {
        $rows[] = $row;
    }

    // Fetch smart bins with calculated fill percentage > 65%
    $stmt_bins = $conn->prepare("
        SELECT 
            Bin_id AS id, 
            binOwner, 
            email, 
            zone, 
            address, 
            distance, 
            status, 
            'smart_bin' AS type, 
            CASE 
                WHEN (52 - distance) / 52 * 100 > 65 
                THEN CONCAT(ROUND((52 - distance) / 52 * 100), '%') 
                ELSE '--' 
            END AS `Fill Percentage` 
        FROM bin 
        WHERE zone = ? 
          AND distance <= 52 
          AND (52 - distance) / 52 * 100 > 65
    ");
    $stmt_bins->bind_param('s', $collector_zone);
    $stmt_bins->execute();
    $result_bins = $stmt_bins->get_result();

    while ($row = $result_bins->fetch_assoc()) {
        $rows[] = $row;
    }

    // Fetch monthly orders based on today's day that are not collected
    $stmt_monthly = $conn->prepare("SELECT id, name, email, zone, address, collection_days, 'not collected' AS status, 'monthly' AS type, '--' AS `Fill Percentage` FROM invoices WHERE service_package = 'regular' AND status = 'not collected' AND zone = ?");
    $stmt_monthly->bind_param('s', $collector_zone);
    $stmt_monthly->execute();
    $result_monthly = $stmt_monthly->get_result();

    while ($row = $result_monthly->fetch_assoc()) {
        $collection_days = explode('-', trim($row['collection_days'], '()'));
        if (in_array($today, $collection_days)) {
            $rows[] = $row;
        }
    }

    $stmt_single->close();
    $stmt_bins->close();
    $stmt_monthly->close();
    $conn->close();

    echo json_encode($rows);
} else {
    echo json_encode(array('error' => 'Not logged in'));
}
?>
