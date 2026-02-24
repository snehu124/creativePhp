<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../db_config.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../student_login.php");
    exit();
}

$student_id = (int)$_SESSION['student_id'];

// Get student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$student_name = $student['first_name'] . ' ' . $student['last_name'];

$currentpage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purchase History</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="student.css" rel="stylesheet">

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
    margin-left:260px; /* SAME AS OTHER PAGES */
    padding:35px 45px;
    flex:1;
}

.table-container{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    overflow-x:auto;
}

table th{
    background:#f1f3f5;
    font-weight:600;
}

@media(max-width:992px){
    .content-area{
        margin-left:0;
        padding-top:80px;
    }
}
</style>
</head>

<body>

<div class="main-layout">

    <!-- ✅ SIDEBAR (NOW PROPERLY PLACED) -->
    <?php include "student_sidebar.php"; ?>

    <!-- Mobile toggle -->
    <button class="btn btn-primary d-lg-none position-fixed"
            id="sidebarToggle"
            style="top:15px;left:15px;z-index:1100;border-radius:50%;width:48px;height:48px;">
        <i class="bi bi-list fs-4"></i>
    </button>

    <!-- ✅ CONTENT AREA -->
    <div class="content-area">

        <h3 class="fw-bold text-primary mb-4">
            <i class="bi bi-receipt-cutoff me-2"></i>
            Purchase History
        </h3>

        <div class="table-container">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Price</th>
                        <th>GST</th>
                        <th>Total</th>
                        <th>Payment ID</th>
                        <th>Status</th>
                        <th>Mode</th>
                        <th>Type</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (empty($student['course_title'])): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No purchase history found.
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= htmlspecialchars($student['course_title']) ?></td>
                        <td>₹<?= number_format($student['price'],2) ?></td>
                        <td>₹<?= number_format($student['gst'],2) ?></td>
                        <td>₹<?= number_format($student['total'],2) ?></td>
                        <td><?= htmlspecialchars($student['payment_id'] ?? 'N/A') ?></td>
                        <td><?= ucfirst($student['payment_status']) ?></td>
                        <td><?= ucfirst($student['mode_of_education']) ?></td>
                        <td><?= ucfirst($student['payment_type']) ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($student['created_at'])) ?></td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
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