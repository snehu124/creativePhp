<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  $sql = "INSERT INTO teachers (name, email, subject, status, created_at)
            VALUES ('$name', '$email', '$subject', '$status', NOW())";

  if (mysqli_query($conn, $sql)) {
    header('Location: dashboard.php?page=manage_teachers.php&success=1');
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
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Add Teacher</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f4f7fb;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
    }

    /* Card */

    .page-card {
      max-width: 700px;
      margin: auto;
      margin-top: 40px;
      background: white;
      border-radius: 18px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
    }

    /* Header */

    .page-title {
      font-weight: 600;
      font-size: 24px;
      margin-bottom: 20px;

      background: linear-gradient(45deg, #1e88e5, #42a5f5);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Inputs */

    .form-control,
    .form-select {
      border-radius: 10px;
      padding: 10px 12px;
      border: 1px solid #e0e6ed;
    }

    .form-control:focus,
    .form-select:focus {
      box-shadow: 0 0 0 2px rgba(30, 136, 229, .15);
      border-color: #42a5f5;
    }

    /* Buttons */

    .btn-add {
      background: linear-gradient(45deg, #11998e, #38ef7d);
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      color: white;
      font-weight: 500;
    }

    .btn-add:hover {
      opacity: .9;
      color: white;
    }

    .btn-back {
      border-radius: 8px;
      padding: 10px 20px;
    }

    /* Responsive */

    @media(max-width:768px) {

      .page-card {
        padding: 20px;
        margin-top: 20px;
      }

      .page-title {
        font-size: 20px;
      }

    }
  </style>

</head>

<body>

  <div class="container-fluid">

    <div class="page-card">

      <h3 class="page-title">
        <i class="bi bi-person-plus"></i> Add New Teacher
      </h3>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger">
          <?= $error ?>
        </div>
      <?php endif; ?>

      <form method="POST">

        <div class="mb-3">
          <label class="form-label">
            <i class="bi bi-person"></i> Name
          </label>

          <input type="text" name="name" class="form-control" required>
        </div>


        <div class="mb-3">
          <label class="form-label">
            <i class="bi bi-envelope"></i> Email
          </label>

          <input type="email" name="email" class="form-control" required>
        </div>


        <div class="mb-3">
          <label class="form-label">
            <i class="bi bi-book"></i> Subject
          </label>

          <input type="text" name="subject" class="form-control" required>
        </div>


        <div class="mb-4">
          <label class="form-label">
            <i class="bi bi-check-circle"></i> Status
          </label>

          <select name="status" class="form-select" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>

        </div>


        <div class="d-flex gap-2 flex-wrap">

          <button type="submit" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Add Teacher
          </button>

          <a href="javascript:void(0)"
            class="btn btn-secondary btn-back menu-link"
            data-page="manage_teachers.php">
            <i class="bi bi-arrow-left"></i> Back
          </a>

        </div>

      </form>

    </div>

  </div>

</body>

</html>