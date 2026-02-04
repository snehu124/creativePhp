<?php
session_start();
include 'db_config.php';

$teacher_id = $_SESSION['teacher_id'];
$sql = "SELECT * FROM teacher_events WHERE teacher_id = $teacher_id";
$result = mysqli_query($conn, $sql);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end']
    ];
}
echo json_encode($events);
?>
