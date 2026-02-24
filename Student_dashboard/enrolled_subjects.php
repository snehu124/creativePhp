<?php
session_start();
include "../db_config.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "
SELECT 
    s.id AS subject_id,
    s.subject_name,
    st.grade,
    c.image AS course_image
FROM student_subjects ss
JOIN subjects s 
    ON ss.subject_id = s.id
JOIN students st
    ON ss.student_id = st.id
LEFT JOIN courses c
    ON c.subject_id = s.id
WHERE ss.student_id = ?
GROUP BY s.id
ORDER BY s.subject_name ASC
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Enrolled Courses</title>
    <link href="student.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9ff, #e0e7ff);
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .main-layout {
            display: flex;
            min-height: 100vh;
        }

        .content-area {
            margin-left: 260px;
            padding: 35px 45px;
            flex: 1;
        }

        .course-img {
            width: 130px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        @media (max-width: 992px) {
            .content-area {
                margin-left: 0;
                padding-top: 80px;
            }
        }
    </style>
</head>

<body>

    <div class="main-layout">

        <!-- Sidebar -->
        <?php include 'student_sidebar.php'; ?>

        <!-- Mobile Toggle -->
        <button class="btn btn-primary d-lg-none position-fixed" id="sidebarToggle"
            style="top:15px; left:15px; z-index:1100; border-radius:50%; width:48px; height:48px;">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Content -->
        <div class="content-area">

            <h3 class="mb-4 fw-bold text-primary">
                <i class="bi bi-journal-bookmark-fill me-2"></i>
                My Enrolled Courses
            </h3>

            <?php if(mysqli_num_rows($result) > 0): ?>

            <div class="card shadow-sm">
                <div class="card-body p-0">

                    <table class="table table-hover mb-0 align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Subject</th>
                                <th>Grade</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while($row = mysqli_fetch_assoc($result)): ?>

                            <tr>

                                <td>
                                    <?php
                                $imgPath = !empty($row['course_image']) 
                                           ? $row['course_image'] 
                                           : '../images/default-course.jpg';
                                ?>
                                    <img src="<?= htmlspecialchars($imgPath); ?>" class="course-img">
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['subject_name']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['grade']); ?>
                                </td>

                                <td>
                                    <a href="course_sidebar.php?id=<?= urlencode($row['subject_id']); ?>"
                                        class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                </td>

                            </tr>

                            <?php endwhile; ?>

                        </tbody>
                    </table>

                </div>
            </div>

            <?php else: ?>

            <div class="alert alert-info">
                You have not enrolled in any courses yet.
            </div>

            <?php endif; ?>

        </div>
    </div>

    <script>
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('studentSidebar');

        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    </script>

</body>

</html>