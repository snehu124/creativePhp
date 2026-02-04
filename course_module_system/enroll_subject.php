<?php
session_start();
include 'db_config.php';

if (isset($_POST['subject_id']) && isset($_SESSION['student_id'])) {
    $subject_id = $_POST['subject_id'];
    $student_id = $_SESSION['student_id'];

    // Check if already enrolled
    $check = mysqli_query($conn, "
        SELECT * FROM student_enrollments 
        WHERE student_id = $student_id AND subject_id = $subject_id
    ");

    if (mysqli_num_rows($check) == 0) {
        // Not enrolled yet, insert
        mysqli_query($conn, "
            INSERT INTO student_enrollments (student_id, subject_id) 
            VALUES ($student_id, $subject_id)
        ");
    }

    // Redirect to subjects page
    header("Location: subjects.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
