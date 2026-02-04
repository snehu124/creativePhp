<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_config.php';

$teacher_id = $_POST['id'];

$sql = "DELETE FROM teachers WHERE id = '$teacher_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Teacher removed successfully']);
} else {
    echo json_encode(['status' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
}
?>
