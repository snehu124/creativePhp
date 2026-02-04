<?php
// enroll.php
include 'db_config.php';

// Course ID fetch from URL
$courseId = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

// Safety check
if ($courseId <= 0) {
    die("Invalid course ID.");
}

// Fetch course details
$courseQuery = "SELECT * FROM early_learner_courses WHERE id = $courseId";
$courseResult = $conn->query($courseQuery);

if (!$courseResult || $courseResult->num_rows === 0) {
    die("Invalid course ID.");
}

$course = $courseResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll Now</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-4 bg-primary text-white py-2">
        Student Enrollment Form
    </h2>

    <!-- ✅ FIXED ACTION -->
    <form id="enrollForm" action="save_enrollment.php" method="POST">

        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">

        <!-- Student Info -->
        <h5 class="mt-4 mb-3 text-primary fw-bold">Student Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">First Name:</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Birth Date:</label>
                <input type="date" class="form-control" name="birth_date" required>
            </div>

            <div class="col-md-6">
                <label class="form-label d-block">Gender:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="Male" required>
                    <label class="form-check-label">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="Female" required>
                    <label class="form-check-label">Female</label>
                </div>
            </div>

            <div class="col-12">
                <label class="form-label">Student Address:</label>
                <input type="text" class="form-control" name="address" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Number:</label>
                <input type="tel" class="form-control" name="contact" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email Address:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
        </div>

        <!-- Parent Info -->
        <h5 class="mt-4 mb-3 text-primary fw-bold">Parent/Guardian Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Parent/Guardian Name:</label>
                <input type="text" class="form-control" name="parent_name" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Relationship:</label>
                <input type="text" class="form-control" name="relationship" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Parent Contact:</label>
                <input type="tel" class="form-control" name="parent_contact" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Parent Email:</label>
                <input type="email" class="form-control" name="parent_email" required>
            </div>
        </div>

        <!-- Academic Info -->
        <h5 class="mt-4 mb-3 text-primary fw-bold">Academic Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Grade/Program:</label>
                <input type="text" class="form-control" name="grade_program" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Course Name:</label>
                <input type="text" class="form-control"
                       value="<?php echo htmlspecialchars($course['title']); ?>" readonly>

                <!-- Hidden fields -->
                <input type="hidden" name="course_title"
                       value="<?php echo htmlspecialchars($course['title']); ?>">

                <input type="hidden" name="price"
                       value="<?php echo number_format($course['price'], 2, '.', ''); ?>">

                <input type="hidden" name="gst"
                       value="<?php echo number_format($course['price'] * 0.18, 2, '.', ''); ?>">

                <input type="hidden" name="total"
                       value="<?php echo number_format($course['price'] * 1.18, 2, '.', ''); ?>">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success px-4 py-2">
                Submit & Pay (Fake)
            </button>
        </div>

    </form>
</div>

</body>
</html>
