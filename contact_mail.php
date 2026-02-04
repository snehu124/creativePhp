<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load PHPMailer classes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Get form data safely
$firstname = htmlspecialchars(trim($_POST['firstname'] ?? ''));
$lastname  = htmlspecialchars(trim($_POST['lastname'] ?? ''));
$email     = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$number    = htmlspecialchars(trim($_POST['number'] ?? ''));
$message   = htmlspecialchars(trim($_POST['message'] ?? ''));

// Check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

// Prepare email content
$body = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> $firstname $lastname</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $number</p>
    <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
";

$mail = new PHPMailer(true);

try {
    // SMTP Setup
    $mail->isSMTP();
    $mail->Host       = 'mail.creativetheka.in';       // ✅ Your mail host
    $mail->SMTPAuth   = true;
    $mail->Username   = 'test@creativetheka.in';        // ✅ Your SMTP email
    $mail->Password   = 'Ay.)My%qVStG';                 // ✅ Your SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email Headers
    $mail->setFrom('test@creativetheka.in', 'Contact Form');
    $mail->addAddress('test@creativetheka.in');         // ✅ Your destination email
    $mail->addReplyTo($email, "$firstname $lastname");

    $mail->isHTML(true);
    $mail->Subject = "New Contact Request from $firstname $lastname";
    $mail->Body    = $body;

    $mail->send();

    echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
} catch (Exception $e) {
    echo "<h4 style='color:red;'>Mail Error: " . $mail->ErrorInfo . "</h4>";
}
