<?php
include '../db_config.php';
$instruction_id = intval($_GET['instruction_id'] ?? 0);
echo '<option value="">-- Select Question Type --</option>';

$res = mysqli_query($conn, "SELECT question_types FROM instructions WHERE id=$instruction_id");
if ($res && $row = mysqli_fetch_assoc($res)) {
    $types = explode(',', $row['question_types']);
    foreach ($types as $type) {
        $type = trim($type);
        if ($type !== '') {
            echo '<option value="'.htmlspecialchars($type).'">'.htmlspecialchars($type).'</option>';
        }
    }
}
?>
