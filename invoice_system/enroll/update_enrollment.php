<?php
include "../../db_config.php";

$student_id = $_POST['student_id'];
$program = $_POST['program'];
$program_count = $_POST['program_count'];
$subjectsArr = $_POST['subjects'] ?? [];

if(empty($subjectsArr)){
    $subjects = "All Programs";
} else {
    $subjects = implode(", ", $subjectsArr);
}

/* GET CURRENT ACTIVE PLAN */
$old = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM student_plan_history 
WHERE student_id='$student_id' AND status='Active'
"));

/* EXPIRE OLD PLAN */
mysqli_query($conn,"
UPDATE student_plan_history 
SET status='Expired', end_date=CURDATE()
WHERE student_id='$student_id' AND status='Active'
");

/* CALCULATE PRICE */
$grade = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT grade FROM enrollment_inquiries WHERE student_id='$student_id'
"))['grade'];

if($grade == "Pre-School" || $grade == "Grade 1" || $grade == "Grade 2"){
    $price = 150;
}
elseif(in_array($grade, ["Grade 3","Grade 4","Grade 5","Grade 6","Grade 7","Grade 8"])){

    if($program_count == 1){
        $price = 140;
    }
    elseif($program_count == 2){
        $price = 270;
    }
    else{
        $price = 400;
    }

}
else{
    if($program_count == 1){
        $price = 160;
    }
    elseif($program_count == 2){
        $price = 310;
    }
    else{
        $price = 460;
    }
}

/* INSERT NEW PLAN */
mysqli_query($conn,"
INSERT INTO student_plan_history
(student_id, program, program_count, subjects, price, start_date)
VALUES
('$student_id', '$program', '$program_count', '$subjects', '$price', CURDATE())
");

/* UPDATE CURRENT ENROLLMENT */
mysqli_query($conn,"
UPDATE enrollment_inquiries 
SET program='$program', 
    program_count='$program_count', 
    specific_subject='$subjects'
WHERE student_id='$student_id'
");

echo "<script>
alert('Plan updated successfully');
window.location='../../teacher_dashboard.php?page=invoice_system/enroll/manage_enrollment.php';
</script>";