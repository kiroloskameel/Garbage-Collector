<?php

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');


// استعلام للحصول على عدد collectors
$sql_collectors = "SELECT COUNT(collector_id) AS collector_count FROM collector";
$result_collectors = $conn->query($sql_collectors);
$collector_count = $result_collectors->num_rows > 0 ? $result_collectors->fetch_assoc()['collector_count'] : 0;

// استعلام للحصول على عدد المناطق الفريدة
$sql_zones = "SELECT COUNT(DISTINCT zone) AS zone_count FROM collector";
$result_zones = $conn->query($sql_zones);
$zone_count = $result_zones->num_rows > 0 ? $result_zones->fetch_assoc()['zone_count'] : 0;

// استعلام للحصول على عدد الـ Admins
$sql_admins = "SELECT COUNT(*) AS admin_count FROM users WHERE ROLE = 'admin'";
$result_admins = $conn->query($sql_admins);
$admin_count = $result_admins->num_rows > 0 ? $result_admins->fetch_assoc()['admin_count'] : 0;

// استعلام للحصول على عدد الـ monthly_income

$sql_income = "SELECT SUM(package_price) AS monthly_income FROM invoices WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$result_income = $conn->query($sql_income);
$monthly_income = $result_income->num_rows > 0 ? $result_income->fetch_assoc()['monthly_income'] : 0.0;

// استعلام للحصول على عدد الـ uncollected_bins

$sql_uncollected_bins = "SELECT COUNT(*) AS uncollected_bins_count FROM bin WHERE status = 'Not Collected'";
$result_uncollected_bins = $conn->query($sql_uncollected_bins);
$uncollected_bins_count = $result_uncollected_bins->num_rows > 0 ? $result_uncollected_bins->fetch_assoc()['uncollected_bins_count'] : 0;


// استعلام للحصول على عدد الـ collected_bins

$sql_collected_bins = "SELECT COUNT(*) AS collected_bins_count FROM bin WHERE status = 'Collected'";
$result_collected_bins = $conn->query($sql_collected_bins);
$collected_bins_count = $result_collected_bins->num_rows > 0 ? $result_collected_bins->fetch_assoc()['collected_bins_count'] : 0;

echo json_encode([
    'collector_count' => $collector_count,
    'zone_count' => $zone_count,
    'admin_count' => $admin_count, 
    'monthly_income' => $monthly_income,
    'uncollected_bins_count' => $uncollected_bins_count,
    'collected_bins_count' => $collected_bins_count

]);


$conn->close();
?>
