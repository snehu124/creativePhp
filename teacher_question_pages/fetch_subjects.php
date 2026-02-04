<?php
include '../db_config.php';

$grade = $_GET['grade'] ?? '';
if (!$grade) {
    echo '<option value="">-- Select Subject --</option>';
    exit;
}

$sql = "SELECT id, subject_name FROM subjects WHERE grade = ? ORDER BY subject_name ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $grade);
$stmt->execute();
$res = $stmt->get_result();

echo '<option value="">-- Select Subject --</option>';
if ($res && $res->num_rows > 0) {
    while ($r = $res->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($r['id']) . '">' . htmlspecialchars($r['subject_name']) . '</option>';
    }
}
$stmt->close();
