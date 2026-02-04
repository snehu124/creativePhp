<?php
session_start();
include 'db_config.php';

$teacher_id = $_SESSION['teacher_id']; // Or admin ID if needed
$selected_date = $_GET['date'] ?? date('Y-m-d');
$selected_subject = $_GET['subject_id'] ?? '';

// Step 1: Fetch all subjects for dropdown
$subject_query = mysqli_query($conn, "
    SELECT DISTINCT s.id, s.name 
    FROM subjects s
    INNER JOIN teacher_subjects ts ON s.id = ts.subject_id
    WHERE ts.teacher_id = '$teacher_id'
");

// Step 2: Fetch attendance records based on filters
$where_clause = "ar.date = '$selected_date' AND ar.teacher_id = '$teacher_id'";
if ($selected_subject !== '') {
    $where_clause .= " AND ar.subject_id = '$selected_subject'";
}

$attendance_query = mysqli_query($conn, "
    SELECT ar.*, st.name AS student_name, sub.name AS subject_name
    FROM attendance_records ar
    INNER JOIN students st ON st.id = ar.student_id
    INNER JOIN subjects sub ON sub.id = ar.subject_id
    WHERE $where_clause
    ORDER BY ar.subject_id, st.name
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">📊 Attendance Records</h2>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <label for="date" class="form-label">Select Date:</label>
      <input type="date" name="date" id="date" class="form-control" value="<?= $selected_date ?>" required>
    </div>

    <div class="col-md-4">
      <label for="subject_id" class="form-label">Select Subject:</label>
      <select name="subject_id" id="subject_id" class="form-select">
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

  <?php if (mysqli_num_rows($attendance_query) > 0): ?>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Student</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while($row = mysqli_fetch_assoc($attendance_query)): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['student_name'] ?></td>
            <td><?= $row['subject_name'] ?></td>
            <td>
              <?php
                $status = $row['status'];
                if ($status == 'Present') echo "<span class='badge bg-success'>$status</span>";
                elseif ($status == 'Absent') echo "<span class='badge bg-danger'>$status</span>";
                else echo "<span class='badge bg-warning text-dark'>$status</span>";
              ?>
            </td>
            <td><?= $row['date'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">No attendance records found for selected filters.</div>
  <?php endif; ?>
</div>
</body>
</html>
