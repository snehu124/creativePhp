<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $status = $_POST['status'];

    $query = "UPDATE teachers SET 
              name = '$name', 
              email = '$email', 
              subject = '$subject', 
              status = '$status' 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_teachers.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
