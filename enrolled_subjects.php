<?php
session_start();
include "db_config.php";

// Debug mode ON (sirf testing ke liye)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Agar login nahi hua to stop karo
if (!isset($_SESSION['student_email'])) {
    echo "<h3>Please login to view your enrolled courses.</h3>";
    exit;
}

$email = $_SESSION['student_email'];

// Enrolled courses with course image fetch karo
$sql = "
    SELECT s.course_id, s.course_title, s.grade, s.created_at, c.course_image
    FROM students s
    LEFT JOIN early_learner_courses c 
        ON s.course_id = c.id
    WHERE s.email = '$email'
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Enrolled Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 220px;
            background: #2d3748;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            padding: 20px;
        }
        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #4a5568;
        }
        .content {
            margin-left: 240px;
            padding: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .logout-btn {
            display: inline-block;
            background: #e53e3e;
            color: white;
            padding: 10px 15px;
            margin-top: 20px;
            text-decoration: none;
        }
        .course-img {
            width: 150px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Student Panel</h2>
        <a href="student_dashboard.php">My Profile</a>
        <a href="enrolled_subjects.php">Enrolled Subjects</a>
        <a href="study_materials.php">Study Materials</a>
        <a href="progress.php">Progress Tracker</a>
        <a href="announcements.php">Announcements</a>
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>My Enrolled Courses</h2>
        <?php if(mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Course ID</th>
                <th>Course Title</th>
                <th>Grade Program</th>
                <th>Enrollment Date</th>
                <th>View</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <?php 
                    $imgPath = !empty($row['course_image']) ? $row['course_image'] : 'images/default-course.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($imgPath); ?>" class="course-img" alt="Course Image">
                </td>
                <td><?= htmlspecialchars($row['course_id']); ?></td>
                <td><?= htmlspecialchars($row['course_title']); ?></td>
                <td><?= htmlspecialchars($row['grade']); ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                  <td>
            <a href="view_course.php?id=<?= urlencode($row['course_id']); ?>" target="_blank">
                View
            </a>
        </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
        <p>You have not enrolled in any courses yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
