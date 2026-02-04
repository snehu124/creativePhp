<?php
session_start();
include 'db_config.php';

$teacher_id = $_SESSION['teacher_id'];
$date_today = date('Y-m-d');

// Step 1: Fetch all subject IDs taught by this teacher
$subject_query = mysqli_query($conn, "SELECT subject_id FROM teacher_subjects WHERE teacher_id = '$teacher_id'");
$subject_ids = [];

while ($row = mysqli_fetch_assoc($subject_query)) {
    $subject_ids[] = $row['subject_id'];
}

if (empty($subject_ids)) {
    echo "<script>alert('No subjects assigned to you!'); window.location.href='dashboard.php';</script>";
    exit;
}

$subject_ids_str = implode(',', $subject_ids);

// Step 2: Check if today's attendance already marked
$already_marked = mysqli_query($conn, "
    SELECT id FROM attendance_records 
    WHERE teacher_id = '$teacher_id' AND date = '$date_today' AND subject_id IN ($subject_ids_str)
");

$attendance_already_done = (mysqli_num_rows($already_marked) > 0);

// Step 3: On POST - Save attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$attendance_already_done) {
    foreach ($_POST['attendance'] as $student_id => $status) {
        $subject_id = $_POST['subject'][$student_id];

        // Prevent duplicate insert just in case
        $check = mysqli_query($conn, "
            SELECT id FROM attendance_records 
            WHERE teacher_id = '$teacher_id' AND student_id = '$student_id' 
              AND subject_id = '$subject_id' AND date = '$date_today'
        ");

        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "
                INSERT INTO attendance_records (teacher_id, student_id, subject_id, date, status)
                VALUES ('$teacher_id', '$student_id', '$subject_id', '$date_today', '$status')
            ");
        }
    }

    echo "<script>alert('Attendance Saved!'); window.location='attendance.php';</script>";
    exit;
}

// Step 4: Fetch students (for form if attendance not yet marked)
$student_query = mysqli_query($conn, "
    SELECT DISTINCT s.id, s.first_name, s.last_name, ss.subject_id
    FROM students s
    INNER JOIN student_subjects ss ON s.id = ss.student_id
    WHERE ss.subject_id IN ($subject_ids_str)
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Record Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">📋 Mark Attendance - <?= $date_today ?></h2>

  <?php if ($attendance_already_done): ?>
    <div class="alert alert-info">
      ✅  Today's attendance has already been marked.
    </div>
<?php else: ?>
   <form method="POST" action="attendance.php">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Present</th>
            <th>Absent</th>
            <th>Late</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($student = mysqli_fetch_assoc($student_query)) {
              $sid = $student['id'];
              $sname = $student['first_name'] . ' ' . $student['last_name'];
              $subject_id = $student['subject_id'];
          ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= htmlspecialchars($sname) ?></td>
                <td><input type="radio" name="attendance[<?= $sid ?>]" value="Present" required></td>
                <td><input type="radio" name="attendance[<?= $sid ?>]" value="Absent"></td>
                <td><input type="radio" name="attendance[<?= $sid ?>]" value="Late"></td>
                <input type="hidden" name="subject[<?= $sid ?>]" value="<?= $subject_id ?>">
              </tr>
          <?php
              $i++;
          }

          if ($i === 1) {
              echo "<tr><td colspan='5' class='text-center'>No students found for your subject(s).</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-success">Save Attendance</button>
    </form>
<?php endif; ?>
</div>
</body>
</html>
