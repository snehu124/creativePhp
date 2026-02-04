<?php
include '../db_config.php';

$type = $_GET['type'] ?? '';
if (empty($type)) exit;

$q = "SELECT question_payload FROM quiz_questions 
      WHERE question_type = ? AND question_payload IS NOT NULL 
      AND question_payload != '' LIMIT 1";
$stmt = $conn->prepare($q);
$stmt->bind_param("s", $type);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $payload = json_decode($row['question_payload'], true);
    if (is_array($payload)) {
        foreach ($payload as $key => $value) {
            echo '<label>' . htmlspecialchars(ucfirst($key)) . '</label>';
            echo '<input type="text" name="extra[' . htmlspecialchars($key) . ']" class="form-control mb-2" placeholder="Enter ' . htmlspecialchars($key) . '">';
        }
    } else {
        echo '<em>No fields found in payload.</em>';
    }
} else {
    echo '<em>No previous payload found for this type.</em>';
}
?>
