<?php
session_start();
include '../db_config.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$query = "
SELECT 
  ar.id,
  CONCAT(COALESCE(s.first_name,''), ' ', COALESCE(s.last_name,'')) AS student_name,
  COALESCE(t.name, '') AS teacher_name,
  COALESCE(sub.subject_name, '') AS subject_name,
  ar.date,
  ar.status
FROM attendance_records ar
LEFT JOIN students s ON ar.student_id = s.id
LEFT JOIN teachers t ON ar.teacher_id = t.id
LEFT JOIN subjects sub ON ar.subject_id = sub.id
ORDER BY ar.date DESC, ar.id DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>

  <title>Attendance Records</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: #f5f7fb;
      font-family: 'Poppins', sans-serif;
    }

    /* Card */

    .attendance-card {
      background: white;
      border-radius: 18px;
      padding: 25px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
    }

    /* Header */

    .attendance-title {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 20px;
      background: linear-gradient(45deg, #1e88e5, #42a5f5);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Table */

    .table {
      border-radius: 12px;
      overflow: hidden;
    }

    .table thead th {
      background: linear-gradient(45deg, #1e88e5, #42a5f5);
      color: white;
      border: none;
      padding: 14px;
      font-weight: 500;
      white-space: nowrap;
    }

    .table tbody tr {
      transition: .3s;
    }

    .table tbody tr:hover {
      background: #f4f8ff;
    }

    .table td {
      padding: 14px;
      vertical-align: middle;
      white-space: nowrap;
    }

    /* Status */

    .status-present {
      background: linear-gradient(45deg, #00b09b, #96c93d);
      color: white;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 500;
    }

    .status-absent {
      background: linear-gradient(45deg, #ff416c, #ff4b2b);
      color: white;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 500;
    }

    /* Mobile Responsive */

    @media(max-width:992px) {

      .attendance-card {
        padding: 15px;
      }

      .table td,
      .table th {
        font-size: 13px;
        padding: 10px;
      }

    }

    @media(max-width:768px) {

      .attendance-title {
        font-size: 18px;
      }

      .table {
        font-size: 12px;
      }

      .status-present,
      .status-absent {
        font-size: 11px;
        padding: 5px 10px;
      }

    }
  </style>

</head>

<body>

  <div class="container-fluid mt-3">

    <div class="attendance-card">

      <h4 class="attendance-title">
        📋 Attendance Records
      </h4>

      <div class="table-responsive">

        <table class="table align-middle text-center">

          <thead>
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

            if ($result && mysqli_num_rows($result) > 0) {

              while ($row = mysqli_fetch_assoc($result)) {

                $student = htmlspecialchars($row['student_name'] ?? '');
                $teacher = htmlspecialchars($row['teacher_name'] ?? '');
                $subject = htmlspecialchars($row['subject_name'] ?? '');
                $date = htmlspecialchars($row['date'] ?? '');

                if ($row['status'] == 'Present') {
                  $statusBadge = '<span class="status-present">Present</span>';
                } else {
                  $statusBadge = '<span class="status-absent">Absent</span>';
                }

                echo "

<tr>

<td>{$i}</td>
<td>{$date}</td>
<td>{$student}</td>
<td>{$teacher}</td>
<td>{$subject}</td>
<td>{$statusBadge}</td>

</tr>

";

                $i++;
              }
            } else {

              echo "<tr>
<td colspan='6' class='text-muted'>No attendance records found</td>
</tr>";
            }

            ?>

          </tbody>

        </table>

      </div>

    </div>

  </div>

</body>

</html>