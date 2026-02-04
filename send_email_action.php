<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

$to      = $_POST['student_email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

$mail = new PHPMailer(true);

try {
    // Validate email
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email address: $to");
    }

    // SMTP Setup
    $mail->isSMTP();
    $mail->Host       = 'mail.creativetheka.in';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'test@creativetheka.in';
    $mail->Password   = 'Ay.)My%qVStG';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email Setup
    $mail->setFrom('test@creativetheka.in', 'Achievers Castel');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = nl2br($message);

    // File attachment
    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['error'] === 0) {
        $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
    }

    $mail->send();
    echo "<script>alert('Email sent successfully!'); window.location.href='send_email_updates.php';</script>";
} catch (Exception $e) {
    echo "<h4 style='color:red;'>Error: " . $mail->ErrorInfo . "</h4>";
}
