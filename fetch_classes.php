<?php
session_start();
header('Content-Type: application/json');
include 'db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    echo json_encode([]);
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

// Fetch all classes of the logged-in teacher
$sql = "SELECT id, title, description, class_datetime FROM classes WHERE teacher_id = ? ORDER BY class_datetime ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['class_datetime'], // FullCalendar needs 'start' key
        'description' => $row['description']
    ];
}

echo json_encode($events);
