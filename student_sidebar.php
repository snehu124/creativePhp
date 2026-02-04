<?php
// student_sidebar.php

if (!isset($student)) {
    session_start();
    include "db_config.php";

    if (!isset($_SESSION['student_id'])) {
        header("Location: student_login.php");
        exit();
    }

    $student_id = $_SESSION['student_id'];
    $sql = "SELECT * FROM students WHERE id = $student_id";
    $res = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($res);
}
?>

<!-- Sidebar Styles (copy this in your main page head too if needed) -->
<style>
    .sidebar {
        height: 100vh;
        background-color: #343a40;
        padding-top: 20px;
        color: #fff;
    }
    .sidebar a {
        color: #ddd;
        display: block;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 5px;
        text-decoration: none;
    }
    .sidebar a:hover, .sidebar a.active {
        background-color: #495057;
        color: #fff;
    }
    .profile-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 10px;
    }
</style>

<!-- Sidebar HTML -->
<div class="col-md-3 col-lg-2 sidebar">
    <div class="text-center mb-4">
        <h4>📘 Student Panel</h4>
    </div>
    <div class="text-center mb-3">
        <img src="<?= htmlspecialchars($student['profile_picture'] ?? 'default-profile.png') ?>" alt="Profile" class="profile-img">
        <p class="fw-semibold mt-2"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
    </div>
    <a href="#profile" class="active"><i class="bi bi-person"></i> My Profile</a>
    <a href="#subjects"><i class="bi bi-list-check"></i> Enrolled Subjects</a>
    <a href="#materials"><i class="bi bi-folder2-open"></i> Study Materials</a>
    <a href="#progress"><i class="bi bi-bar-chart"></i> Progress Tracker</a>
    <a href="#notifications"><i class="bi bi-bell"></i> Announcements</a>
    <a href="math_practice.php"><i class="bi bi-calculator"></i> Math Practice</a>
    <a href="student_logout.php" class="btn btn-sm btn-danger mt-3">Logout</a>
</div>

