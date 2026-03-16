<?php
session_start();
include '../db_config.php';

if (!isset($_SESSION['teacher_id']))
{
    header('Location: ../teacher_login.php');
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

$now = date('Y-m-d H:i:s');
mysqli_query($conn,"UPDATE teachers SET last_activity='$now' WHERE id='$teacher_id'");


$is_ajax =
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest';


$sql="
SELECT
a.id,
a.title,
a.description,
a.time_limit_minutes,
a.is_published,
a.created_at,
a.due_date,

COUNT(aa.student_id) assigned_count,

SUM(
CASE
WHEN aa.submitted_at IS NOT NULL
THEN 1 ELSE 0
END
) submitted_count,

COALESCE(qcount.qcount,0) total_questions

FROM assessments a

LEFT JOIN assessment_assignments aa
ON a.id=aa.assessment_id

LEFT JOIN
(
SELECT assessment_id,COUNT(*) qcount
FROM assessment_questions
GROUP BY assessment_id
) qcount

ON a.id=qcount.assessment_id

WHERE a.teacher_id=?

GROUP BY a.id

ORDER BY a.created_at DESC
";


$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$result=$stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">


<style>


/* =====================================================
AxE CLEAN RESPONSIVE SYSTEM
Single CSS for entire page
===================================================== */


body
{
margin:0;
background:#f4f6fb;
font-family:Arial;
}



/* MAIN CONTENT */

.main-content
{
padding:20px;
}


@media(max-width:768px)
{
.main-content
{
margin-left:0;
padding:12px;
}
}



/* CONTAINER */

.page-container
{
max-width:1100px;
margin:auto;
}



/* HEADER */

.header-card
{
background:linear-gradient(135deg,#667eea,#764ba2);

color:white;

padding:14px;

border-radius:18px;

text-align:center;

font-size:20px;

font-weight:600;

margin-bottom:18px;

max-width:420px;

margin-left:auto;
margin-right:auto;
}



@media(max-width:480px)
{
.header-card
{
font-size:16px;
padding:12px;
}
}



/* TOP BAR */

.top-bar
{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:16px;
gap:10px;
}


@media(max-width:600px)
{
.top-bar
{
flex-direction:column;
align-items:stretch;
}
}



/* BUTTON */

.create-btn
{
background:#28a745;
color:white;
border-radius:30px;
padding:8px 18px;
font-size:14px;
border:none;
}


.create-btn:hover
{
background:#218838;
}


@media(max-width:600px)
{
.create-btn
{
width:100%;
}
}



/* EMPTY */

.empty-state
{
background:white;
padding:30px 15px;
border-radius:14px;
text-align:center;
box-shadow:0 4px 14px rgba(0,0,0,0.08);
}


.empty-state i
{
font-size:50px;
opacity:.2;
}



/* CARD */

.assessment-card
{
background:white;
border-radius:14px;
box-shadow:0 4px 14px rgba(0,0,0,0.1);
overflow:hidden;
height:100%;
}



.assessment-header
{
background:linear-gradient(135deg,#667eea,#764ba2);
color:white;
padding:12px;
font-size:15px;
font-weight:600;
}



.assessment-body
{
padding:14px;
}



/* BADGES */

.pill-badge
{
padding:4px 10px;
font-size:11px;
border-radius:20px;
}


.badge-questions{background:#007bff;color:white;}
.badge-time{background:#17a2b8;color:white;}
.badge-assigned{background:#ffc107;color:black;}
.badge-status{background:#28a745;color:white;}
.badge-draft{background:#6c757d;color:white;}



/* BUTTONS */

.btn-view
{
background:#007bff;
color:white;
border-radius:20px;
padding:6px 12px;
font-size:12px;
}


.btn-delete
{
background:#dc3545;
color:white;
border-radius:20px;
padding:6px 12px;
font-size:12px;
}



/* GRID */

@media(max-width:768px)
{
.col-md-6,.col-lg-4
{
width:100%;
}
}


</style>

</head>

<body>


<?php if(!$is_ajax) include 'sidebar.php'; ?>


<div class="main-content">

<div class="page-container">


<div class="header-card">
Manage Assessments
</div>


<div class="top-bar">

<h5>Your Created Assessments</h5>

<a href="teacher_dashboard.php?page=teacher_question_pages/assign_assessment.php"
class="btn create-btn">
Create New Assessment
</a>

</div>



<?php if($result->num_rows==0): ?>

<div class="empty-state">

<i class="bi bi-clipboard2-x"></i>

<h5 class="mt-3">No Assessments Created Yet</h5>

<p class="text-muted">
Click the green button to create your first assessment
</p>

</div>


<?php else: ?>


<div class="row g-3">


<?php while($a=$result->fetch_assoc()):

$assigned=(int)$a['assigned_count'];
$submitted=(int)$a['submitted_count'];

$completion=$assigned>0
?round(($submitted/$assigned)*100)
:0;

?>


<div class="col-md-6 col-lg-4">

<div class="assessment-card">

<div class="assessment-header">
<?=htmlspecialchars($a['title'])?>
</div>


<div class="assessment-body">


<div class="mb-2">

<span class="pill-badge badge-questions">
Questions: <?=$a['total_questions']?>
</span>

<span class="pill-badge badge-time">
Time: <?=$a['time_limit_minutes']?>m
</span>

<span class="pill-badge badge-assigned">
Assigned: <?=$assigned?>
</span>

</div>


<div class="d-flex gap-2">

<a href="teacher_dashboard.php?page=teacher_question_pages/view_assessment_results.php&id=<?= $a['id'] ?>"
class="btn btn-view flex-fill">

View
</a>


<button
onclick="location.href='teacher_question_pages/delete_assessment.php?id=<?=$a['id']?>'"
class="btn btn-delete">

Delete

</button>


</div>


</div>

</div>

</div>


<?php endwhile;?>


</div>


<?php endif;?>


</div>

</div>


</body>
</html>