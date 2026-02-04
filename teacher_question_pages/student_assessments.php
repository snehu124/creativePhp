<?php
session_start();
include "../db_config.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student name
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT first_name, last_name FROM students WHERE id = $student_id"));
$name = htmlspecialchars($student['first_name'] . " " . $student['last_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Assessments</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/confetti.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        .container { padding: 40px 20px; }
        h1 {
            color: white;
            text-align: center;
            font-weight: 700;
            margin-bottom: 40px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .assessment-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            transition: all 0.4s ease;
            margin-bottom: 25px;
        }
        .assessment-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
        }
        .progress-ring {
            width: 90px;
            height: 90px;
            position: relative;
        }
        .progress-ring svg {
            width: 90px;
            height: 90px;
            transform: rotate(-90deg);
        }
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }
        .confetti-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 9999;
        }
    </style>
</head>
<body>

<canvas class="confetti-canvas"></canvas>

<div class="container">
    <h1 class="display-4">My Assessments, <?= explode(" ", $name)[0] ?>!</h1>

    <div class="row justify-content-center">

        <?php
        $sql = "
            SELECT a.*, ass.started_at, ass.submitted_at, ass.score, ass.total_questions
            FROM assessments a
            JOIN assessment_assignments ass ON a.id = ass.assessment_id
            WHERE ass.student_id = ? AND a.is_published = 1
            ORDER BY a.due_date ASC
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0):
        ?>

            <div class="col-12 text-center text-white">
                <i class="bi bi-emoji-smile display-1"></i>
                <h3 class="mt-4">No assessments yet!</h3>
                <p>Enjoy your free time — more coming soon!</p>
            </div>

        <?php else:
        while ($a = $result->fetch_assoc()):

            $submitted = !empty($a['submitted_at']);
            $started   = !empty($a['started_at']);

            // Due date safe
            $due = $a['due_date'] ? new DateTime($a['due_date']) : null;
            $now = new DateTime();

            $time_left = ($due) ? $due->diff($now) : null;
            $days_left = $time_left ? $time_left->days : null;

            // Score safe
            $score = (int)($a['score'] ?? 0);
            $total_marks = ($a['total_questions'] ?? 0) * 10;

            $percentage = ($total_marks > 0) ? round(($score / $total_marks) * 100) : 0;

            $status = $submitted ? "Submitted" : ($started ? "In Progress" : "Not Started");
            $badge_color = $submitted ? "bg-success" :
                          ($started ? "bg-warning text-dark" : "bg-secondary");

            $btn_text = $submitted ? "View Result" :
                       ($started ? "Continue" : "Start Now");

            $btn_color = $submitted ? "btn-success" : "btn-primary";
        ?>

        <div class="col-md-6 col-lg-4">
            <div class="assessment-card">

                <div class="text-center p-4 bg-primary text-white">
                    <h5><?= htmlspecialchars($a['title']) ?></h5>
                </div>

                <div class="card-body p-4 text-center">

                    <p class="text-muted small">
                        <?= htmlspecialchars(substr($a['description'] ?? '', 0, 80)) ?>...
                    </p>

                    <!-- Progress Circle -->
                    <div class="progress-ring mx-auto my-3">
                        <svg>
                            <circle cx="45" cy="45" r="38" stroke="#e0e0e0" stroke-width="8" fill="none"></circle>
                            <circle cx="45" cy="45" r="38"
                                stroke="#4CAF50"
                                stroke-width="8"
                                stroke-linecap="round"
                                fill="none"
                                stroke-dasharray="238"
                                stroke-dashoffset="<?= 238 - (238 * $percentage / 100) ?>">
                            </circle>
                        </svg>
                        <div class="progress-text"><?= $percentage ?>%</div>
                    </div>

                    <span class="status-badge <?= $badge_color ?>"><?= $status ?></span>

                    <?php if ($submitted): ?>
                        <h4 class="text-success mt-3"><?= $score ?> / <?= $total_marks ?> pts</h4>
                    <?php endif; ?>

                    <a href="take_assessment.php?id=<?= $a['id'] ?>"
                       class="btn <?= $btn_color ?> btn-lg mt-4 d-block"
                       <?= $submitted ? 'onclick="triggerConfetti()"' : '' ?>>
                        <?= $btn_text ?>
                    </a>

                </div>

            </div>
        </div>

        <?php endwhile; endif; ?>

    </div>
</div>

<script>
function triggerConfetti() {
    const confetti = new ConfettiGenerator({
        target: 'confetti-canvas',
        max: 150,
        size: 1,
        animate: true
    });
    confetti.render();
    setTimeout(() => confetti.clear(), 4000);
}
</script>

</body>
</html>
