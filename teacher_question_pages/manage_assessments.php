<?php
session_start();
include '../db_config.php';
if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../teacher_login.php');
    exit();
}
$teacher_id = $_SESSION['teacher_id'];
// Keep teacher active
$now = date('Y-m-d H:i:s');
mysqli_query($conn, "UPDATE teachers SET last_activity = '$now' WHERE id = '$teacher_id'");

// ———————— DETECT AJAX REQUEST FROM DASHBOARD ————————
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$sql = "
    SELECT
        a.id, 
        a.title, 
        a.description, 
        a.time_limit_minutes, 
        a.is_published,
        a.created_at, 
        a.due_date,
        COUNT(aa.student_id) AS assigned_count,
        SUM(CASE WHEN aa.submitted_at IS NOT NULL THEN 1 ELSE 0 END) AS submitted_count,
        COALESCE(qcount.qcount, 0) AS total_questions
    FROM assessments a
    LEFT JOIN assessment_assignments aa ON a.id = aa.assessment_id
    LEFT JOIN (
        SELECT assessment_id, COUNT(*) AS qcount
        FROM assessment_questions
        GROUP BY assessment_id
    ) qcount ON a.id = qcount.assessment_id
    WHERE a.teacher_id = ?
    GROUP BY a.id
    ORDER BY a.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

