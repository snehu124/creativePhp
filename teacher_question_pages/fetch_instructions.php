<?php
include '../db_config.php';
$topic_id = intval($_GET['topic_id']);
$res = mysqli_query($conn, "SELECT id, instruction FROM instructions WHERE topic_id=$topic_id ORDER BY id DESC");
echo '<option value="">-- Select Instruction --</option>';
while ($r = mysqli_fetch_assoc($res)) {
    echo '<option value="'.$r['id'].'">'.htmlspecialchars($r['instruction']).'</option>';
}
?>
