<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../db_config.php";
include "student_sidebar.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

//Fetch student's profile picture
$sql1 = "select image_path from student_images where student_id = $student_id";
$res1 = mysqli_query($conn, $sql1);
$student1 = mysqli_fetch_assoc($res1);

// Fetch student info
$sql = "SELECT * FROM students WHERE id = $student_id";
$res = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($res);

// Get course and subject info
$course_ids = [];
$course_sql = "SELECT course_id FROM course_enrollments WHERE student_id = $student_id";
$course_res = mysqli_query($conn, $course_sql);
while ($row = mysqli_fetch_assoc($course_res)) {
    $course_ids[] = $row['course_id'];
}

$subject_ids = [];
$subject_names = [];
$materials_result = false;
$progress_result = false;

if (!empty($course_ids)) {
    $course_ids_string = implode(',', $course_ids);

    // Get subject IDs
    $subject_sql = "SELECT DISTINCT subject_id FROM courses WHERE id IN ($course_ids_string)";
    $subject_res = mysqli_query($conn, $subject_sql);
    while ($row = mysqli_fetch_assoc($subject_res)) {
        $subject_ids[] = $row['subject_id'];
    }

    if (!empty($subject_ids)) {
        $ids_string = implode(',', $subject_ids);

        // Get subject names
        $subject_result = mysqli_query($conn, "SELECT subject_name FROM subjects WHERE id IN ($ids_string)");
        while ($row = mysqli_fetch_assoc($subject_result)) {
            $subject_names[] = $row['subject_name'];
        }

        // Get study materials
        $materials_sql = "
            SELECT cm.*, s.subject_name 
            FROM course_materials cm
            JOIN courses c ON cm.course_id = c.id
            JOIN subjects s ON c.subject_id = s.id
            WHERE cm.course_id IN ($course_ids_string)
        ";
        $materials_result = mysqli_query($conn, $materials_sql);

        // Progress tracker
        $progress_sql = "
            SELECT 
                s.id,
                s.subject_name,
                COUNT(DISTINCT c.id) AS total_chapters,
                COUNT(DISTINCT r.question_id) AS attempted,
                IFNULL(SUM(r.is_correct), 0) AS correct_answers
            FROM subjects s
            JOIN assigned_chapters c ON c.subject_id = s.id
            LEFT JOIN quiz_questions q ON q.chapter_id = c.id
            LEFT JOIN quiz_results r ON r.question_id = q.id AND r.student_id = $student_id
            WHERE s.id IN ($ids_string)
            GROUP BY s.id
        ";
        // $progress_result = mysqli_query($conn, $progress_sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href ="student.css" rel="stylesheet">

    /*<style>*/
    /*    .content {*/
    /*        padding: 20px;*/
    /*    }*/
    /*    .card {*/
    /*        border: 1px solid #dee2e6;*/
    /*        border-radius: 10px;*/
    /*        transition: box-shadow 0.3s ease;*/
    /*        background-color: #fff;*/
    /*    }*/
    /*    .card:hover {*/
    /*        box-shadow: 0 6px 20px rgba(0,0,0,0.05);*/
    /*    }*/
    /*    iframe {*/
    /*        border-radius: 8px;*/
    /*        width: 100%;*/
    /*        height: 240px;*/
    /*        cursor: pointer;*/
    /*    }*/
    /*    footer {*/
    /*        margin-top: 60px;*/
    /*        text-align: center;*/
    /*        color: #888;*/
    /*        font-size: 14px;*/
    /*    }*/
    /*    .profile-img {*/
    /*        width: 100px;*/
    /*        height: 100px;*/
    /*        object-fit: cover;*/
    /*        border-radius: 50%;*/
    /*        margin-bottom: 10px;*/
    /*    }*/
    /*    @media (max-width: 767.98px) {*/
    /*        .sidebar {*/
    /*            height: auto;*/
    /*            border-right: none;*/
    /*        }*/
    /*    }*/
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="main">
        <!-- Sidebar -->
        <!--<div class="col-md-3 col-lg-2 sidebar">-->
        <!--    <div class="text-center mb-4">-->
        <!--        <h4><i class="bi bi-mortarboard-fill"></i> Student Panel</h4>-->
        <!--    </div>-->
        <!--    <div class="text-center mb-3">-->
        <!--        <img src="<?= htmlspecialchars($student['profile_picture'] ?? 'default-profile.png') ?>" alt="Profile" class="profile-img">-->
        <!--        <p class="fw-semibold mt-2"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>-->
        <!--    </div>-->
        <!--    <a href="#profile" class="active"><i class="bi bi-person-circle"></i> My Profile</a>-->
        <!--    <a href="enrolled_subjects.php"><i class="bi bi-journal-text"></i> Enrolled Subjects</a>-->
        <!--    <a href="all_materials.php"><i class="bi bi-folder2-open"></i> Study Materials</a>-->
        <!--    <a href="#progress"><i class="bi bi-graph-up"></i> Progress Tracker</a>-->
        <!--    <a href="#notifications"><i class="bi bi-bell"></i> Announcements</a>-->
        <!--    <a href="purchase_history.php"><i class="bi bi-receipt"></i> Purchase History</a>-->
        <!--    <a href="#settings"><i class="bi bi-gear"></i> Settings</a>-->
        <!--    <a href="math_practice.php"><i class="bi bi-calculator"></i> Math Practice</a>-->
        <!--    <a href="student_logout.php" class="btn btn-sm btn-danger mt-3"><i class="bi bi-box-arrow-right"></i> Logout</a>-->
        <!--</div>-->

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 content">
            <h3 class="mb-4"><i class="bi bi-hand-thumbs-up-fill"></i> Welcome, <?= htmlspecialchars($student['first_name']) ?></h3>

            <!-- Notification Panel -->
            <section id="notifications" class="mb-4">
                <div class="card p-4">
                    <h5><i class="bi bi-bell-fill"></i> Announcements</h5>
                    <ul>
                        <li>Upcoming PTM on 15th July.</li>
                        <li>Assignment deadline extended to 5th July.</li>
                    </ul>
                </div>
            </section>

            <!-- Profile Section -->
            <section id="profile" class="mb-4">
                <div class="dashboard-card p-4">
                    <h5><i class="bi bi-person-fill"></i> My Profile</h5>
                    <div class = "d-flex justify-content-between">
                       <img src="<?= htmlspecialchars($student1['image_path'] ?? 'default-profile.png') ?>" alt="Profile" class="profile-img">
                       <div>
                            <p><strong>Name:</strong> <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                            <p><strong>Grade:</strong> <?= htmlspecialchars($student['grade']) ?></p>
                        </div>    
                    </div>
                </div>
            </section>

            <!-- Enrolled Subjects -->
            <section id="subjects" class="mb-4">
                <div class="card p-4">
                    <h5><i class="bi bi-journal-text"></i> Enrolled Subjects</h5>
                    <?php if (!empty($subject_names)): ?>
                        <ul class="list-group list-group-flush mt-2">
                            <?php foreach ($subject_names as $sub): ?>
                                <li class="list-group-item"><?= htmlspecialchars($sub) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted mt-2">You are not enrolled in any subject.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Study Materials -->
            <section id="materials" class ="card p-4 mb-4">
                <div class="mb-3">
                    <h5><i class="bi bi-folder2-open"></i> Study Materials</h5>
                </div>
                <div class="row">
                    <?php if ($materials_result && mysqli_num_rows($materials_result) > 0): ?>
                        <?php while ($mat = mysqli_fetch_assoc($materials_result)): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card p-3">
                                    <h6 class="fw-semibold"><i class="bi bi-file-earmark-pdf"></i> <?= htmlspecialchars(basename($mat['file_path'])) ?></h6>
                                    <small class="text-muted mb-2 d-block"><i class="bi bi-journal-bookmark"></i> <?= htmlspecialchars($mat['subject_name']) ?></small>

                                    <?php
                                    $relative_path = $mat['file_path'];
                                    $encoded_filename = rawurlencode(basename($relative_path));
                                    $base_folder = dirname($relative_path);
                                    $pdf_url = 'https://creativetheka.in/' . trim($base_folder, '/') . '/' . $encoded_filename;
                                    ?>

                                    <iframe src="<?= htmlspecialchars($pdf_url) ?>" allowfullscreen></iframe>
                                    <a href="<?= htmlspecialchars($pdf_url) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="bi bi-box-arrow-up-right"></i> View Full PDF
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted">No study materials assigned yet.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Progress Tracker -->
            <section id="progress" class = "mb-4">
                <div class="card p-4">
                    <h5><i class="bi bi-graph-up-arrow"></i> Learning Progress</h5>
                    <?php if ($progress_result && mysqli_num_rows($progress_result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($progress_result)): ?>
                            <?php
                            $progress = ($row['total_chapters'] > 0) 
                                ? round(($row['correct_answers'] / $row['total_chapters']) * 100) 
                                : 0;
                            ?>
                            <div class="mb-3">
                                <h6><i class="bi bi-journal-check"></i> <?= htmlspecialchars($row['subject_name']) ?></h6>
                                <p><i class="bi bi-book"></i> Chapters: <?= $row['total_chapters'] ?> | 
                                   <i class="bi bi-pencil-square"></i> Attempted: <?= $row['attempted'] ?> | 
                                   <i class="bi bi-check2-circle"></i> Correct: <?= $row['correct_answers'] ?></p>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress ?>%;">
                                        <?= $progress ?>%
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted">No progress data found.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Purchase History -->
            <section id="purchase" class = "mb-4">
                <div class="card p-4">
                    <h5><i class="bi bi-receipt"></i> Purchase History</h5>
                    <p class="text-muted">No purchases found. (Add logic to show purchases here)</p>
                </div>
            </section>

            <!-- Settings -->
            <!--<section id="settings" class="mt-5">-->
            <!--    <div class="card p-4">-->
            <!--        <h5><i class="bi bi-gear-fill"></i> Settings</h5>-->
            <!--        <form>-->
            <!--            <div class="mb-3">-->
            <!--                <label for="emailNotifications" class="form-label"><i class="bi bi-envelope"></i> Email Notifications</label>-->
            <!--                <select class="form-select" id="emailNotifications">-->
            <!--                    <option selected>Enabled</option>-->
            <!--                    <option>Disabled</option>-->
            <!--                </select>-->
            <!--            </div>-->
            <!--            <div class="mb-3">-->
            <!--                <label for="password" class="form-label"><i class="bi bi-key"></i> Change Password</label>-->
            <!--                <input type="password" class="form-control" id="password" placeholder="New Password">-->
            <!--            </div>-->
            <!--            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Settings</button>-->
            <!--        </form>-->
            <!--    </div>-->
            <!--</section>-->

            <footer>
                &copy; <?= date('Y') ?> Student Dashboard | All Rights Reserved
            </footer>
        </div>
    </div>
</div>

<!-- Scripts -->
// <script>
//     document.addEventListener('contextmenu', event => event.preventDefault());
// </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
