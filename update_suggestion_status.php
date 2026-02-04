<?php
include 'db_config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    $allowed = ['Approved', 'Rejected'];
    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE course_suggestions SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: view_suggestions.php");
exit;
