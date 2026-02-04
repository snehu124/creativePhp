<?php
session_start();
include '../db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../teacher_login.php');
    exit();
}

$teacher_id = (int)$_SESSION['teacher_id'];
$assessment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($assessment_id <= 0) {
    die('<h3 class="text-danger text-center mt-5">Invalid assessment ID.</h3>');
}

// Keep teacher active
$now = date('Y-m-d H:i:s');
$conn->query("UPDATE teachers SET last_activity = '$now' WHERE id = $teacher_id");

// Fetch assessment + stats
$sql = "
    SELECT 
        a.*,
        COUNT(aa.student_id) AS assigned_count,
        SUM(CASE WHEN aa.submitted_at IS NOT NULL THEN 1 ELSE 0 END) AS submitted_count,
        (SELECT COUNT(*) FROM assessment_questions WHERE assessment_id = a.id) AS total_questions
    FROM assessments a
    LEFT JOIN assessment_assignments aa ON a.id = aa.assessment_id
    WHERE a.id = ? AND a.teacher_id = ?
    GROUP BY a.id
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database error: " . $conn->error);
}
$stmt->bind_param("ii", $assessment_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$assessment = $result->fetch_assoc();
$stmt->close();

if (!$assessment) {
    die('<h3 class="text-danger text-center mt-5">Assessment not found or access denied.</h3>');
}

$completion = $assessment['assigned_count'] > 0
    ? round(($assessment['submitted_count'] / $assessment['assigned_count']) * 100)
    : 0;

// Fetch student results with full name (first_name + last_name)
$results_sql = "
    SELECT 
        CONCAT(COALESCE(s.first_name, ''), ' ', COALESCE(s.last_name, '')) AS student_name,
        s.email,
        aa.score,
        aa.submitted_at,
        aa.started_at,
        TIMESTAMPDIFF(SECOND, aa.started_at, aa.submitted_at) AS time_taken_seconds
    FROM assessment_assignments aa
    JOIN students s ON aa.student_id = s.id
    WHERE aa.assessment_id = ? AND aa.submitted_at IS NOT NULL
    ORDER BY aa.submitted_at DESC
";

$stmt2 = $conn->prepare($results_sql);
if (!$stmt2) {
    die("Database error: " . $conn->error);
}
$stmt2->bind_param("i", $assessment_id);
$stmt2->execute();
$results = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($assessment['title']) ?> - Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { margin:0; font-family:Arial, sans-serif; background:#f8f9fa; }
        .sidebar { width:220px; background:#2c3e50; color:#fff; padding:20px 10px; min-height:100vh; position:fixed; top:0; left:0; z-index:1000; overflow-y:auto; }
        .main-content { margin-left:220px; padding:36px 50px; min-height:100vh; background:#f8f9fa; }
        .header-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 30px; padding: 30px; text-align: center; color: white;
            box-shadow: 0 10px 30px rgba(102,126,234,0.3); margin-bottom: 30px;
        }
        .stat-card { background:white; border-radius:20px; padding:25px; text-align:center; box-shadow:0 8px 25px rgba(0,0,0,0.1); }
        .stat-number { font-size:2.4rem; font-weight:800; color:#667eea; margin:10px 0; }
        .badge-score { padding:12px 24px; border-radius:50px; font-weight:700; font-size:1rem; }
        .table-modern { background:white; border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); }
        .table-modern th { background:linear-gradient(135deg, #667eea, #764ba2); color:white; font-weight:600; }
        .back-btn { background:#6c757d; color:white; border-radius:50px; padding:12px 32px; font-weight:600; transition:0.3s; }
        .back-btn:hover { background:#495057; transform:translateY(-2px); }
        @media (max-width: 768px) {
            .sidebar { position:relative; width:100%; min-height:auto; }
            .main-content { margin-left:0; padding:20px; }
            .stat-number { font-size:2rem; }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">

            <!-- Header -->
            <div class="header-card">
                <h2 class="mb-2"><?= htmlspecialchars($assessment['title']) ?></h2>
                <?php if (!empty($assessment['description'])): ?>
                    <p class="mb-0 opacity-90"><?= nl2br(htmlspecialchars($assessment['description'])) ?></p>
                <?php endif; ?>
            </div>

            <!-- Quick Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-people fs-1 text-primary"></i>
                        <div class="stat-number"><?= number_format($assessment['assigned_count']) ?></div>
                        <div class="text-muted">Assigned</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-check2-square fs-1 text-success"></i>
                        <div class="stat-number"><?= number_format($assessment['submitted_count']) ?></div>
                        <div class="text-muted">Submitted</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-graph-up fs-1 text-warning"></i>
                        <div class="stat-number"><?= $completion ?>%</div>
                        <div class="text-muted">Completion</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-question-lg fs-1 text-info"></i>
                        <div class="stat-number"><?= $assessment['total_questions'] ?></div>
                        <div class="text-muted">Questions</div>
                    </div>
                </div>
            </div>

            <!-- Student Results Table -->
            <div class="card table-modern">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h4 class="mb-0">
                        <i class="bi bi-trophy text-warning"></i> 
                        Student Results 
                        <span class="text-muted fs-5">(<?= $assessment['submitted_count'] ?> submission<?= $assessment['submitted_count'] != 1 ? 's' : '' ?>)</span>
                    </h4>
                </div>
                <div class="card-body p-0">
                    <?php if ($results->num_rows === 0): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted opacity-30"></i>
                            <p class="mt-3 text-muted fs-5">No submissions yet.<br><small>Students are still working on it.</small></p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                               <thead>
                                    <tr>
                                        <th width="23%">Student Name</th>
                                        <th width="20%">Email</th>
                                        <th width="16%">Score</th>
                                        <th width="13%">Time Taken</th>
                                        <th width="18%">Submitted On</th>
                                        <th width="10%" class="text-center">Actions</th>  <!-- YE NAYA COLUMN ADD KIYA -->
                                    </tr>
                                </thead>
                               <tbody>
    <?php while ($row = $results->fetch_assoc()):
        $student_name = trim($row['student_name']) ?: 'Student (No Name)';
        $max = (int)$assessment['total_questions'];
        $score = (int)$row['score'];
        $percent = $max > 0 ? round(($score / $max) * 100) : 0;
        $badge_class = $percent >= 80 ? 'bg-success' :
                      ($percent >= 60 ? 'bg-warning text-dark' :
                      ($percent >= 40 ? 'bg-orange text-white' : 'bg-danger'));

        $time = '—';
        if ($row['time_taken_seconds'] > 0) {
            $mins = floor($row['time_taken_seconds'] / 60);
            $secs = $row['time_taken_seconds'] % 60;
            $time = sprintf('%02dm %02ds', $mins, $secs);
        }

        // Safely get student_id
        $stmt_id = $conn->prepare("SELECT student_id FROM assessment_assignments WHERE assessment_id = ? AND submitted_at = ? LIMIT 1");
        $stmt_id->bind_param("is", $assessment_id, $row['submitted_at']);
        $stmt_id->execute();
        $student_id = $stmt_id->get_result()->fetch_assoc()['student_id'] ?? 0;
        $stmt_id->close();
    ?>
    <tr>
        <td><strong><?= htmlspecialchars($student_name) ?></strong></td>
        <td><small class="text-muted"><?= htmlspecialchars($row['email']) ?></small></td>
        <td>
            <span class="badge <?= $badge_class ?> badge-score px-4 py-2">
                <?= $score ?> / <?= $max ?> <small>(<?= round($percent) ?>%)</small>
            </span>
        </td>
        <td class="text-center"><?= $time ?></td>
        <td>
            <small class="text-success">
                <?= date('d M Y', strtotime($row['submitted_at'])) ?><br>
                <?= date('h:i A', strtotime($row['submitted_at'])) ?>
            </small>
        </td>
        <td class="text-center">
            <a href="view_student_answers.php?assessment_id=<?= $assessment_id ?>&student_id=<?= $student_id ?>&submitted_at=<?= urlencode($row['submitted_at']) ?>"
               class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm">
                View Answers
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer bg-light text-center py-4">
                    <a href="manage_assessments.php" class="btn back-btn">
                        <i class="bi bi-arrow-left-circle me-2"></i>
                        Back to Assessments
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('.sidebar a').removeClass('active');
            $('.sidebar a[href*="view_assessment_results"], .sidebar a[href*="manage_assessments"]').addClass('active');
        });
    </script>
</body>
</html>

<?php
$stmt2->close();
$conn->close();
?>