<?php
include '../db_config.php';

$on_time = 0;
$late = 0;

// Set login cutoff time
$cutoff = strtotime("10:00:00");

$sql = "SELECT login_time FROM teacher_activity_logs WHERE DATE(login_time) = CURDATE()";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $login_time = strtotime($row['login_time']);
    if ($login_time <= $cutoff) {
        $on_time++;
    } else {
        $late++;
    }
}

echo json_encode([
  "success" => true,
  "data" => [
    "on_time" => $on_time,
    "late" => $late
  ]
]);
?>
