<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include 'db_config.php';

$teacher_id = $_SESSION['teacher_id'] ?? null;

// Fetch subjects of this teacher
$subject_q = mysqli_query($conn, "SELECT s.id, s.subject_name FROM subjects s 
JOIN teacher_subjects ts ON s.id = ts.subject_id 
WHERE ts.teacher_id = '$teacher_id'");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Suggest New Course</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h3>📩 Suggest a Course</h3>

  <form method="POST" action="suggest_course_submit.php" class="mt-4">
    <div class="mb-3">
      <label>Select Subject</label>
      <select name="subject_id" class="form-select" required>
        <option value="">-- Select --</option>
        <?php while ($row = mysqli_fetch_assoc($subject_q)) {
          echo "<option value='{$row['id']}'>{$row['name']}</option>";
        } ?>
      </select>
    </div>

    <div class="mb-3">
      <label>Your Suggestion</label>
      <textarea name="suggestion" class="form-control" rows="5" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit Suggestion</button>
  </form>
</body>
</html>
