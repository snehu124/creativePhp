<?php
session_start();
include "../db_config.php";
include "student_sidebar.php";
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
$student_id = $_SESSION['student_id'];

// Enrolled courses with course image fetch karo
$sql = "select students.grade, students.created_at, early_learner_courses.course_image, early_learner_courses.subject_id, subjects.subject_name
        from students join early_learner_courses ON early_learner_courses.grade = students.grade
         join subjects on early_learner_courses.subject_id = subjects.id where students.id = '$student_id'";
   
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Enrolled Courses</title>
    <link href = "student.css" rel ="stylesheet">
    <style>
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
        
        .course-img {
            width: 150px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>My Enrolled Courses</h2>
        <?php if(mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Subject</th>
                <!--<th>Course Title</th>-->
                <th>Grade Program</th>
                <th>Enrollment Date</th>
                <th>View</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <?php 
                    $imgPath = !empty($row['course_image']) ? $row['course_image'] : '../images/default-course.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($imgPath); ?>" class="course-img" alt="Course Image">
                </td>
                <td><?= htmlspecialchars($row['subject_name']); ?></td>
                <!--<td><?= htmlspecialchars($row['course_title']); ?></td>-->
                <td><?= htmlspecialchars($row['grade']); ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                  <td>
            <a href="course_sidebar.php?id=<?= urlencode($row['subject_id']); ?>">
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
