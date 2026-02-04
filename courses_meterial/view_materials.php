<?php
session_start();
include "db_config.php"; // <-- Isme DB connection hona chahiye

if (!isset($_GET['course_id'])) {
    echo "Course ID not provided.";
    exit;
}

$course_id = intval($_GET['course_id']);

// Fetch course title
$course_sql = "SELECT * FROM courses WHERE id = $course_id";
$course_result = mysqli_query($conn, $course_sql);
$course = mysqli_fetch_assoc($course_result);

if (!$course) {
    echo "Course not found.";
    exit;
}

// Fetch PDFs for this course
$sql = "SELECT * FROM course_materials WHERE course_id = $course_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Study Materials - <?= htmlspecialchars($course['title']) ?></title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            font-size: 18px;
        }
        .actions a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Study Materials - <?= htmlspecialchars($course['title']) ?></h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>File Type</th>
                <th>File Path</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): 
                $sn = 1;
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $sn++ ?></td>
                        <td><?= htmlspecialchars($row['file_type']) ?></td>
                        <td><?= basename($row['file_path']) ?></td>
                        <td><?= $row['uploaded_at'] ?></td>
                        <td class="actions">
                            <a href="<?= $row['file_path'] ?>" target="_blank" title="View">👁️</a>
                            <a href="<?= $row['file_path'] ?>" download title="Download">⬇️</a>
                            <a href="edit_material.php?id=<?= $row['id'] ?>" title="Edit">✏️</a>
                            <a href="delete_material.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this file?');" title="Delete">🗑️</a>
                        </td>
                    </tr>
            <?php endwhile;
            else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No study materials found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
