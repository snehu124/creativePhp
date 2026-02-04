<?php
include '../db_config.php';
session_start();

if (!isset($_SESSION['teacher_id'])) {
    exit('Unauthorized access.');
}

$id = $_POST['id'] ?? 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM quiz_questions WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "✅ Question deleted successfully.";
    } else {
        echo "❌ Failed to delete question.";
    }
} else {
    echo "Invalid request.";
}
?>
