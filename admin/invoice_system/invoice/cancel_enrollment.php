<?php 
include "../../../db_config.php";

$id = $_GET['id'];

// 🔹 Step 1: get student_id
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT student_id 
FROM enrollment_inquiries 
WHERE id='$id'
"));

$student_id = $data['student_id'] ?? 0;

// 🔹 Step 2: update enrollment
mysqli_query($conn,"
UPDATE enrollment_inquiries 
SET status='Cancelled' 
WHERE id='$id'
");

// 🔹 Step 3: update plan history
mysqli_query($conn,"
UPDATE student_plan_history 
SET status='Cancelled', end_date=CURDATE()
WHERE student_id='$student_id' AND status='Active'
");

// 🔹 Step 4: update students table status
mysqli_query($conn,"
UPDATE students 
SET status = 0 
WHERE id='$student_id'
");

// 🔹 redirect
echo "<script>
alert('Enrollment Cancelled');
window.location.href='dashboard.php?page=invoice_system/dashboard/invoice_dashboard.php';
</script>";
?>