<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

include '../db_config.php';

$teacher_id = (int)$_SESSION['teacher_id'];

$sql = "SELECT s.subject_name 
        FROM teacher_subjects ts
        JOIN subjects s ON ts.subject_id = s.id
        WHERE ts.teacher_id = $teacher_id";

$res = mysqli_query($conn, $sql);

$data = [];
while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $data
]);