<?php
include '../db_config.php';

header('Content-Type: application/json');

$sql = "SELECT t.name, a.login_time, a.logout_time 
        FROM teacher_activity_logs a
        JOIN teachers t ON a.teacher_id = t.id
        ORDER BY a.login_time DESC 
        LIMIT 5";

$result = mysqli_query($conn, $sql);
$activities = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $desc = $row['name'] . " logged in at " . date("d M Y, h:i A", strtotime($row['login_time']));
        if ($row['logout_time']) {
            $desc .= " and logged out at " . date("h:i A", strtotime($row['logout_time']));
        }
        $activities[] = [
            "description" => $desc,
            "timestamp" => $row['login_time']
        ];
    }

    echo json_encode([
        "success" => true,
        "data" => $activities
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch data"
    ]);
}
