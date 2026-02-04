<?php
include 'db_config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];

$sql = "INSERT INTO students (name, email, phone, gender, dob, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $phone, $gender, $dob);
$stmt->execute();

header("Location: manage_students.php");
exit;
