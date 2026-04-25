<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['id']);

    $query = "DELETE FROM branches WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false]);
    }
}
?>