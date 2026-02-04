<?php
session_start();
include "db_config.php";

// Show errors during debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    echo "Material ID not provided.";
    exit;
}

$id = intval($_GET['id']);

// Get file path and course ID
$sql = "SELECT file_path, course_id FROM course_materials WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Material not found.";
    exit;
}

$material = mysqli_fetch_assoc($result);

// Delete file from server
if (!empty($material['file_path']) && file_exists($material['file_path'])) {
    unlink($material['file_path']);
}

// Delete record from database
$delete_sql = "DELETE FROM course_materials WHERE id = $id";
if (!mysqli_query($conn, $delete_sql)) {
    echo "Failed to delete record: " . mysqli_error($conn);
    exit;
}

// Redirect back to materials view
header("Location: view_materials.php?course_id=" . $material['course_id']);
exit();
?>
