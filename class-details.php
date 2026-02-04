<?php
include 'db_config.php';

// ID URL se lo
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Course fetch karo
$sql = "SELECT * FROM courses WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

// Check
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Course not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($row['title']); ?> - Course Details</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f9fb;
            font-family: Arial, sans-serif;
            padding: 50px 0;
        }
        .course-card {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .course-card img {
            width: 100%;
            height: auto;
        }
        .course-content {
            padding: 25px;
        }
        .course-content h1 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        .course-content p {
            font-size: 16px;
            color: #555;
        }
        .price {
            font-size: 22px;
            color: #007bff;
            font-weight: bold;
            margin: 20px 0;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-custom {
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }
        .btn-enroll {
            background: #28a745;
        }
        .btn-back {
            background: #007bff;
        }
        .btn-custom:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="course-card">
    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Course Image">

    <div class="course-content">
        <h1><?php echo htmlspecialchars($row['title']); ?></h1>

        <p>
            <strong>Description:</strong><br>
            <?php echo nl2br(htmlspecialchars($row['description'])); ?>
        </p>

        <div class="price">
            $<?php echo number_format($row['price'], 2); ?>
        </div>

        <div class="btn-group">
            <!-- ✅ Enrollment Button -->
            <a href="enroll.php?course_id=<?php echo $row['id']; ?>" class="btn-custom btn-enroll">
                Enroll Now →
            </a>

            <!-- Back Button -->
            <a href="class.html" class="btn-custom btn-back">
                ← Back to All Classes
            </a>
        </div>
    </div>
</div>

</body>
</html>
