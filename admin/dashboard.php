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

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6fb;
      margin: 0;
    }

    /* Layout */

    #wrapper {
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */

    #sidebar {
      width: 260px;
      position: fixed;
      left: 0;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      background: linear-gradient(180deg, #0f4c81, #1e88e5);
      padding: 25px 15px;
      color: white;
      transition: .3s;
    }

    #sidebar::-webkit-scrollbar {
      width: 5px;
    }

    #sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .3);
      border-radius: 10px;
    }

    .sidebar-title {
      text-align: center;
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 30px;
    }

    /* Menu */

    #sidebar .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      padding: 12px 15px;
      border-radius: 12px;
      margin-bottom: 8px;
      transition: .3s;
      font-weight: 500;
      display: flex;
      align-items: center;
    }

    #sidebar .nav-link i {
      margin-right: 10px;
    }

    #sidebar .nav-link:hover {
      background: rgba(255, 255, 255, .15);
      color: white !important;
    }

    #sidebar .nav-link.active {
      background: rgba(255, 255, 255, .25);
      color: white !important;
      box-shadow: 0 6px 20px rgba(0, 0, 0, .1);
    }

    /* Logout */

    .logout-btn {
      background: linear-gradient(45deg, #ff416c, #ff4b2b);
      padding: 12px;
      border-radius: 10px;
      text-align: center;
      color: white;
      display: block;
      margin-top: 20px;
      text-decoration: none;
    }

    .logout-btn:hover {
      color: white;
      transform: scale(1.05);
    }

    /* Page */

    #page-content {
      margin-left: 260px;
      flex: 1;
      padding: 20px;
      overflow-x: auto;
    }

    /* Header */

    .top-header {
      background: white;
      padding: 15px 20px;
      border-radius: 15px;
      margin-bottom: 20px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Cards */

    .dashboard-card {
      padding: 20px;
      border-radius: 15px;
      color: white;
      box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
      transition: .3s;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
    }

    .card-blue {
      background: linear-gradient(45deg, #36d1dc, #5b86e5);
    }

    .card-green {
      background: linear-gradient(45deg, #11998e, #38ef7d);
    }

    .card-orange {
      background: linear-gradient(45deg, #f7971e, #ffd200);
    }

    .card-purple {
      background: linear-gradient(45deg, #834d9b, #d04ed6);
    }

    /* Box */

    .white-box {
      background: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .05);
    }

    /* Mobile */

    .mobile-toggle {
      display: none;
      font-size: 24px;
      cursor: pointer;
    }

    @media(max-width:991px) {

      #sidebar {
        left: -260px;
        z-index: 1000;
      }

      #sidebar.active {
        left: 0;
      }

      #page-content {
        margin-left: 0;
      }

      .mobile-toggle {
        display: block;
      }

    }

    .loading-spinner {
      width: 2rem;
      height: 2rem;
      border: 3px solid #ddd;
      border-top: 3px solid #007bff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      100% {
        transform: rotate(360deg);
      }
    }
  </style>

</head>

<body>

  <div id="wrapper">

    <!-- Sidebar -->

    <div id="sidebar">

      <div class="sidebar-title">
        Admin Panel
      </div>

      <ul class="nav flex-column">

        <li>
          <a class="nav-link active menu-link" data-page="dashboard_home.php">
            <i class="bi bi-speedometer2"></i>
            Dashboard
          </a>
        </li>

        <li>
          <a class="nav-link menu-link" data-page="manage_teachers.php">
            <i class="bi bi-person-badge"></i>
            Manage Teachers
          </a>
        </li>

        <li>
          <a class="nav-link menu-link" data-page="manage_branches.php">
            <i class="bi bi-diagram-3"></i>
            Manage Branches
          </a>
        </li>

        <li>
          <a class="nav-link menu-link" data-page="manage_courses.php">
            <i class="bi bi-book"></i>
            Manage Courses
          </a>
        </li>

        <li>
          <a class="nav-link menu-link" data-page="manage_students.php">
            <i class="bi bi-people"></i>
            Students
          </a>
        </li>
<li>
  <a href="#" class="nav-link menu-link" data-page="invoice_system/dashboard/invoice_dashboard.php">
    <i class="bi bi-receipt"></i>
    Invoice Dashboard
  </a>
</li>

<li>
  <a href="#" class="nav-link menu-link" data-page="invoice_system/enroll/admin_enroll_student.php">
    <i class="bi bi-person-plus"></i>
    Enroll Student
  </a>
</li>

<li>
  <a href="#" class="nav-link menu-link" data-page="invoice_system/enroll/manage_enrollment.php">
    <i class="bi bi-pencil-square"></i>
    Manage Enrollment
  </a>
</li>

<!-- Optional -->
<!--
<li>
  <a href="#" class="nav-link menu-link" data-page="invoice_system/invoice/invoice_list.php">
    <i class="bi bi-file-earmark-text"></i>
    Invoices
  </a>
</li>
-->

<li>
  <a href="#" class="nav-link menu-link" data-page="invoice_system/payments/payment_list.php">
    <i class="bi bi-cash-coin"></i>
    Payments
  </a>
</li>
        <li>
          <a class="nav-link menu-link" data-page="admin_attendance.php">
            <i class="bi bi-calendar-check"></i>
            Attendance
          </a>
        </li>

        <li>
          <a href="logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            Logout
          </a>
        </li>

      </ul>

    </div>

    <!-- Content -->

    <div id="page-content">

      <div class="top-header">

        <div class="mobile-toggle">
          <i class="bi bi-list"></i>
        </div>

        <h4>Dashboard Overview</h4>

        <button class="btn btn-primary" id="refresh-btn">
          Refresh
        </button>

      </div>

      <div class="text-center py-5">
        <div class="loading-spinner"></div>
        <div>Loading...</div>
      </div>

    </div>

  </div>

  <script>
    $(document).ready(function() {

      /* Load from URL */

      let urlParams = new URLSearchParams(window.location.search);
      let currentPage = urlParams.get('page') || 'dashboard_home.php';

      loadPage(currentPage);

      /* Set active menu */

      $('.menu-link').each(function() {

        if ($(this).data('page') === currentPage) {

          $('.menu-link').removeClass('active');
          $(this).addClass('active');

        }

      });


      /* Menu Click */

      $(document).on('click', '.menu-link', function(e) {

        e.preventDefault();

        let page = $(this).data('page');

        history.pushState(null, '', '?page=' + page);

        loadPage(page);

        /* sidebar active */

        $('.menu-link').removeClass('active');

        $('.menu-link[data-page="' + page + '"]').addClass('active');

      });


      /* Load Page */

      function loadPage(page) {

        $('#page-content').html('<div class="text-center py-5"><div class="loading-spinner"></div></div>');

        $.get(page, function(data) {

          $('#page-content').html(data);

        });

      }


      /* Refresh button */

      $(document).on('click', '#refresh-btn', function() {

        let page = $('.menu-link.active').data('page');

        loadPage(page);

      });


      /* Browser Back Button */

      window.onpopstate = function() {

        let urlParams = new URLSearchParams(window.location.search);

        let page = urlParams.get('page') || 'dashboard_home.php';

        loadPage(page);

        $('.menu-link').removeClass('active');

        $('.menu-link').each(function() {

          if ($(this).data('page') === page) {

            $(this).addClass('active');

          }

        });

      };


      /* Mobile toggle */

      $('.mobile-toggle').click(function() {

        $('#sidebar').toggleClass('active');

      });

    });
  </script>

</body>

</html>