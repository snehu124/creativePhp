<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(['success' => false]);
    exit;
}
include '../db_config.php';
$tid = (int)$_SESSION['teacher_id'];
$sql = "SELECT name FROM teachers WHERE id = $tid";
$result = mysqli_query($conn, $sql);
$name = $result && mysqli_num_rows($result) ? mysqli_fetch_assoc($result)['name'] : 'Teacher';

$hour = (int)date('H');
$greeting = ($hour < 12) ? "Good morning" : ($hour < 17 ? "Good afternoon" : "Good evening");
echo json_encode([
    'success' => true,
    'data' => ['greeting' => "$greeting, $name 👋"]
]);
?>  