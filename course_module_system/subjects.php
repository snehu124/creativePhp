<?php
session_start();
include 'db_config.php';

$student_id = $_SESSION['student_id'] ?? 0;

// Fetch enrolled subjects
$query = mysqli_query($conn, "
    SELECT subjects.* FROM subjects 
    JOIN student_enrollments ON subjects.id = student_enrollments.subject_id 
    WHERE student_enrollments.student_id = $student_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Subjects</title>
</head>
<body>

<h2>🎓 My Enrolled Subjects</h2>

<ul>
<?php if (mysqli_num_rows($query) > 0): ?>
    <?php while($row = mysqli_fetch_assoc($query)): ?>
        <li>
            <strong><?= $row['subject_name'] ?> (<?= $row['grade'] ?>)</strong><br>
            <a href="dashboard.php?subject_id=<?= $row['id'] ?>">Go to Course</a>
        </li>
    <?php endwhile; ?>
<?php else: ?>
    <p>You have not enrolled in any subjects yet.</p>
<?php endif; ?>
</ul>

</body>
</html>
