<!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$date_today = date('Y-m-d');


/*
------------------------------------
STEP 1: Get teacher subjects
------------------------------------
*/

$subject_query = mysqli_query($conn, "
    SELECT subject_id 
    FROM teacher_subjects 
    WHERE teacher_id = '$teacher_id'
");

$subject_ids = [];

while ($row = mysqli_fetch_assoc($subject_query)) {
    $subject_ids[] = $row['subject_id'];
}


/*
------------------------------------
IF NO SUBJECT ASSIGNED
------------------------------------
*/

if (empty($subject_ids)) {

    echo "
    <div style='padding:20px;'>

        <div class='alert alert-danger'>
            ❌ No subjects assigned to you.<br>
            Please contact admin.
        </div>

        <a href='teacher_dashboard.php' class='btn btn-primary'>
            ← Back to Dashboard
        </a>

    </div>";

    exit;
}


$subject_ids_str = implode(',', $subject_ids);


/*
------------------------------------
STEP 2: Check attendance already done
------------------------------------
*/

$check_query = mysqli_query($conn, "
    SELECT id 
    FROM attendance_records
    WHERE teacher_id = '$teacher_id'
    AND date = '$date_today'
    AND subject_id IN ($subject_ids_str)
");

$attendance_already_done = mysqli_num_rows($check_query) > 0;


/*
------------------------------------
STEP 3: SAVE attendance
------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$attendance_already_done) {

    foreach ($_POST['attendance'] as $student_id => $status) {

        $subject_id = $_POST['subject'][$student_id];

        $check = mysqli_query($conn, "
            SELECT id FROM attendance_records
            WHERE teacher_id = '$teacher_id'
            AND student_id = '$student_id'
            AND subject_id = '$subject_id'
            AND date = '$date_today'
        ");

        if (mysqli_num_rows($check) == 0) {

            mysqli_query($conn, "
                INSERT INTO attendance_records
                (teacher_id, student_id, subject_id, date, status)
                VALUES
                ('$teacher_id', '$student_id', '$subject_id', '$date_today', '$status')
            ");

        }

    }

    echo "
    <script>
        alert('Attendance saved successfully');
        window.location='teacher_dashboard.php';
    </script>";

    exit;
}

/*STEP 4: Fetch students*/

$student_query = mysqli_query($conn, "
    SELECT DISTINCT s.id, s.first_name, s.last_name, ss.subject_id
    FROM students s
    INNER JOIN student_subjects ss
        ON s.id = ss.student_id
    WHERE ss.subject_id IN ($subject_ids_str)
");

?>

<div class="container mt-4">

<h3 class="mb-4">
📋 Mark Attendance
<small class="text-muted">(<?= $date_today ?>)</small>
</h3>


<?php if ($attendance_already_done): ?>

<div class="alert alert-success">
✅ Attendance already marked today.
</div>

<a href="teacher_dashboard.php" class="btn btn-primary">
Back to Dashboard
</a>


<?php else: ?>


<form method="POST">

<div class="table-responsive">

<table class="table table-bordered">

<thead class="table-head">

<tr>
<th>Id</th>
<th>Students</th>
<th>Present</th>
<th>Absent</th>
<th>Late</th>
</tr>

</thead>

<tbody>

<?php

$i = 1;

while ($student = mysqli_fetch_assoc($student_query)) {

$sid = $student['id'];

$name = $student['first_name'] . ' ' . $student['last_name'];

$subject_id = $student['subject_id'];

?>

<tr>

<td><?= $i ?></td>

<td><?= htmlspecialchars($name) ?></td>

<td>
<input type="radio"
name="attendance[<?= $sid ?>]"
value="Present"
required>
</td>

<td>
<input type="radio"
name="attendance[<?= $sid ?>]"
value="Absent">
</td>

<td>
<input type="radio"
name="attendance[<?= $sid ?>]"
value="Late">
</td>

<input type="hidden"
name="subject[<?= $sid ?>]"
value="<?= $subject_id ?>">

</tr>

<?php

$i++;

}

if ($i == 1) {

echo "
<tr>
<td colspan='5' class='text-center'>
No students found.
</td>
</tr>";

}

?>

</tbody>

</table>

</div>


<button type="submit" class="btn btn-success">
Save Attendance
</button>

<a href="teacher_dashboard.php" class="btn btn-secondary">
Cancel
</a>

</form>
<?php endif; ?>
</div>
<style>.table-head{
  background:#e8063c !important;
  color:#fff;
}

.table-head th{
  background:#e8063c !important;
  color:#fff;
  border:none !important; 
}
h3{
    font-size: 30px;
color: #05364d;
margin-bottom: 25px;
font-family: "Love Ya Like A Sister", cursive;
}
@media (max-width:768px){
    .table-head th{
        font-size: 14px;
    }
    h3{
        font-size: 22px;
    }
}
</style>