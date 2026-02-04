<?php
// Debug mode ON (testing ke liye)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "db_config.php";

// Agar login nahi hua to stop karo
if (!isset($_SESSION['student_email'])) {
    echo "<h3>Please login to view this course.</h3>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<h3>Invalid course ID.</h3>";
    exit;
}

$course_id = intval($_GET['id']);
$email = $_SESSION['student_email'];

// Course details fetch karo students + early_learner_courses se
$sql = "
    SELECT s.course_id, s.course_title, s.grade, s.created_at, c.course_image
    FROM students s
    LEFT JOIN early_learner_courses c 
        ON s.course_id = c.id
    WHERE s.course_id = '$course_id' AND s.email = '$email'
    LIMIT 1
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$course = mysqli_fetch_assoc($result);

if (!$course) {
    echo "<h3>No course found for this ID.</h3>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($course['course_title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f7f9fc;
        }
        .container {
            padding: 30px;
        }
        .course-header {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .course-header img {
            width: 200px;
            height: 120px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 6px;
        }
        .course-info h2 {
            margin: 0;
            color: #333;
        }
        .course-info p {
            margin: 6px 0;
            color: #555;
        }
        
        
        
          body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9f9f9;
    }

    .container {
      display: flex;
    }

    /* Sidebar */
    .sidebar {
      width: 280px;
      height: 100vh;
      overflow-y: auto;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 15px;
      position: sticky;
      top: 0;
    }

    .sidebar h3 {
      margin: 10px 0;
      font-size: 18px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 8px 0;
    }

    .sidebar ul li a {
      text-decoration: none;
      color: #333;
      font-size: 15px;
    }

    .sidebar ul li a.active {
      font-weight: bold;
      color: #0073e6;
    }

    /* Main content */
    .content {
      flex: 1;
      padding: 20px;
    }

    .content h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .card-container {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      width: 300px;
      padding: 15px;
      text-align: center;
    }

    .card img {
      width: 100%;
      border-radius: 10px;
      height: 180px;
      object-fit: cover;
    }

    .card h2 {
      margin: 10px 0;
      font-size: 20px;
    }

    .card p {
      font-size: 14px;
      color: #555;
    }
  </style>
</head>
    </style>
</head>
<body>
    <div class="container">
        <div class="course-header">
            <img src="<?= htmlspecialchars(!empty($course['course_image']) ? $course['course_image'] : 'images/default-course.jpg'); ?>" alt="Course Image">
            <div class="course-info">
                <h2><?= htmlspecialchars($course['course_title']); ?></h2>
                <p><strong>Grade:</strong> <?= htmlspecialchars($course['grade']); ?></p>
                <p><strong>Enrolled on:</strong> <?= date('d M Y', strtotime($course['created_at'])); ?></p>
            </div>
        </div>
    </div>
    
    
    <div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <h3>Section 1 - OUR ECOSYSTEM</h3>
    <ul>
      <li><a href="#">1.1 What is an Ecosystem</a></li>
      <li><a href="#">What is Ecosystem</a></li>
      <li><a href="#">Test Your Knowledge</a></li>
      <li><a href="#">Essentials for Biotic components</a></li>
      <li><a href="#">Test Your Knowledge</a></li>
      <li><a href="#" class="active">1.3 Terrestrial Ecosystem</a></li>
      <li><a href="#">Terrestrial Ecosystem</a></li>
      <li><a href="#">1.4 Aquatic Ecosystem</a></li>
      <li><a href="#">Test Your Knowledge</a></li>
      <li><a href="#">1.5 Biodiversity</a></li>
      <li><a href="#">Fill in The blanks</a></li>
      <li><a href="#">Test Your Knowledge</a></li>
      <li><a href="#">True/false</a></li>
      <li><a href="#">Vocabulary</a></li>
      <li><a href="#">1.6 Limiting factors for Ecosystem</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="content">
    <h1>Major Types of Terrestrial Ecosystems</h1>
    <div class="card-container">
      
      <!-- Card 1 -->
      <div class="card">
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/36/Savannah_-_Serengeti.jpg" alt="Forest">
        <h2>Forests</h2>
        <p>Dense areas dominated by trees, categorized into tropical, temperate, and boreal forests.</p>
      </div>
      
      <!-- Card 2 -->
      <div class="card">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/Grassland_in_Taiwan.jpg" alt="Grasslands">
        <h2>Grasslands</h2>
        <p>Open areas dominated by grasses, including prairies, savannas, and steppes.</p>
      </div>

    </div>
  </div>
</div>
</body>
</html>
