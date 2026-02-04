<?php
include 'db_config.php';

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$created_by = $_POST['created_by'];

$sql = "INSERT INTO courses (title, description, price, created_by, visible_to_teachers, created_at)
        VALUES (?, ?, ?, ?, 1, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdi", $title, $description, $price, $created_by);
$stmt->execute();

header("Location: add_materials.php?course_id=" . $course_id);
exit;
