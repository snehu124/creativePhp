<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load .env
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    foreach (file($envPath) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[$key] = $value;
    }
}

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Form data
$name        = htmlspecialchars($_POST['name'] ?? '');
$father_name = htmlspecialchars($_POST['father_name'] ?? '');
$email       = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone       = htmlspecialchars($_POST['phone'] ?? '');
$subject     = htmlspecialchars($_POST['subject'] ?? '');
$message     = htmlspecialchars($_POST['message'] ?? '');

$mailBody = "
<h2>New Home Page Enquiry</h2>
<p><strong>Name:</strong> $name</p>
<p><strong>Father Name:</strong> $father_name</p>
<p><strong>Email:</strong> $email</p>
<p><strong>Phone:</strong> $phone</p>
<p><strong>Subject:</strong> $subject</p>
<p><strong>Message:</strong><br>" . nl2br($message) . "</p>
";

$mail = new PHPMailer(true);

try {
    // Gmail SMTP
    $mail->isSMTP();
    $mail->Host       = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USER'];
    $mail->Password   = $_ENV['MAIL_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    // ADMIN MAIL ONLY
    $mail->setFrom($_ENV['MAIL_USER'], 'Achiever\'s Castle');
    $mail->addAddress($_ENV['MAIL_USER']); // Admin
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = "New Home Page Enquiry";
    $mail->Body    = $mailBody;

    $mail->send();

    echo "<script>
        alert('Thank you! We will contact you soon.');
        window.location.href='index.php';
    </script>";

} catch (Exception $e) {
    echo 'Mail Error: ' . $mail->ErrorInfo;
}
