<?php
session_start();
include 'db_config.php';

if (!isset($_POST['id'])) {
    die("Invalid Request");
}

$student_id = (int)$_POST['id'];

mysqli_begin_transaction($conn);

try {

    // Disable student
    mysqli_query($conn,"
        UPDATE students
        SET status='0'
        WHERE id='$student_id'
    ");

    // Cancel enrollment
    mysqli_query($conn,"
        UPDATE enrollment_inquiries
        SET status='Cancelled'
        WHERE student_id='$student_id'
    ");

    // Close active plan
    mysqli_query($conn,"
        UPDATE student_plan_history
        SET status='Cancelled',
            end_date=CURDATE()
        WHERE student_id='$student_id'
        AND status='Active'
    ");

    // Disable subject assignments
    mysqli_query($conn,"
        UPDATE student_subjects
        SET status='0'
        WHERE student_id='$student_id'
    ");

    // Cancel course enrollments
    mysqli_query($conn,"
        UPDATE course_enrollments
        SET status='Cancelled'
        WHERE student_id='$student_id'
    ");

    mysqli_commit($conn);

    echo "<script>
        alert('Student deleted successfully.');
        window.location.href='teacher_dashboard.php?page=manage_students.php';
    </script>";

} catch (Exception $e) {

    mysqli_rollback($conn);

    echo "<script>
        alert('Unable to delete student.');
        window.location.href='teacher_dashboard.php?page=manage_students.php';
    </script>";
}
?>