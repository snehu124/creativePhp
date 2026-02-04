<?php
include '../db_config.php';
session_start();

if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../teacher_login.php');
    exit();
}

$id = $_GET['id'] ?? 0;
$q = mysqli_query($conn, "SELECT * FROM quiz_questions WHERE id = $id");
if (!$q || mysqli_num_rows($q) == 0) {
    exit('❌ Question not found.');
}
$data = mysqli_fetch_assoc($q);
$payload = json_decode($data['question_payload'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Question #<?= $data['id'] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {display:flex; margin:0; font-family:Arial, sans-serif;}
    .sidebar {width:220px; background:#2c3e50; color:#fff; padding:20px 10px; min-height:100vh; position:fixed; top:0; left:0; z-index:1000;}
    .sidebar h4 {text-align:center; margin-bottom:30px; font-size:1.2rem;}
    .sidebar a {display:block; color:#fff; padding:12px 15px; margin:6px 0; text-decoration:none; border-radius:6px; font-size:0.95rem; transition:background .2s;}
    .sidebar a:hover, .sidebar a.active {background:#34495e;}
    .sidebar a.active {background:#1a252f; font-weight:bold;}
    .main-content {margin-left:220px; padding:20px; width:100%; background:#f7f7f7; min-height:100vh;}
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h4>👁 View Question #<?= $data['id'] ?></h4>
  <hr>

  <table class="table table-bordered mt-3">
    <tr><th>ID</th><td><?= $data['id'] ?></td></tr>
    <tr><th>Question Text</th><td><?= nl2br(htmlspecialchars($data['question_text'])) ?></td></tr>
    <tr><th>Type</th><td><?= htmlspecialchars($data['question_type']) ?></td></tr>
    <tr><th>Correct Answer</th><td><?= htmlspecialchars($data['correct_answer']) ?></td></tr>
    <tr><th>Unit</th><td><?= htmlspecialchars($data['unit']) ?></td></tr>
    <tr><th>Payload (JSON)</th><td><pre><?= json_encode($payload, JSON_PRETTY_PRINT) ?></pre></td></tr>
    <?php if (!empty($data['question_image'])): ?>
     <tr>
      <th>Image</th>
      <td>
        <img src="https://creativetheka.in/Student_dashboard/<?= htmlspecialchars($data['question_image']) ?>" width="200" alt="Question image">
      </td>
    </tr>
    <?php endif; ?>
  </table>

  <a href="manage_questions.php" class="btn btn-secondary">⬅ Back to List</a>
</div>

<script>
$(function () {
    $('.sidebar a[data-page*="view_question.php"]').addClass('active');
});
</script>

</body>
</html>
