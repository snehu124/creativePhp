<?php
session_start();
include 'config.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

if (!isset($_POST['question_id'], $_POST['answer'], $_POST['chapter_id'])) {
    echo "Invalid request.";
    exit;
}

$question_id = intval($_POST['question_id']);
$selected_option = $_POST['answer'];
$chapter_id = intval($_POST['chapter_id']);

// Get question from DB
$q_stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE id = ?");
$q_stmt->bind_param("i", $question_id);
$q_stmt->execute();
$question = $q_stmt->get_result()->fetch_assoc();

if (!$question) {
    echo "Question not found.";
    exit;
}

// Check if correct
$correct_option = $question['correct_option'];
$is_correct = ($selected_option === $correct_option) ? 1 : 0;

// Save result in DB
$insert = $conn->prepare("INSERT INTO quiz_results (student_id, question_id, selected_option, is_correct, submitted_at) VALUES (?, ?, ?, ?, NOW())");
$insert->bind_param("iisi", $student_id, $question_id, $selected_option, $is_correct);
$insert->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-4 text-center">
        <?php if ($is_correct): ?>
            <h3 class="text-success">✅ Correct Answer!</h3>
        <?php else: ?>
            <h3 class="text-danger">❌ Incorrect Answer</h3>
            <p class="mt-3"><strong>Correct Answer:</strong> <?= $correct_option ?></p>
            <p><strong>Solution:</strong> <?= htmlspecialchars($question['solution_explanation']) ?></p>
        <?php endif; ?>

        <a href="chapter_view.php?chapter_id=<?= $chapter_id ?>" class="btn btn-primary mt-4">🔁 Try Another Question</a>
        <a href="chapter_list.php?subject_id=<?= $question['subject_id'] ?? 1 ?>" class="btn btn-secondary mt-2">⬅️ Back to Chapters</a>
    </div>
</div>
</body>
</html>
