<?php
// teacher_question_pages/fetch_questions_for_assessment.php

session_start();
include '../db_config.php';

// Security: Must be logged in as teacher
if (!isset($_SESSION['teacher_id'])) {
    http_response_code(403);
    echo "<p class='text-danger'>Unauthorized access.</p>";
    exit;
}

$topic_id = (int)($_GET['topic_id'] ?? 0);
if ($topic_id <= 0) {
    echo "<p class='text-muted'>Please select a valid topic.</p>";
    exit;
}

// Use prepared statement - THIS FIXES THE 500 ERROR
$stmt = $conn->prepare("
    SELECT qq.id, 
           qq.question_text, 
           qq.question_type, 
           i.instruction
    FROM quiz_questions qq
    JOIN instructions i ON qq.instruction_id = i.id
    WHERE i.topic_id = ?
    ORDER BY qq.id ASC
");

if (!$stmt) {
    // Log error instead of crashing
    error_log("Prepare failed in fetch_questions_for_assessment.php: " . $conn->error);
    echo "<p class='text-danger'>Database error. Please try again later.</p>";
    exit;
}

$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-muted'>No questions found for this topic.</p>";
    $stmt->close();
    exit;
}

echo '<h6 class="mt-3">Select Questions <small class="text-muted">(all checked by default)</small></h6>';
echo '<div class="checkbox-list">';

while ($q = $result->fetch_assoc()) {
    $question_text = $q['question_text'] ?: 'Question ID: ' . $q['id'];
    $instruction = $q['instruction'] ?: 'No instruction';

    echo '<label class="d-block mb-2 border-bottom pb-2">';
    echo '<input type="checkbox" name="questions[]" value="' . $q['id'] . '" checked> ';
    echo '<strong>' . htmlspecialchars($question_text, ENT_QUOTES) . '</strong> ';
    echo '<span class="badge bg-info ms-2">' . htmlspecialchars($q['question_type']) . '</span>';
    echo '<small class="text-muted d-block">' . htmlspecialchars($instruction) . '</small>';
    echo '</label>';
}

echo '</div>';
echo '<small class="text-muted">Uncheck any question you want to exclude from the assessment.</small>';

$stmt->close();
?>