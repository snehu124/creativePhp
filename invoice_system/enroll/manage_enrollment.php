<?php
include "../../db_config.php";

$result = mysqli_query($conn,"
SELECT student_id, first_name, last_name, program, program_count, specific_subject, grade
FROM enrollment_inquiries
WHERE status='Active'
ORDER BY id DESC
");
?>

<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<div class="invoice-dashboard">

<h2 class="dashboard-title">
<i class="bi bi-pencil-square"></i> Manage Enrollment
</h2>

<div class="invoice-table">

<div class="table-scroll">

<table class="table table-hover">

<thead>
<tr>
<th>Student</th>
<th>Grade</th>
<th>Program</th>
<th>Count</th>
<th>Subjects</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($result) == 0){ ?>
<tr>
<td colspan="6" style="text-align:center;">No students found</td>
</tr>
<?php } ?>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
<td><?php echo $row['grade']; ?></td>
<td><?php echo $row['program']; ?></td>
<td><?php echo $row['program_count']; ?></td>
<td><?php echo $row['specific_subject']; ?></td>

<td class="action-btns">

<a class="btn btn-edit"
href="teacher_dashboard.php?page=invoice_system/enroll/edit_enrollment.php&student_id=<?php echo $row['student_id']; ?>">
<i class="bi bi-pencil"></i> Edit
</a>

<a class="btn btn-history"
href="teacher_dashboard.php?page=invoice_system/enroll/plan_history.php&student_id=<?php echo $row['student_id']; ?>">
<i class="bi bi-clock-history"></i> History
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<style>

.invoice-dashboard{
  width:100%;
}

.dashboard-title{
  font-size:30px;
  color:#05364d;
  margin-bottom:25px;
  font-family:"Love Ya Like A Sister", cursive;
}

.invoice-table{
  background:white;
  padding:20px 26px;
  border-radius:15px;
}

.table-scroll{
  overflow-x:auto;
}

.table{
  width:100%;
  min-width:700px;
}

.table thead{
  background:#f1f3f6;
}

.table th,
.table td{
  padding:12px 10px;
  vertical-align:middle;
}

.action-btns{
  display:flex;
  gap:8px;
  justify-content:flex-end;
}

/* BUTTONS */
.btn-edit{
  background: linear-gradient(160deg,#1e3a8a,#2563eb);
  color:white;
  padding:6px 12px;
  border-radius:20px;
  font-size:13px;
}

.btn-history{
  background: linear-gradient(160deg,#166534,#22c55e);
  color:white;
  padding:6px 12px;
  border-radius:20px;
  font-size:13px;
}

/* MOBILE */
@media(max-width:768px){

  .invoice-table{
    padding:15px 10px;
  }

  .action-btns{
    flex-direction:row;
  }

  .btn-edit,
  .btn-history{
    font-size:12px;
    padding:5px 10px;
  }
}

</style>