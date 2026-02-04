<?php
// student_sidebar.php
$currentpage = basename($_SERVER['PHP_SELF']);
if (!isset($student)) {
    include "../db_config.php";

    if (!isset($_SESSION['student_id'])) {
        header("Location: student_login.php");
        exit();
    }

    $student_id = $_SESSION['student_id'];
    $sql = "SELECT * FROM students WHERE id = $student_id";
    $res = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($res);
    
    
    //Fetch student's profile picture
     $sql1 = "select image_path from student_images where student_id = $student_id";
     $res1 = mysqli_query($conn, $sql1);
     $student1 = mysqli_fetch_assoc($res1);
}
?>

<!Doctype html>
<html lang = "en">
<head>
    <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
          <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
          
        <title>Student Sidebar</title>
</head>    

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ==================== BODY & MAIN BACKGROUND ==================== */
body {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    color: #1e293b;
    overflow-x: hidden;
}

.main {
    display: flex;
    min-height: 100vh;
}

/* ==================== PROFESSIONAL SIDEBAR (Deep Blue) ==================== */
.sidebar {
    width: 280px !important;
    background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 60%, #1d4ed8 100%);
    color: white;
    padding: 35px 20px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    z-index: 1000;
    box-shadow: 12px 0 40px rgba(30, 58, 138, 0.4);
    overflow-y: auto;
    transition: transform 0.4s ease;
}

.sidebar h4 {
    text-align: center;
    font-weight: 700;
    font-size: 26px;
    margin-bottom: 40px;
    letter-spacing: 1px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.sidebar .profile-img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 6px solid rgba(255,255,255,0.25);
    display: block;
    margin: 0 auto 18px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.5);
    transition: all 0.4s;
}

.sidebar .profile-img:hover {
    transform: scale(1.12) rotate(4deg);
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 16px;
    color: #e0e7ff;
    padding: 16px 22px;
    margin: 10px 15px;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.sidebar a::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: 0.7s;
}

.sidebar a:hover::before {
    left: 100%;
}

.sidebar a:hover,
.sidebar a.active {
    background: #3b82f6;
    color: white;
    transform: translateX(12px);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.6);
}

.sidebar a.active {
    background: #2563eb;
    border-left: 6px solid #60a5fa;
    font-weight: 600;
}

.sidebar .btn-danger {
    margin: 60px 15px 10px;
    border-radius: 16px;
    padding: 12px;
    font-weight: 600;
}

/* ==================== CLEAN & PROFESSIONAL CONTENT AREA ==================== */
.content {
    flex: 1;
    margin-left: 278px !important;
    padding: 50px 60px;
    background: #ffffff;
    min-height: 100vh;
    transition: all 0.4s ease;
    background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
}

/* ==================== MODERN CARDS ==================== */
.card,
.dashboard-card {
    background: white;
    border-radius: 24px;
    padding: 32px;
    margin-bottom: 35px;
    box-shadow: 0 15px 45px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 7px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
    border-radius: 24px 24px 0 0;
}

.card:hover {
    transform: translateY(-15px);
    box-shadow: 0 30px 70px rgba(0,0,0,0.15);
}

/* Headings */
h3 {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(90deg, #1e40af, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 35px;
}

h5 {
    font-size: 1.5rem;
    color: #1e40af;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
}

/* Profile Card - Premium */
#profile .dashboard-card {
    background: linear-gradient(135deg, #6c7fbf 0%, #3b82f6 100%);
    color: white;
    text-align: center;
}

#profile .profile-img {
    width: 150px;
    height: 150px;
    border: 10px solid white;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

/* Study Materials Grid */
#materials .row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(370px, 1fr));
    gap: 30px;
    margin-top: 25px;
}

#materials iframe {
    width: 100%;
    height: 340px;
    border: none;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

/* Progress Bar */
.progress {
    height: 44px;
    border-radius: 22px;
    background: #e0e7ff;
    overflow: hidden;
    box-shadow: inset 0 5px 15px rgba(0,0,0,0.1);
}

.progress-bar {
    background: linear-gradient(90deg, #10b981, #34d399);
    font-weight: bold;
    font-size: 17px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 70%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Footer */
footer {
    text-align: center;
    padding: 50px;
    background: white;
    border-radius: 28px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    color: #64748b;
    font-size: 16px;
    margin-top: 70px;
    border-top: 5px solid #3b82f6;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar.show {
        transform: translateX(0);
    }
    .content {
        margin-left: 0 !important;
        padding: 30px 20px;
    }
}

@media (max-width: 768px) {
    .content { padding: 25px 15px; }
    #materials .row { grid-template-columns: 1fr; }
    iframe { height: 300px !important; }
    h3 { font-size: 2rem; }
}
</style>

<!-- Sidebar Styles (copy this in your main page head too if needed) -->


<body>
<!-- Sidebar HTML -->
<div class="col-md-3 col-lg-2 sidebar">
    <div class="text-center mb-4">
        <h4>📘 Student Panel</h4>
    </div>
    <div class="text-center mb-3">
        <img src="<?= htmlspecialchars($student1['image_path'] ?? 'default-profile.png') ?>" alt="Profile" class="profile-img">
        <p class="fw-semibold mt-2"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
    </div>
    <nav class = "nav flex-column">
    <a class = "nav-link <?=($currentpage == 'student_dashboard.php') ? 'active': ''?>" href="student_dashboard.php" class="active"><i class="bi bi-person"></i> My Profile</a>
    <a class = "nav-link <?=($currentpage == 'enrolled_subjects.php') ? 'active': ''?>" href="enrolled_subjects.php"><i class="bi bi-list-check"></i> Enrolled Subjects</a>
    <!--<a class = "nav-link <?=($currentpage == 'all_materials.php') ? 'active': ''?>" href="all_materials.php"><i class="bi bi-folder2-open"></i> Study Materials</a>-->
    <a class="nav-link <?= ($currentpage == 'student_assessments.php') ? 'active' : '' ?>" href="student_assessments.php"><i class="bi bi-file-earmark-check"></i> My Assessments</a>
    
    <a class = "nav-link" href="#progress"><i class="bi bi-bar-chart"></i> Progress Tracker</a>
    <!--<a class = "nav-link" href="#notifications"><i class="bi bi-bell"></i> Announcements</a>-->
    <a class = "nav-link <?=($currentpage == 'purchase_history.php') ? 'active': ''?>" href="purchase_history.php"><i class="bi bi-receipt"></i> Purchase History</a>
    <a class = "nav-link" href="#settings"><i class="bi bi-gear"></i> Settings</a>
    <a class = "nav-link" href="student_logout.php" ><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>
</div>
</body>
</html>
