<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include '../db_config.php';
$tid = (int)$_SESSION['teacher_id'];

$limit = isset($_GET['limit']) && $_GET['limit'] == 'all' ? 50 : 3;   // Default 3, or all

$sql = "SELECT 
            login_time,
            logout_time,
            TIMESTAMPDIFF(MINUTE, created_at, NOW()) AS mins 
        FROM teacher_activity_logs 
        WHERE teacher_id = ?
        ORDER BY created_at DESC 
        LIMIT ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $tid, $limit);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $desc = "Logged in at " . date("d M Y, h:i A", strtotime($row['login_time']));
    if (!empty($row['logout_time'])) {
        $desc .= " and logged out at " . date("h:i A", strtotime($row['logout_time']));
    }
    
    $time_ago = $row['mins'] < 60 
        ? $row['mins'] . ' min ago' 
        : floor($row['mins']/60) . ' hr ago';

    $data[] = [
        'description' => $desc,
        'time_ago' => $time_ago
    ];
}

echo json_encode([
    'success' => true,
    'data' => $data,
    'has_more' => ($limit === 3 && count($data) === 3)  // Show "Read More" if we limited to 3
]);

$stmt->close();
?>