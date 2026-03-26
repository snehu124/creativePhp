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

$sql = "SELECT COUNT(DISTINCT asa.student_id) AS total
        FROM assessment_student_answers asa
        JOIN assessments a ON asa.assessment_id = a.id
        WHERE a.teacher_id = $tid";

$res = mysqli_query($conn, $sql);

if(!$res){
    echo json_encode([
        'success'=>false,
        'error'=>mysqli_error($conn)
    ]);
    exit;
}

$row = mysqli_fetch_assoc($res);

echo json_encode([
    'success'=>true,
    'data'=>[
        'count'=>(int)$row['total'],
        'trend'=>'active in assessments'
    ]
]);