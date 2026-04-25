<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = intval($_POST['id']);
    $status = $_POST['status'];

    if (!in_array($status, ['active', 'inactive'])) {
        echo json_encode(['status' => false]);
        exit;
    }

    $query = "UPDATE teachers SET status='$status' WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false]);
    }
}
?>