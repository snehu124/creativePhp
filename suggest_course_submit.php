<?php
session_start();
include 'db_config.php';

$teacher_id = $_SESSION['teacher_id'] ?? null;
$subject_id = $_POST['subject_id'] ?? null;
$suggestion = $_POST['suggestion'] ?? null;

if (!$teacher_id || !$subject_id || !$suggestion) {
    die("Missing fields.");
}

$sql = "INSERT INTO course_suggestions (teacher_id, subject_id, suggestion) 
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $teacher_id, $subject_id, $suggestion);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Suggestion submitted successfully'); window.location='suggest_course.php';</script>";
} else {
    echo "Error submitting suggestion.";
}
?>
