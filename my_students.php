<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_config.php'; // adjust path if needed

if (!isset($_SESSION['teacher_id']) || !isset($_SESSION['teacher_subject'])) {
    echo "<div class='alert alert-danger'>Unauthorized access.</div>";
    exit;
}

$subject = $_SESSION['teacher_subject'];

$sql = "SELECT first_name as name, email, phone, gender, dob FROM students WHERE subject = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $subject);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2 class='mb-4'>👨‍🎓 My Students (Subject: <strong>$subject</strong>)</h2>";

if ($result->num_rows > 0) {
    echo "<div class='table-responsive'>
            <table class='table table-bordered table-striped'>
                <thead class='table-dark'>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>DOB</th>
                    </tr>
                </thead>
                <tbody>";
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$i}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['dob']}</td>
              </tr>";
        $i++;
    }
    echo "</tbody></table></div>";
} else {
    echo "<p class='text-muted'>No students found for your subject.</p>";
}
?>
