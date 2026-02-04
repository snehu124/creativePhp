<?php
session_start();
include "../db_config.php";
include "student_sidebar.php";

// Debug mode (optional - remove on production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Student login check
if (!isset($_SESSION['student_id'])) {
    echo "<h3>Please login to view your assessments.</h3>";
    exit;
}

$student_id = (int) $_SESSION['student_id'];

// Fetch assessments (only needed fields)
$sql = "
    SELECT 
        a.id, 
        a.title, 
        a.due_date, 
        ass.started_at,
        ass.submitted_at,
        ass.score,
        ass.total_questions
    FROM assessments a
    JOIN assessment_assignments ass 
        ON a.id = ass.assessment_id
    WHERE ass.student_id = $student_id 
      AND a.is_published = 1
    ORDER BY a.due_date ASC
";
$res = mysqli_query($conn, $sql);

if (!$res) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Assessments</title>
    <link href="student.css" rel="stylesheet">
    <style>
        .content {
            margin-left: 240px; /* adjust if your sidebar width differs */
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f3f3f3;
            font-weight: bold;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }
        .bg-success { background: #28a745; color: #fff; }
        .bg-warning { background: #ffc107; color: #000; }
        .bg-secondary { background: #6c757d; color: #fff; }

        .btn-primary {
            padding: 6px 12px;
            background: #007bff;
            color: white;
            border-radius: 3px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        /* small responsive tweak */
        @media (max-width: 720px) {
            .content { padding: 15px; margin-left: 0; }
            table, th, td { font-size: 14px; }
        }
    </style>
</head>
<body>

<div class="content">
    <h2>My Assessments</h2>

    <table>
        <tr>
            <th>Title</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php if (mysqli_num_rows($res) === 0): ?>
            <tr><td colspan="4">No assessments assigned.</td></tr>
        <?php endif; ?>

        <?php while ($r = mysqli_fetch_assoc($res)): ?>

            <?php
                // Safe title
                $title = htmlspecialchars($r['title'] ?? 'Untitled');

                // Safe due_date: avoid passing null to strtotime (PHP 8.1+ deprecation)
                if (!empty($r['due_date']) && $r['due_date'] !== '0000-00-00') {
                    // Try to convert; if conversion fails fallback to raw value
                    $ts = strtotime($r['due_date']);
                    $due_date = $ts ? date("d M Y", $ts) : htmlspecialchars($r['due_date']);
                } else {
                    $due_date = "No Due Date";
                }

                // Status badges
                if (!empty($r['submitted_at'])) {
                    $status = "<span class='badge bg-success'>Submitted</span>";
                } elseif (!empty($r['started_at'])) {
                    $status = "<span class='badge bg-warning'>In Progress</span>";
                } else {
                    $status = "<span class='badge bg-secondary'>Not Started</span>";
                }

                // Secure id for URL
                $id_for_url = (int) $r['id'];
            ?>

            <tr>
                <td><?= $title; ?></td>
                <td><?= $due_date; ?></td>
                <td><?= $status; ?></td>
                <td>
                    <a href="take_assessment.php?id=<?= $id_for_url; ?>" class="btn-primary">
                        Take / View
                    </a>
                </td>
                <td>
    <?php if (!empty($r['submitted_at'])): ?>
        <strong><?= $r['score'] ?> / <?= $r['total_questions'] ?></strong>
    <?php else: ?>
        —
    <?php endif; ?>
</td>
            </tr>

        <?php endwhile; ?>

    </table>
</div>

</body>
</html>
