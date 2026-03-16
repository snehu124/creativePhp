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
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
  

<style>

/* BODY */
body{
    background: linear-gradient(135deg,#f8f9ff,#e0e7ff);
    margin:0;
    font-family:'Segoe UI',system-ui,sans-serif;
}


/* MAIN LAYOUT */
.main-layout{
    display:flex;
    min-height:100vh;
}


/* CONTENT AREA FULL WIDTH FIX */
.content-area{

    margin-left:260px;
    padding:30px;

    width:calc(100% - 260px);
    max-width:calc(100% - 260px);

}


/* TABLE CARD */
.table-container{

    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);

}


/* TABLE RESPONSIVE SCROLL */
.table-responsive{

    overflow-x:auto;
    -webkit-overflow-scrolling:touch;

}


/* TABLE DEFAULT */
.table{

    width:100%;
    white-space:nowrap;

}

.container-fluid h3{
   font-size: 42px;
   font-weight: 400;
   margin-bottom: 6px !important;
   background: linear-gradient(to right, #e02121, #2f55a4);
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   font-family: "Love Ya Like A Sister", cursive;
   margin-left: 8px;
}

/* SCROLL ONLY BELOW 1280px */
@media(max-width:1280px){

    .table{

        min-width:1200px;

    }

}


/* TABLET */
@media(max-width:992px){

    .content-area{

        margin-left:0;
        width:100%;
        max-width:100%;
        padding:20px;
        padding-top:80px;

    }

}

/* MOBILE */
@media(max-width:576px){

    .content-area{

        padding:15px;
        padding-top:75px;

    }

    .table-container{

        padding:10px;

    }

    h3{

        font-size:20px;

    }

}

/* SIDEBAR BUTTON */
#sidebarToggle{

    top:15px;
    left:15px;
    z-index:1100;
    border-radius:50%;
    width:48px;
    height:48px;

}

</style>
</head>

<body>

<div class="main-layout">

    <!-- SIDEBAR -->
    <?php include "student_sidebar.php"; ?>


    <!-- MOBILE SIDEBAR BUTTON -->
    <button class="btn btn-primary d-lg-none position-fixed"
            id="sidebarToggle">

        <i class="bi bi-list fs-4"></i>

    </button>



    <!-- CONTENT -->
    <div class="content-area container-fluid">

        <h3 class="mb-4">
            Purchase History
        </h3>

        <!-- TABLE -->
        <div class="table-container">

            <!-- SCROLL WRAPPER -->
            <div class="table-responsive">

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

                            <td>
                                ₹<?= number_format($student['price'],2) ?>
                            </td>

                            <td>
                                ₹<?= number_format($student['gst'],2) ?>
                            </td>

                            <td>
                                ₹<?= number_format($student['total'],2) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['payment_id'] ?? 'N/A') ?>
                            </td>

                            <td>
                                <?= ucfirst($student['payment_status']) ?>
                            </td>

                            <td>
                                <?= ucfirst($student['mode_of_education']) ?>
                            </td>

                            <td>
                                <?= ucfirst($student['payment_type']) ?>
                            </td>

                            <td>
                                <?= date("d M Y, h:i A", strtotime($student['created_at'])) ?>
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



<script>

const sidebar = document.getElementById('studentSidebar');

document.getElementById('sidebarToggle')
.addEventListener('click', function(){

    sidebar.classList.toggle('show');

});

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>