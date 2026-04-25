<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
  }

  /* Sidebar */
  .sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #f4f6fb;
    padding: 20px 15px;
    border-right: 1px solid #ddd;
  }

  /* Title */
  .sidebar h4 {
    text-align: center;
    color: #0d6efd;
    font-weight: 700;
    margin-bottom: 30px;
  }

  /* Menu links */
  .menu a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    margin-bottom: 10px;
    text-decoration: none;
    color: #333;
    border-radius: 12px;
    font-size: 15px;
    transition: 0.3s;
  }

  .menu a i {
    font-size: 18px;
  }

  /* Hover */
  .menu a:hover {
    background: #e9ecef;
  }

  /* Active */
  .menu a.active {
    background: #dbe4f3;
    color: #0d6efd;
    border: 2px solid #a9c1e8;
    font-weight: 600;
  }

  /* Logout */
  .logout-btn {
    margin-top: 20px;
    background: #dc3545;
    color: #fff !important;
    justify-content: center;
    text-align: center;
    border-radius: 10px;
    padding: 12px;
  }

  /* Main content */
  .main-content {
    margin-left: 270px;
    padding: 30px;
  }

  /* Responsive (optional basic) */
  @media (max-width: 768px) {
    .sidebar {
      width: 200px;
    }

    .main-content {
      margin-left: 210px;
    }
  }
</style>

<!-- Sidebar -->
<div class="sidebar">

  <h4>Admin Panel</h4>

  <div class="menu">

    <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="manage_teachers.php" class="<?= $currentPage == 'manage_teachers.php' ? 'active' : '' ?>">
      <i class="bi bi-person-badge"></i> Manage Teachers
    </a>

    <a href="manage_branches.php" class="<?= $currentPage == 'manage_branches.php' ? 'active' : '' ?>">
      <i class="bi bi-building"></i> Manage Branches
    </a>

    <a href="manage_courses.php" class="<?= $currentPage == 'manage_courses.php' ? 'active' : '' ?>">
      <i class="bi bi-journal-bookmark"></i> Manage Courses
    </a>

    <a href="manage_students.php" class="<?= $currentPage == 'manage_students.php' ? 'active' : '' ?>">
      <i class="bi bi-people"></i>Manage Students
    </a>

    <a href="admin_attendance.php" class="<?= $currentPage == 'admin_attendance.php' ? 'active' : '' ?>">
      <i class="bi bi-gear"></i> Attendance
    </a>

    <a href="logout.php" class="logout-btn">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>

  </div>

</div>