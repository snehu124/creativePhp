<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_config.php'; // ensure DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO teachers (name, email, subject, status, created_at)
            VALUES ('$name', '$email', '$subject', '$status', NOW())";

    if (mysqli_query($conn, $sql)) {
        header('Location: manage_teachers.php?success=1');
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Teacher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <div class="card shadow-sm rounded-4">
    <div class="card-body">
      <h3 class="mb-4 text-primary">➕ Add New Teacher</h3>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">👨‍🏫 Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">📧 Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">📚 Subject</label>
          <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">✅ Status</label>
          <select name="status" class="form-select" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success">➕ Add Teacher</button>
        <a href="manage_teachers.php" class="btn btn-secondary">⬅️ Back</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>
