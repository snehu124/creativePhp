<?php
session_start();
include 'db_config.php';

$student_id = $_SESSION['student_id']; // Assume student is already logged in
$selected_subject = $_GET['subject_id'] ?? '';
$selected_month = $_GET['month'] ?? date('Y-m');

// Step 1: Get subject list of the student
$subject_query = mysqli_query($conn, "
    SELECT s.id, s.name 
    FROM subjects s
    INNER JOIN student_subjects ss ON s.id = ss.subject_id
    WHERE ss.student_id = '$student_id'
");

// Step 2: Fetch attendance records of student for selected month & subject
$where = "ar.student_id = '$student_id' AND DATE_FORMAT(ar.date, '%Y-%m') = '$selected_month'";
if ($selected_subject !== '') {
    $where .= " AND ar.subject_id = '$selected_subject'";
}

$records = mysqli_query($conn, "
    SELECT ar.*, sub.name AS subject_name 
    FROM attendance_records ar
    INNER JOIN subjects sub ON sub.id = ar.subject_id
    WHERE $where
    ORDER BY ar.date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">📅 My Attendance</h2>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">Select Month:</label>
      <input type="month" name="month" class="form-control" value="<?= $selected_month ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Select Subject:</label>
      <select name="subject_id" class="form-select">
        <option value="">All Subjects</option>
        <?php while ($row = mysqli_fetch_assoc($subject_query)): ?>
          <option value="<?= $row['id'] ?>" <?= ($selected_subject == $row['id']) ? 'selected' : '' ?>>
            <?= $row['name'] ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="col-md-4 align-self-end">
      <button type="submit" class="btn btn-primary">🔍 View</button>
    </div>
  </form>

  <?php if (mysqli_num_rows($records) > 0): ?>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Subject</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while($row = mysqli_fetch_assoc($records)): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['subject_name'] ?></td>
            <td>
              <?php
              $status = $row['status'];
              if ($status == 'Present') echo "<span class='badge bg-success'>$status</span>";
              elseif ($status == 'Absent') echo "<span class='badge bg-danger'>$status</span>";
              else echo "<span class='badge bg-warning text-dark'>$status</span>";
              ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">No attendance found for this filter.</div>
  <?php endif; ?>
</div>
</body>
</html>