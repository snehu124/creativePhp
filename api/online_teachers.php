<?php
include '../db_config.php';
header('Content-Type: application/json');

// Active threshold time - last 5 minutes
$threshold = date("Y-m-d H:i:s", strtotime("-5 minutes"));

// Query to count teachers active in last 5 minutes
$sql = "SELECT COUNT(*) AS online_count FROM teachers WHERE last_activity >= '$threshold'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        "success" => true,
        "data" => (int)$row['online_count']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}
?>
