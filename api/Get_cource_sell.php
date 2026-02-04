<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../db_config.php';

$sql = "
    SELECT 
        COUNT(id) AS total_sales, 
        SUM(amount) AS total_revenue 
    FROM 
        course_sales
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    echo json_encode([
        'success' => true,
        'data' => [
            'count' => (int)$row['total_sales'],
            'revenue' => (float)$row['total_revenue']
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Database query failed'
    ]);
}
?>
