<?php
// add_materials.php
$course_id = $_GET['course_id'];
?>

<form method="POST" enctype="multipart/form-data" action="upload_materials.php">
  <input type="hidden" name="course_id" value="<?= $course_id ?>">

  <label>Upload Study PDF(s)</label>
  <input type="file" name="study_pdfs[]" accept=".pdf" multiple required>

  <label>Add Video Link (YouTube)</label>
  <input type="text" name="video_links[]" placeholder="YouTube URL">

  <button type="submit" name="upload">Upload Materials</button>
</form>
