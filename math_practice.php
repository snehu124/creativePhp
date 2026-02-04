<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "db_config.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$grade = $student['grade'];
$student_name = $student['first_name'] . ' ' . $student['last_name'];

$solution_shown = false;
$question = null;
$show_summary = false;

// ✅ Check how many total questions in this grade
$total_questions_result = $conn->prepare("SELECT COUNT(*) as total FROM math_questions WHERE grade = ?");
$total_questions_result->bind_param("i", $grade);
$total_questions_result->execute();
$total_q_data = $total_questions_result->get_result()->fetch_assoc();
$total_questions = $total_q_data['total'];

// ✅ Check how many already attempted
$attempted_result = $conn->prepare("SELECT COUNT(*) as attempted FROM student_math_answers sma JOIN math_questions mq ON sma.question_id = mq.id WHERE sma.student_id = ? AND mq.grade = ?");
$attempted_result->bind_param("ii", $student_id, $grade);
$attempted_result->execute();
$attempted_data = $attempted_result->get_result()->fetch_assoc();
$attempted_questions = $attempted_data['attempted'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id'])) {
    // ✅ Submit answer
    $question_id = $_POST['question_id'];
    $student_answer = $_POST['answer'];

    $stmt = $conn->prepare("SELECT * FROM math_questions WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $qResult = $stmt->get_result();
    $question = $qResult->fetch_assoc();

    $correct_answer = $question['correct_answer'];
    $is_correct = ($student_answer == $correct_answer) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO student_math_answers (student_id, question_id, student_answer, is_correct) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $student_id, $question_id, $student_answer, $is_correct);
    $stmt->execute();

    $solution_shown = true;
    $attempted_questions++; // increase local counter
} elseif ($attempted_questions >= $total_questions) {
    // ✅ All questions done – show summary
    $show_summary = true;
} else {
    // ✅ Load a random unattempted question
    $stmt = $conn->prepare("SELECT * FROM math_questions WHERE grade = ? AND id NOT IN (SELECT question_id FROM student_math_answers WHERE student_id = ?) ORDER BY RAND() LIMIT 1");
    $stmt->bind_param("ii", $grade, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $question = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Math Practice - Grade <?= htmlspecialchars($grade) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fb; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            color: #fff;
        }
        .sidebar a {
            color: #ddd;
            display: block;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }
        button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .solution {
            margin-top: 20px;
            background: #e6ffed;
            padding: 15px;
            border-left: 5px solid #28a745;
            border-radius: 5px;
        }
        .correct { color: green; font-weight: bold; }
        .incorrect { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar (from dashboard) -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="text-center mb-4">
                <h4>📘 Student Panel</h4>
            </div>
            <div class="text-center mb-3">
                <img src="<?= htmlspecialchars($student['profile_picture'] ?? 'default-profile.png') ?>" alt="Profile" class="profile-img">
                <p class="fw-semibold mt-2"><?= htmlspecialchars($student_name) ?></p>
            </div>
            <a href="student_dashboard.php"><i class="bi bi-person"></i> My Profile</a>
            <a href="student_dashboard.php#subjects"><i class="bi bi-list-check"></i> Enrolled Subjects</a>
            <a href="student_dashboard.php#materials"><i class="bi bi-folder2-open"></i> Study Materials</a>
            <a href="student_dashboard.php#progress"><i class="bi bi-bar-chart"></i> Progress Tracker</a>
            <a href="student_dashboard.php#notifications"><i class="bi bi-bell"></i> Announcements</a>
            <a href="math_practice.php" class="active"><i class="bi bi-calculator"></i> Math Practice</a>
            <a href="student_logout.php" class="btn btn-sm btn-danger">Logout</a>
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 content">
            <h3 class="mb-4">🧮 Math Practice - Grade <?= htmlspecialchars($grade) ?></h3>

            <div class="card p-4">
                <?php if ($show_summary): ?>
                    <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) as correct FROM student_math_answers sma JOIN math_questions mq ON sma.question_id = mq.id WHERE sma.student_id = ? AND mq.grade = ? AND sma.is_correct = 1");
                        $stmt->bind_param("ii", $student_id, $grade);
                        $stmt->execute();
                        $summary_result = $stmt->get_result()->fetch_assoc();
                        $correct = $summary_result['correct'];
                        $incorrect = $total_questions - $correct;
                    ?>
                    <h4>🎉 You have completed all <?= $total_questions ?> questions!</h4>
                    <p><strong>✅ Correct Answers:</strong> <?= $correct ?></p>
                    <p><strong>❌ Incorrect Answers:</strong> <?= $incorrect ?></p>
                    <a href="student_dashboard.php" class="btn btn-primary">🔙 Back to Dashboard</a>

                <?php elseif ($solution_shown): ?>
                    <p><strong>Question:</strong> <?= htmlspecialchars($question['question_text']) ?></p>
                    <p><strong>Your Answer:</strong> <?= htmlspecialchars($student_answer) ?></p>
                    <div class="solution">
                        <p><strong>Correct Answer:</strong> <?= htmlspecialchars($question['correct_answer']) ?></p>
                        <p><strong>Explanation:</strong> <?= htmlspecialchars($question['solution_text']) ?></p>
                        <?php if ($is_correct): ?>
                            <p class="correct">🎯 Correct!</p>
                        <?php else: ?>
                            <p class="incorrect">😢 Incorrect.</p>
                        <?php endif; ?>
                    </div>
                    <?php if ($attempted_questions == $total_questions): ?>
                        <form method="get">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    <?php else: ?>
                        <a href="math_practice.php" class="btn btn-success mt-3">Try Next Question</a>
                    <?php endif; ?>

                <?php elseif ($question): ?>
                    <form method="post">
                        <p><strong>Question:</strong> <?= htmlspecialchars($question['question_text']) ?></p>
                        <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                        <input type="number" name="answer" required placeholder="Your answer">
                        <br><br>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
