<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(['success'=>false]);
    exit;
}

include __DIR__ . '/../db_config.php';

$tid = (int)$_SESSION['teacher_id'];
$today = date('Y-m-d');

$sql = "SELECT COUNT(*) AS cnt, 
        (SELECT CONCAT(TIME(class_datetime), ' - ', title) 
         FROM classes 
         WHERE teacher_id = $tid 
         AND DATE(class_datetime) = '$today' 
         ORDER BY class_datetime ASC 
         LIMIT 1) AS next_class
        FROM classes 
        WHERE teacher_id = $tid 
        AND DATE(class_datetime) = '$today'";

$res = mysqli_query($conn, $sql);

if(!$res){
    echo json_encode(['success'=>false,'error'=>mysqli_error($conn)]);
    exit;
}

$row = mysqli_fetch_assoc($res);

echo json_encode([
    'success'=>true,
    'data'=>[
        'count'=>(int)$row['cnt'],
        'next'=>$row['next_class'] ?? 'No class today'
    ]
]);