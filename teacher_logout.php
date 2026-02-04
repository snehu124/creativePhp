<?php
session_start();
include 'db_config.php';

if (isset($_SESSION['activity_log_id'])) {
    $activity_log_id = $_SESSION['activity_log_id'];
    $logout_time = date("Y-m-d H:i:s");

    // Update logout time and duration
    $sql = "UPDATE teacher_activity_logs 
            SET logout_time = '$logout_time',
                duration = TIMEDIFF('$logout_time', login_time)
            WHERE id = '$activity_log_id'";
    mysqli_query($conn, $sql);
}

// Clear session
session_unset();
session_destroy();

header("Location: teacher_login.php");
exit();
?>
