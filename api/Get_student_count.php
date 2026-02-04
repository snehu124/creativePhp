<?php
header('Content-Type: application/json');
require_once('../db_config.php');

$response = ['success' => false, 'data' => 0];

$sql = "SELECT COUNT(*) AS total FROM students";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $response['success'] = true;
    $response['data'] = (int)$row['total'];
}

echo json_encode($response);
?>
