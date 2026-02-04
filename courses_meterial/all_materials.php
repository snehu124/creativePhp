<?php
include 'db_config.php';

$sql = "SELECT m.*, c.title AS course_title, c.created_by 
        FROM course_materials m 
        JOIN courses c ON m.course_id = c.id 
        ORDER BY m.uploaded_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Study Materials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            padding-top: 40px;
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 150px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #6c757d;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 0.9rem;
            color: #555;
        }

        .actions a {
            margin-right: 12px;
            font-size: 1.2rem;
            text-decoration: none;
        }

        .actions a:hover {
            color: #0d6efd;
        }

        .title-bar {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title-bar h2 {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="title-bar">
        <h2>All Study Materials</h2>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $file_name = basename($row['file_path']);
                $course = htmlspecialchars($row['course_title']);
                $teacher = htmlspecialchars($row['created_by']);
                $id = $row['id'];
        ?>
        <div class="col">
            <div class="card">
                <div class="card-img-top">📄</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $course ?></h5>
                    <p class="card-text"><strong>Uploaded by:</strong> <?= $teacher ?></p>
                    <p class="card-text text-muted">File: <?= $file_name ?></p>
                    <div class="actions">
                        <a href="<?= $row['file_path'] ?>" target="_blank" title="View">👁️</a>
                        <a href="<?= $row['file_path'] ?>" download title="Download">⬇️</a>
                        <a href="edit_material.php?id=<?= $id ?>" title="Edit">✏️</a>
                        <a href="delete_material.php?id=<?= $id ?>" onclick="return confirm('Delete this file?');" title="Delete">🗑️</a>
                    </div>
                </div>
            </div>
        </div>
        <?php }} else {
            echo "<p>No materials found.</p>";
        } ?>
    </div>
</div>

</body>
</html>
