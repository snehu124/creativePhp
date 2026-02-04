<?php
session_start();
include "../db_config.php";

// Agar login nahi hai to block karo
if(!isset($_SESSION['student_email'])){
    http_response_code(403);
    die("Unauthorized access");
}

$student_id = $_SESSION['student_id'];
$topic_id   = $_GET['topic_id'] ?? 0;

// Check karo ki student ko topic access hai ya nahi
$sql = "SELECT topics.file_path 
        FROM topics
        JOIN student_subjects ss ON ss.subject_id = topics.subject_id
        WHERE ss.student_id = ? AND topics.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $student_id, $topic_id);
$stmt->execute();
$result = $stmt->get_result();

if(!$row = $result->fetch_assoc()){
    http_response_code(403);
    die("Unauthorized access");
}

$file_path = "/home4/mrmukpe4/secure_files/" . $row['file_path'];

// Agar file exist karti hai to stream karo
if(file_exists($file_path)){
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=\"" . basename($file_path) . "\"");
    header("Content-Length: " . filesize($file_path));
    readfile($file_path);
    exit();
} else {
    http_response_code(404);
    echo "File not found.";
}
