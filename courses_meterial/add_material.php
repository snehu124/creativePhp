<?php
session_start();
include "db_config.php";

if (!isset($_GET['course_id'])) {
    echo "Course ID not provided.";
    exit;
}

$course_id = intval($_GET['course_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_FILES['material_file']['name'])) {
        $upload_dir = "uploads/course_$course_id"; // Upload folder by course
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['material_file']['name']);
        $target_path = $upload_dir . '/' . $file_name;

        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $target_path)) {
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            $uploaded_at = date('Y-m-d H:i:s');

            // Insert into database
            $insert_sql = "INSERT INTO course_materials (course_id, file_type, file_path, uploaded_at) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt, "isss", $course_id, $file_type, $target_path, $uploaded_at);
            mysqli_stmt_execute($stmt);

            header("Location: view_materials.php?course_id=$course_id");
            exit();
        } else {
            $error = "File upload failed.";
        }
    } else {
        $error = "Please select a file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Material</title>
</head>
<body>
    <h2>Add Study Material for Course ID: <?= $course_id ?></h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Select PDF File:</label><br>
        <input type="file" name="material_file" accept=".pdf" required><br><br>

        <button type="submit">Upload Material</button>
    </form>

    <p><a href="view_materials.php?course_id=<?= $course_id ?>">← Back to materials</a></p>
</body>
</html>
