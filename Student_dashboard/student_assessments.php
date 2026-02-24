<?php
session_start();
include "../db_config.php";

// 🔐 Security check
if (!isset($_SESSION['student_id'])) {
    header("Location: ../student_login.php");
    exit();
}

$student_id = (int) $_SESSION['student_id'];

/*
|--------------------------------------------------------------------------
| 1️⃣ First check if any assessment is assigned to this student
|--------------------------------------------------------------------------
*/

$count_sql = "
    SELECT COUNT(*) AS total
    FROM assessment_assignments
    WHERE student_id = $student_id
";

$count_res = mysqli_query($conn, $count_sql);

if (!$count_res) {
    die("Count query failed: " . mysqli_error($conn));
}

$count_row = mysqli_fetch_assoc($count_res);
$total_assessments = (int)$count_row['total'];


/*
|--------------------------------------------------------------------------
| 2️⃣ Fetch assessment details (only if assigned)
|--------------------------------------------------------------------------
*/

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
    INNER JOIN assessment_assignments ass 
        ON a.id = ass.assessment_id
    WHERE ass.student_id = $student_id
      AND a.is_published = 1
    ORDER BY a.due_date ASC
";

$res = mysqli_query($conn, $sql);

if (!$res) {
    die("Main query failed: " . mysqli_error($conn));
}

$currentpage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Assessments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#f8f9ff,#e0e7ff);
    margin:0;
    font-family:'Segoe UI',system-ui,sans-serif;
}
.main-layout{
    display:flex;
    min-height:100vh;
}
.content-area{
    margin-left:260px;
    padding:35px 45px;
    flex:1;
}
@media(max-width:992px){
    .content-area{
        margin-left:0;
        padding-top:80px;
    }
}
.badge{
    font-size:12px;
}
</style>
</head>

<body>

<div class="main-layout">

    <!-- Sidebar -->
    <?php include "student_sidebar.php"; ?>

    <!-- Mobile toggle -->
    <button class="btn btn-primary d-lg-none position-fixed"
            id="sidebarToggle"
            style="top:15px;left:15px;z-index:1100;border-radius:50%;width:48px;height:48px;">
        <i class="bi bi-list fs-4"></i>
    </button>

    <!-- Content -->
    <div class="content-area">

        <h3 class="fw-bold text-primary mb-4">
            <i class="bi bi-file-earmark-text-fill me-2"></i>
            My Assessments
        </h3>

        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if($total_assessments == 0): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No assessments assigned.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php while($r=mysqli_fetch_assoc($res)): ?>

                        <?php
                        $title = htmlspecialchars($r['title'] ?? 'Untitled');

                        if (!empty($r['due_date']) && $r['due_date'] !== '0000-00-00') {
                            $ts = strtotime($r['due_date']);
                            $due = $ts ? date('d M Y',$ts) : htmlspecialchars($r['due_date']);
                        } else {
                            $due = "No Due Date";
                        }

                        if (!empty($r['submitted_at'])) {
                            $status = "<span class='badge bg-success'>Submitted</span>";
                        } elseif (!empty($r['started_at'])) {
                            $status = "<span class='badge bg-warning text-dark'>In Progress</span>";
                        } else {
                            $status = "<span class='badge bg-secondary'>Not Started</span>";
                        }
                        ?>

                        <tr>
                            <td><?= $title ?></td>
                            <td><?= $due ?></td>
                            <td><?= $status ?></td>
                            <td>
                                <?php if(!empty($r['submitted_at'])): ?>
                                    <strong><?= (int)$r['score'] ?> / <?= (int)$r['total_questions'] ?></strong>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="take_assessment.php?id=<?= (int)$r['id'] ?>"
                                   class="btn btn-sm btn-primary">
                                    Take / View
                                </a>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<script>
const sidebar=document.getElementById('studentSidebar');
document.getElementById('sidebarToggle')?.addEventListener('click',()=>{
    sidebar.classList.toggle('show');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>