<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM teachers WHERE id = $id";
    $res = mysqli_query($conn, $query);

    if ($res) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false]);
    }
}
?>
