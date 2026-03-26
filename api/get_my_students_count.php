<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['teacher_id']) || !isset($_SESSION['teacher_subject'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include '../db_config.php';

$subject = $_SESSION['teacher_subject'];

$sql = "SELECT COUNT(DISTINCT s.id) AS cnt 
        FROM students s
        INNER JOIN subjects sub ON s.grade = sub.grade 
        WHERE sub.subject_name = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Query failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $subject);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$count = (int)$row['cnt'];

echo json_encode([
    'success' => true,
    'data' => [
        'count' => $count,
        'trend' => $count > 0 ? '+'.$count.' this month' : ''
    ]
]);

$stmt->close();
?>