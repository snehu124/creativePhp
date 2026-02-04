<?php
session_start();
header('Content-Type: application/json');
include 'db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$title = $_POST['title'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$description = $_POST['description'] ?? '';

if (!$title || !$date || !$time) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
    exit;
}

$datetime = $date . ' ' . $time;
$stmt = $conn->prepare("INSERT INTO classes (teacher_id, title, description, class_datetime) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $teacher_id, $title, $description, $datetime);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Class saved successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save class.']);
}
?>
