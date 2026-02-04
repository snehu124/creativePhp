<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

include '../db_config.php';

$sql = "SELECT COUNT(*) AS total_teachers FROM teachers";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'data' => $row['total_teachers']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Database query failed'
    ]);
}
