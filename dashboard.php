<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Super Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      color: #333;
    }

    #wrapper {
      display: flex;
      min-height: 100vh;
    }

    #sidebar {
      width: 260px;
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
      padding: 2rem 1rem;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
    }

    #sidebar h4 {
      font-weight: 700;
      margin-bottom: 2rem;
      text-align: center;
      color: #007bff;
      font-size: 1.5rem;
    }

    .nav-link {
      color: #333;
      padding: 0.7rem 1rem;
      border-radius: 8px;
      display: flex;
      align-items: center;
      transition: background 0.3s ease;
      font-weight: 500;
    }

    .nav-link i {
      margin-right: 10px;
      font-size: 1.1rem;
    }

    .nav-link:hover,
    .nav-link.active {
      background-color: #e9ecef;
      color: #007bff;
    }

    .logout-box {
      display: block;
      background-color: #dc3545;
      text-align: center;
      padding: 0.6rem 1rem;
      margin-top: 2rem;
      border-radius: 8px;
      font-weight: 600;
      color: #fff;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .logout-box:hover {
      background-color: #c82333;
      text-decoration: none;
    }

    #page-content {
      flex-grow: 1;
      background-color: #ffffff;
      margin: 1.5rem;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .loading-spinner {
      display: inline-block;
      width: 2rem;
      height: 2rem;
      border: 3px solid rgba(0, 0, 0, 0.2);
      border-radius: 50%;
      border-top-color: #007bff;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .text-center span.loading-spinner {
      border-top-color: #007bff;
    }
  </style>
</head>
<body>
  <div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar">
      <h4>Admin Panel</h4>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a class="nav-link active menu-link" data-page="dashboard_home.php" href="#">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="manage_teachers.php" href="#">
            <i class="bi bi-person-badge-fill"></i> Manage Teachers
          </a>
        </li>
       <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="all_materials.php" href="#">
            <i class="bi bi-person-badge-fill"></i> All Courses Meterial
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="manage_courses.php" href="#">
            <i class="bi bi-journals"></i> Manage Courses
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="manage_students.php" href="#">
            <i class="bi bi-people-fill"></i> Students
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="view_suggestions.php" href="#">
            <i class="bi bi-chat-dots"></i> View Suggestions
          </a>
        </li>
        
        <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="admin_attendance.php" href="#">
            <i class="bi bi-gear-fill"></i> attendance
          </a>
        </li>
        
        <li class="nav-item mb-2">
          <a class="nav-link menu-link" data-page="settings.php" href="#">
            <i class="bi bi-gear-fill"></i> Settings
          </a>
        </li>
        <li class="nav-item">
          <a class="logout-box" href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </li>
      </ul>
    </div>

    <!-- Page Content -->
    <div id="page-content">
      <div class="text-center py-5">
        <span class="loading-spinner"></span>
        <div class="mt-3">Loading...</div>
      </div>
    </div>
  </div>
</body>
</html>

<script>
  $(document).ready(function() {
    // Load initial/default page
    loadPage('dashboard_home.php');

    // Sidebar menu click event
    $('.menu-link').on('click', function(e) {
      e.preventDefault();
      $('.menu-link').removeClass('active');
      $(this).addClass('active');
      const page = $(this).data('page');
      if (page) loadPage(page);
    });

    // Load page content via AJAX
    function loadPage(page) {
      $('#page-content').html('<div class="text-center py-5"><span class="loading-spinner"></span> Loading...</div>');
      $.get(page, function(data) {
        $('#page-content').html(data);
      }).fail(function() {
        $('#page-content').html('<div class="text-danger text-center py-5">Failed to load "' + page + '".</div>');
      });
    }

    // Refresh button inside page (optional)
    $(document).on('click', '#refresh-btn', function() {
      const activePage = $('.menu-link.active').data('page');
      if (activePage) loadPage(activePage);
    });

    // Auto-refresh every 2 mins (optional)
    setInterval(() => {
      const activePage = $('.menu-link.active').data('page');
      if (activePage) loadPage(activePage);
    }, 120000);
  });
</script>
</body>
</html>
