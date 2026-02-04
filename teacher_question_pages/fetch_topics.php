<?php
include '../db_config.php';
$chapter_id = intval($_GET['chapter_id']);
$res = mysqli_query($conn, "SELECT id, title FROM topics WHERE chapter_id=$chapter_id ORDER BY title ASC");
echo '<option value="">-- Select Topic --</option>';
while ($r = mysqli_fetch_assoc($res)) {
    echo '<option value="'.$r['id'].'">'.htmlspecialchars($r['title']).'</option>';
}
?>
