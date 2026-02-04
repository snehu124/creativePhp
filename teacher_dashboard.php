<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); // ✅ Set timezone
include 'db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
$now = date("Y-m-d H:i:s");
mysqli_query($conn, "UPDATE teachers SET last_activity = '$now' WHERE id = '$teacher_id'");
?>


<!DOCTYPE html>
<html>
<head>
  <title>Teacher Dashboard</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <style>
    body {
      display: flex;
      min-height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .sidebar {
      width: 220px;
      background: #2c3e50;
      color: #fff;
      padding: 20px 10px;
    }
    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      display: block;
      color: #fff;
      padding: 10px 15px;
      margin: 8px 0;
      text-decoration: none;
      border-radius: 4px;
    }
    .sidebar a:hover {
      background: #34495e;
    }
    .main-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      background: #f7f7f7;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h4>Teacher Panel</h4>
  <a href="#" class="menu-link" data-page="calendar.php">📅 Calendar</a>
  <a href="#" class="menu-link" data-page="my_students.php">👨‍🎓 My Students</a>
  <a href="#" class="menu-link" data-page="attendance.php">📋 Attendance</a>
  <a href="#" class="menu-link" data-page="assign_chapter.php">📚 Assign Chapters</a>
  <a href="#" class="menu-link" data-page="suggest_course_changes.php">📝 Suggest Course Change</a>
  <a href="#" class="menu-link" data-page="send_email_updates.php">📧 Send Email Updates</a>

  <!-- ✅ Fixed paths for question pages -->
  <!--<a href="#" class="menu-link" data-page="teacher_question_pages/add_question.php">➕ Add Question</a>-->
 <a href="#" class="menu-link" data-page="teacher_question_pages/assign_assessment.php">
   📑 Assign Assessment
</a>
<a href="#" class="menu-link" data-page="teacher_question_pages/manage_assessments.php">
    🗂️ Manage Student Assessments
</a>
  <a href="#" class="menu-link" data-page="teacher_question_pages/manage_questions.php">❓ Manage Questions</a>

  <a href="teacher_logout.php">🚪 Logout</a>
</div>

<div class="main-content" id="content-area">
  <h5>Welcome to Teacher Dashboard</h5>
  <p>Please select a menu option from the left.</p>
</div>

<!-- jQuery, Bootstrap JS, FullCalendar JS (only ONCE) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<script>
  $(document).ready(function () {
    $('.menu-link').on('click', function (e) {
      e.preventDefault();
      const page = $(this).data('page');

      if (page) {
        $('#content-area').html('<p>Loading...</p>');

        // ✅ Always load from correct root folder
        const fullPath = '/' + page.replace(/^\/+/, '');

        $.get(fullPath, function (data) {
          $('#content-area').html(data);

          // ✅ Re-init calendar if needed
          if (page.includes('calendar.php') && typeof initCalendar === 'function') {
            setTimeout(initCalendar, 100);
          }
        }).fail(function () {
          $('#content-area').html('<p class="text-danger">❌ Error loading page: ' + fullPath + '</p>');
        });
      }
    });
  });
</script>

</body>
</html>
