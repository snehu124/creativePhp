<?php
// save_enrollment.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

// ============================
// Collect & sanitize input
// ============================
$first_name      = trim($_POST['first_name'] ?? '');
$last_name       = trim($_POST['last_name'] ?? '');
$email           = trim($_POST['email'] ?? '');
$contact         = trim($_POST['contact'] ?? '');
$birth_date      = trim($_POST['birth_date'] ?? '');
$gender          = trim($_POST['gender'] ?? '');
$address         = trim($_POST['address'] ?? '');
$parent_name     = trim($_POST['parent_name'] ?? '');
$relationship    = trim($_POST['relationship'] ?? '');
$parent_contact  = trim($_POST['parent_contact'] ?? '');
$parent_email    = trim($_POST['parent_email'] ?? '');
$grade_program   = trim($_POST['grade_program'] ?? '');
$course_id       = intval($_POST['course_id'] ?? 0);
$course_title    = trim($_POST['course_title'] ?? '');
$price           = floatval($_POST['price'] ?? 0);
$gst             = floatval($_POST['gst'] ?? 0);
$total           = floatval($_POST['total'] ?? 0);

// Fake payment details (for now)
$payment_id     = 'FAKE_' . uniqid();
$payment_status = 'Pending';

// ============================
// Insert into DB ONLY
// ============================
$sql = "INSERT INTO students 
(
    first_name, last_name, email, phone, dob, gender, address,
    parent_name, relationship, parent_contact, parent_email,
    grade, course_id, course_title,
    price, gst, total,
    payment_id, payment_status, created_at
)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "sssssssssssssssssss",
    $first_name,
    $last_name,
    $email,
    $contact,
    $birth_date,
    $gender,
    $address,
    $parent_name,
    $relationship,
    $parent_contact,
    $parent_email,
    $grade_program,
    $course_id,
    $course_title,
    $price,
    $gst,
    $total,
    $payment_id,
    $payment_status
);

if ($stmt->execute()) {
    // ✅ SUCCESS → redirect to invoice generation
    header("Location: generate_invoice.php?payment_id={$payment_id}");
    exit;
} else {
    echo "Database Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
