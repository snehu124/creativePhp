<?php
// save_enrollment.php
include 'db_config.php';

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

// Collect and sanitize POST data
$course_id       = intval($_POST['course_id']);
$course_title    = trim($_POST['course_title']);
$first_name      = trim($_POST['first_name']);
$last_name       = trim($_POST['last_name']);
$birth_date      = trim($_POST['birth_date']);
$gender          = trim($_POST['gender']);
$address         = trim($_POST['address']);
$contact         = trim($_POST['contact']);
$email           = trim($_POST['email']);
$parent_name     = trim($_POST['parent_name']);
$relationship    = trim($_POST['relationship']);
$parent_contact  = trim($_POST['parent_contact']);
$parent_email    = trim($_POST['parent_email']);
$grade_program   = trim($_POST['grade_program']);

// 🔧 Fake payment ID (kyunki abhi payment gateway nahi hai)
$payment_id = 'FAKE_' . time();

$created_at = date("Y-m-d H:i:s");


// ================================
// ✅ DUPLICATE CHECK (email + course)
// ================================
$checkStmt = $conn->prepare(
    "SELECT id FROM enrollments WHERE email = ? AND course_id = ?"
);
$checkStmt->bind_param("si", $email, $course_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("You are already enrolled in this course.");
}
$checkStmt->close();


// ================================
// ✅ INSERT DATA (SAFE)
// ================================
$insertStmt = $conn->prepare("
    INSERT INTO enrollments
    (
        course_id,
        course_title,
        first_name,
        last_name,
        birth_date,
        gender,
        address,
        contact,
        email,
        parent_name,
        relationship,
        parent_contact,
        parent_email,
        grade_program,
        payment_id,
        created_at
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insertStmt->bind_param(
    "isssssssssssssss",
    $course_id,
    $course_title,
    $first_name,
    $last_name,
    $birth_date,
    $gender,
    $address,
    $contact,
    $email,
    $parent_name,
    $relationship,
    $parent_contact,
    $parent_email,
    $grade_program,
    $payment_id,
    $created_at
);

if ($insertStmt->execute()) {
    // ✅ Success response
    echo "success";
} else {
    echo "Error: " . $insertStmt->error;
}

$insertStmt->close();
$conn->close();
?>
