<?php
include 'db_config.php';

$id = $_POST['id'];
$sql = "DELETE FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_students.php");
exit;
