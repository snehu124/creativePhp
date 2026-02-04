<?php
include 'db_config.php'; // DB connection

$sql = "SELECT cs.*, t.name AS teacher_name, s.subject_name 
        FROM course_suggestions cs
        JOIN teachers t ON cs.teacher_id = t.id
        JOIN subjects s ON cs.subject_id = s.id
        ORDER BY cs.submitted_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Course Suggestions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3 class="mb-4">📚 Course Suggestions</h3>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Teacher</th>
          <th>Subject</th>
          <th>Suggestion</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$i}</td>
                  <td>{$row['teacher_name']}</td>
                  <td>{$row['subject_name']}</td>
                  <td>{$row['suggestion']}</td>
                  <td>{$row['status']}</td>
                  <td>
                    <a href='update_suggestion_status.php?id={$row['id']}&status=Approved' class='btn btn-success btn-sm'>Approve</a>
                    <a href='update_suggestion_status.php?id={$row['id']}&status=Rejected' class='btn btn-danger btn-sm'>Reject</a>
                  </td>
                </tr>";
          $i++;
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
