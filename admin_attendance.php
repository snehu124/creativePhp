<?php
session_start();
include 'db_config.php'; // Adjust path if needed

// Enable error reporting (only during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch attendance records with full joins
$query = "
SELECT 
  ar.id,
  s.name AS student_name,
  t.name AS teacher_name,
  sub.subject_name AS subject_name,
  ar.date,
  ar.status
FROM attendance_records ar
JOIN students s ON ar.student_id = s.id
JOIN teachers t ON ar.teacher_id = t.id
JOIN subjects sub ON ar.subject_id = sub.id
ORDER BY ar.date DESC, ar.id DESC
";


$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Attendance Records</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .table-wrapper {
      margin-top: 50px;
    }
  </style>
</head>
<body>
<div class="container table-wrapper">
  <h2 class="mb-4">📋 Attendance Records</h2>
  
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Date</th>
        <th>Student</th>
        <th>Teacher</th>
        <th>Subject</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$i}</td>
            <td>{$row['date']}</td>
            <td>{$row['student_name']}</td>
            <td>{$row['teacher_name']}</td>
            <td>{$row['subject_name']}</td>
            <td>{$row['status']}</td>
          </tr>";
          $i++;
        }
      } else {
        echo "<tr><td colspan='6' class='text-center'>No attendance records found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
