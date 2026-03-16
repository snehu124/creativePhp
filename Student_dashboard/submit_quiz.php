<?php
session_start();
include "../db_config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check login
if (!isset($_SESSION['student_id'])) {
    header("Location: student_dashboard.php");
    exit();
}
$student_id = $_SESSION['student_id'];

// Validate request
if (!isset($_POST['submit_quiz'])) {
    echo "Invalid Request (submit_quiz missing)<br>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
}

$quiz_id = intval($_POST['quiz_id'] ?? 0);
$raw_answers = $_POST['answer'] ?? [];  // This now supports both flat and nested

if ($quiz_id == 0) {
    echo "ERROR: quiz_id is missing";
    exit;
}

if (empty($raw_answers)) {
    echo "ERROR: No answers received";
    exit;
}

// Determine attempt_time
$sess_key = 'attempt_time_for_topic_' . $quiz_id;
if (!empty($_SESSION[$sess_key])) {
    $created_at = $_SESSION[$sess_key];
} elseif (!empty($_POST['attempt_time'])) {
    $created_at = trim($_POST['attempt_time']);
} else {
    $created_at = date("Y-m-d H:i:s");
}

// ==========================
// PROCESS ANSWERS: Support both single and multi-field (shaded/unshaded)
// ==========================
$answers = [];

foreach ($raw_answers as $qid => $value) {
    $question_id = intval($qid);

if (is_array($value)) {

    $clean = function($arr) use (&$clean) {

        $result = [];

        foreach ($arr as $k => $v) {

            if (is_array($v)) {
                $nested = $clean($v);
                if (!empty($nested)) {
                    $result[$k] = $nested;
                }

            } else {

                $v = trim((string)$v);

                if ($v !== '') {
                    $result[$k] = $v;
                }

            }
        }

        return $result;
    };

    $cleaned = $clean($value);

    $answers[$question_id] = !empty($cleaned) ? json_encode($cleaned) : '';
} else {
        // Single-field answer (all your old templates)
        $answers[$question_id] = trim((string)$value);
    }
}

// Remove empty answers completely
$answers = array_filter($answers, function($ans) {
    return $ans !== '' && $ans !== '[]' && $ans !== '{}';
});

// ==========================
// SAVE ANSWERS
// ==========================
$sql_correct = "SELECT correct_answer FROM quiz_questions WHERE id = ?";
$stmt_corr = $conn->prepare($sql_correct);
if (!$stmt_corr) {
    echo "correct_answer prepare error: " . $conn->error;
    exit;
}

$sql_insert = "INSERT INTO student_answers (student_id, quiz_id, question_id, student_answer, is_correct, created_at)
               VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
if (!$stmt_insert) {
    echo "INSERT prepare error: " . $conn->error;
    exit;
}

foreach ($answers as $question_id => $student_answer) {

    // Fetch correct answer
    $stmt_corr->bind_param("i", $question_id);
    $stmt_corr->execute();
    $res_corr = $stmt_corr->get_result();
    $row_corr = $res_corr->fetch_assoc();
    $correct_answer_raw = $row_corr['correct_answer'] ?? '';
    $correct_answer = is_string($correct_answer_raw) ? trim($correct_answer_raw) : '';

    // Smart comparison: supports both plain text and JSON correct answers
    $is_correct = 0;

    if ($correct_answer !== '') {
        // Try to decode both as JSON
        $expected_json = json_decode($correct_answer, true);
        $submitted_json = json_decode($student_answer, true);

  if (is_array($expected_json) && is_array($submitted_json)) {

    // If nested structure (LCM, multi-step answers)
    if (isset($expected_json['m1']) || isset($expected_json['m2']) || isset($expected_json['common'])) {

        $is_correct = 1;

        foreach ($expected_json as $key => $correct_part) {

            $student_part = $submitted_json[$key] ?? null;

            if (is_array($correct_part)) {

                $correct_part  = array_map('strval', $correct_part);
                $student_part  = is_array($student_part) ? array_map('strval', $student_part) : [];

                sort($correct_part, SORT_NUMERIC);
                sort($student_part, SORT_NUMERIC);

                if ($correct_part !== $student_part) {
                    $is_correct = 0;
                    break;
                }

            } else {

                if ((string)$correct_part !== (string)$student_part) {
                    $is_correct = 0;
                    break;
                }

            }
        }

    } else {

        // Old flat JSON behaviour
        $expected_json  = array_map('strval', $expected_json);
        $submitted_json = array_map('strval', $submitted_json);

        sort($expected_json, SORT_NUMERIC);
        sort($submitted_json, SORT_NUMERIC);

        $is_correct = ($submitted_json === $expected_json) ? 1 : 0;
    }
    } elseif (is_array($submitted_json)) {
            // Student submitted JSON, but correct is plain → fallback to string compare
            $is_correct = (strcasecmp($student_answer, $correct_answer) === 0) ? 1 : 0;
        } else {
            // Normal string comparison (old behavior)
            if (is_numeric($student_answer) && is_numeric($correct_answer)) {
                $tol = 0.001;
                $is_correct = abs((float)$student_answer - (float)$correct_answer) < $tol ? 1 : 0;
            } else {
                $is_correct = (strcasecmp($student_answer, $correct_answer) === 0) ? 1 : 0;
            }
        }
    }

    // Insert the answer
    $stmt_insert->bind_param("iiisis", $student_id, $quiz_id, $question_id, $student_answer, $is_correct, $created_at);
    $stmt_insert->execute();
}

// Clean up session
unset($_SESSION[$sess_key]);

// Redirect to results
header("Location: check_answer.php?topic_id=" . $quiz_id);
exit;
?>