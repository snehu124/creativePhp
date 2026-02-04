<?php
session_start();
include "db_config.php";

if (!isset($_GET['id'])) {
    echo "Material ID not provided.";
    exit;
}

$id = intval($_GET['id']);

// Fetch material details
$sql = "SELECT * FROM course_materials WHERE id = $id";
$result = mysqli_query($conn, $sql);
$material = mysqli_fetch_assoc($result);

if (!$material) {
    echo "Material not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_file_path = $material['file_path'];
    $file_type = $material['file_type'];

    // If new file uploaded, replace it
    if (!empty($_FILES['new_file']['name'])) {
        $upload_dir = dirname($material['file_path']); // keep same folder
        $file_name = basename($_FILES['new_file']['name']);
        $target_path = $upload_dir . '/' . $file_name;

        if (move_uploaded_file($_FILES['new_file']['tmp_name'], $target_path)) {
            // Delete old file
            if (file_exists($material['file_path'])) {
                unlink($material['file_path']);
            }
            $new_file_path = $target_path;
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        } else {
            echo "File upload failed.";
            exit;
        }
    }

    // Update database
    $update_sql = "UPDATE course_materials SET file_path = ?, file_type = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "ssi", $new_file_path, $file_type, $id);
    mysqli_stmt_execute($stmt);

    header("Location: view_materials.php?course_id=" . $material['course_id']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Material</title>
</head>
<body>
    <h2>Edit Material</h2>

    <form method="post" enctype="multipart/form-data">
        <p>Current File: <?= basename($material['file_path']) ?></p>

        <label>Replace File (optional):</label><br>
        <input type="file" name="new_file" accept=".pdf"><br><br>

        <button type="submit">Update</button>
    </form>

    <p><a href="view_materials.php?course_id=<?= $material['course_id'] ?>">← Back to materials</a></p>
</body>
</html>
