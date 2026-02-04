<?php
include '../db_config.php';
$subject_id = intval($_GET['subject_id']);
$res = mysqli_query($conn, "SELECT id, chapter_name FROM chapters WHERE subject_id=$subject_id ORDER BY chapter_name ASC");
echo '<option value="">-- Select Chapter --</option>';
while ($r = mysqli_fetch_assoc($res)) {
    echo '<option value="'.$r['id'].'">'.htmlspecialchars($r['chapter_name']).'</option>';
}
?>
