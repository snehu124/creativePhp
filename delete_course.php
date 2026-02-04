<?php
include 'db_config.php';

$id = $_POST['id'];
$sql = "DELETE FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_courses.php");
exit;