// ———————— IF LOADED VIA AJAX → OUTPUT ONLY CONTENT (NO SIDEBAR, NO MARGIN CONFLICT) ————————
if ($is_ajax) {
    // This keeps ALL your original spacing, padding, cards, colors — exactly as in screenshot
    ?>
    <div class="container-fluid" style="padding: 36px 50px;">
        <!-- Header -->
        <div class="header-card">
            <h2 class="mb-0">Manage Assessments</h2>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-dark">Your Created Assessments</h4>
            <a href="../teacher_question_pages/assign_assessment.php" class="btn create-btn">
                Create New Assessment
            </a>
        </div>

        <?php if ($result->num_rows === 0): ?>
            <div class="text-center py-5 empty-state">
                <i class="bi bi-clipboard2-x"></i>
                <h3 class="mt-4 text-muted">No Assessments Created Yet</h3>
                <p class="text-muted">Click the green button to create your first assessment!</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php while ($a = $result->fetch_assoc()):
                    $assigned = (int)$a['assigned_count'];
                    $submitted = (int)$a['submitted_count'];
                    $completion = $assigned > 0 ? round(($submitted / $assigned) * 100) : 0;
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="assessment-card">
                            <div class="assessment-header">
                                <?= htmlspecialchars($a['title']) ?>
                            </div>
                            <div class="assessment-body">
                                <?php if (!empty($a['description'])): ?>
                                    <p class="text-muted small mb-3"><?= htmlspecialchars(substr($a['description'], 0, 80)) ?>...</p>
                                <?php endif; ?>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="pill-badge badge-questions">Questions: <?= $a['total_questions'] ?></span>
                                    <span class="pill-badge badge-time">Time: <?= $a['time_limit_minutes'] ?> mins</span>
                                    <span class="pill-badge badge-assigned">Assigned: <?= $assigned ?></span>
                                    <span class="pill-badge <?= $a['is_published'] ? 'badge-status' : 'badge-draft' ?>">
                                        <?= $a['is_published'] ? 'Published' : 'Draft' ?>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>Completion</span>
                                        <span><?= $completion ?>%</span>
                                    </div>
                                    <div class="progress-sm">
                                        <div class="progress-bar <?= $completion>=80?'bg-success':($completion>=50?'bg-warning':'bg-danger') ?>"
                                             style="width:<?= $completion ?>%"></div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="../teacher_question_pages/view_assessment_results.php?id=<?= $a['id'] ?>"
                                       class="btn btn-view flex-fill">View Results</a>
                                    <button onclick="if(confirm('Delete this assessment permanently?')) location.href='../teacher_question_pages/delete_assessment.php?id=<?= $a['id'] ?>'"
                                            class="btn btn-delete">Delete</button>
                                </div>
                            </div>
                            <div class="bg-light px-4 py-2 small text-muted border-top">
                                Created: <?= date('d M Y, h:i A', strtotime($a['created_at'])) ?>
                                <?php if ($a['due_date']): ?> • Due: <?= date('d M Y, h:i A', strtotime($a['due_date'])) ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- All your original beautiful styles — injected only when needed via AJAX -->
    <style>
        .header-card{background:linear-gradient(135deg,#667eea,#764ba2);border-radius:30px;padding:25px;text-align:center;color:white;box-shadow:0 10px 30px rgba(102,126,234,.3);margin-bottom:30px}
        .assessment-card{background:white;border-radius:25px;overflow:hidden;box-shadow:0 8px 25px rgba(0,0,0,.1);transition:all .3s ease;height:100%}
        .assessment-card:hover{transform:translateY(-10px);box-shadow:0 20px 40px rgba(0,0,0,.15)}
        .assessment-header{background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:18px 20px;font-size:1.1rem;font-weight:600}
        .assessment-body{padding:20px}
        .pill-badge{display:inline-block;padding:8px 18px;border-radius:50px;font-size:.85rem;font-weight:600;margin:4px 2px}
        .badge-questions{background:#007bff;color:white}
        .badge-time{background:#17a2b8;color:white}
        .badge-assigned{background:#ffc107;color:#212529}
        .badge-status{background:#28a745;color:white}
        .badge-draft{background:#6c757d;color:white}
        .progress-sm{height:8px;border-radius:10px;background:#e9ecef;overflow:hidden}
        .btn-view{background:#007bff;color:white;border-radius:30px;padding:8px 20px;font-size:.9rem}
        .btn-delete{background:#dc3545;color:white;border-radius:30px;padding:8px 16px;font-size:.85rem}
        .create-btn{background:#28a745;color:white;border-radius:50px;padding:12px 30px;font-weight:600;box-shadow:0 5px 15px rgba(40,167,69,.4)}
        .create-btn:hover{background:#218838;color:white}
        .empty-state i{font-size:5rem;opacity:.2;color:#6c757d}
    </style>
    <?php
    exit; // Stop here for AJAX — perfect layout inside dashboard
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Assessments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {margin:0; font-family:Arial, sans-serif; background:#f8f9fa;}
        .sidebar {
            width:220px; background:#2c3e50; color:#fff; padding:20px 10px; min-height:100vh; position:fixed; top:0; left:0; z-index:1000; overflow-y:auto;
        }
        .sidebar h4 {text-align:center; margin-bottom:30px; font-size:1.2rem; color:#ecf0f1;}
        .sidebar a {display:block; color:#fff; padding:12px 15px; margin:6px 0; text-decoration:none; border-radius:6px; font-size:0.95rem; transition:background .2s;}
        .sidebar a:hover, .sidebar a.active {background:#34495e;}
        .sidebar a.active {background:#1a252f; font-weight:bold;}
        .main-content {
            margin-left: 220px;
            padding: 36px 50px;
            min-height:100vh;
            background:#f8f9fa;
        }
        .header-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 30px;
            padding: 25px;
            text-align: center;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            margin-bottom: 30px;
        }
        .assessment-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        .assessment-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .assessment-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 18px 20px;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .assessment-body { padding: 20px; }
        .pill-badge { display: inline-block; padding: 8px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin: 4px 2px; }
        .badge-questions { background:#007bff; color:white; }
        .badge-time { background:#17a2b8; color:white; }
        .badge-assigned { background:#ffc107; color:#212529; }
        .badge-status { background:#28a745; color:white; }
        .badge-draft { background:#6c757d; color:white; }
        .progress-sm { height: 8px; border-radius: 10px; background: #e9ecef; overflow: hidden; }
        .btn-view { background:#007bff; color:white; border-radius:30px; padding:8px 20px; font-size:0.9rem; }
        .btn-delete { background:#dc3545; color:white; border-radius:30px; padding:8px 16px; font-size:0.85rem; }
        .create-btn {
            background: #28a745; color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600;
            box-shadow: 0 5px 15px rgba(40,167,69,0.4);
        }
        .create-btn:hover { background:#218838; color:white; }
        .empty-state i { font-size:5rem; opacity:0.2; color:#6c757d; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <div class="header-card">
                <h2 class="mb-0">Manage Assessments</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">Your Created Assessments</h4>
                <a href="../teacher_question_pages/assign_assessment.php" class="btn create-btn">
                    Create New Assessment
                </a>
            </div>

            <?php if ($result->num_rows === 0): ?>
                <div class="text-center py-5 empty-state">
                    <i class="bi bi-clipboard2-x"></i>
                    <h3 class="mt-4 text-muted">No Assessments Created Yet</h3>
                    <p class="text-muted">Click the green button to create your first assessment!</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php while ($a = $result->fetch_assoc()):
                        $assigned = (int)$a['assigned_count'];
                        $submitted = (int)$a['submitted_count'];
                        $completion = $assigned > 0 ? round(($submitted / $assigned) * 100) : 0;
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="assessment-card">
                                <div class="assessment-header">
                                    <?= htmlspecialchars($a['title']) ?>
                                </div>
                                <div class="assessment-body">
                                    <?php if (!empty($a['description'])): ?>
                                        <p class="text-muted small mb-3"><?= htmlspecialchars(substr($a['description'], 0, 80)) ?>...</p>
                                    <?php endif; ?>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="pill-badge badge-questions">Questions: <?= $a['total_questions'] ?></span>
                                        <span class="pill-badge badge-time">Time: <?= $a['time_limit_minutes'] ?> mins</span>
                                        <span class="pill-badge badge-assigned">Assigned: <?= $assigned ?></span>
                                        <span class="pill-badge <?= $a['is_published'] ? 'badge-status' : 'badge-draft' ?>">
                                            <?= $a['is_published'] ? 'Published' : 'Draft' ?>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between small text-muted mb-1">
                                            <span>Completion</span>
                                            <span><?= $completion ?>%</span>
                                        </div>
                                        <div class="progress-sm">
                                            <div class="progress-bar <?= $completion>=80?'bg-success':($completion>=50?'bg-warning':'bg-danger') ?>"
                                                 style="width:<?= $completion ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="../teacher_question_pages/view_assessment_results.php?id=<?= $a['id'] ?>"
                                           class="btn btn-view flex-fill">View Results</a>
                                        <button onclick="if(confirm('Delete this assessment permanently?')) location.href='../teacher_question_pages/delete_assessment.php?id=<?= $a['id'] ?>'"
                                                class="btn btn-delete">Delete</button>
                                    </div>
                                </div>
                                <div class="bg-light px-4 py-2 small text-muted border-top">
                                    Created: <?= date('d M Y, h:i A', strtotime($a['created_at'])) ?>
                                    <?php if ($a['due_date']): ?> • Due: <?= date('d M Y, h:i A', strtotime($a['due_date'])) ?><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(function () {
            $('.sidebar a[href*="manage_assessments.php"], .sidebar a[data-page*="manage_assessments.php"]').addClass('active');
        });
    </script>
</body>
</html>