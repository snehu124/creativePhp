<?php
// sidebar.php
$current_page = basename($_SERVER['PHP_SELF']); // current filename
?>

<div class="sidebar">
  <h4>Teacher Panel</h4>
  
  <a href="/calendar.php" class="menu-link" data-page="calendar.php">Calendar</a>
  <a href="/my_students.php" class="menu-link" data-page="my_students.php">My Students</a>
  <a href="/attendance.php" class="menu-link" data-page="attendance.php">Attendance</a>
  <a href="/assign_chapter.php" class="menu-link" data-page="assign_chapter.php">Assign Chapters</a>
  <a href="/suggest_course_changes.php" class="menu-link" data-page="suggest_course_changes.php">Suggest Course Change</a>
  <a href="/send_email_updates.php" class="menu-link" data-page="send_email_updates.php">Send Email Updates</a>
 <!--<a href="#" class="menu-link" data-page="teacher_question_pages/add_question.php">➕ Add Question</a>-->
 <a href="/teacher_question_pages/assign_assessment.php" class="<?= $current_page === 'assign_assessment.php' ? 'active' : '' ?>">
    📑 Assign Assessment
</a>

<a href="/teacher_question_pages/manage_assessments.php" class="<?= $current_page === 'manage_assessments.php' ? 'active' : '' ?>">
  🗂️ Manage Student Assessment </a>
  <!-- Question Pages -->
  <a href="/teacher_question_pages/manage_questions.php" class="<?= $current_page === 'manage_questions.php' ? 'active' : '' ?>">❓ Manage Questions</a>

  <a href="/teacher_logout.php">🚪 Logout</a>
</div>

<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
  }
  .sidebar {
    width: 220px;
    background: #2c3e50;
    color: #fff;
    padding: 20px 10px;
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
  }
  .sidebar h4 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 1.2rem;
  }
  .sidebar a {
    display: block;
    color: #fff;
    padding: 10px 15px;
    margin: 8px 0;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.95rem;
    transition: background 0.2s;
  }
  .sidebar a:hover,
  .sidebar a.active {
    background: #34495e;
  }
  .sidebar a.active {
    background: #1a252f;
    font-weight: bold;
  }
</style>
