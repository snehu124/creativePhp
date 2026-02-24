<?php
include "db_config.php";

/* ================= LOAD ENV ================= */
$env = parse_ini_file(__DIR__ . '/.env');
if (!$env || empty($env['APP_URL'])) {
    die("Configuration error");
}

$baseUrl = rtrim($env['APP_URL'], '/');

/* ================= VALIDATE INPUT ================= */
if (empty($_POST['email'])) {

    session_start();

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Invalid Request';
    $_SESSION['msg_text']  = 'Please enter your email address.';

    header("Location: teacher_forgot_password.php");
    exit;
}

$email = mysqli_real_escape_string($conn, $_POST['email']);

/* ================= FETCH STUDENT ================= */
$q = mysqli_query($conn, "
    SELECT name, email 
    FROM teachers 
    WHERE email='$email'
");

session_start();

if (mysqli_num_rows($q) !== 1) {

    $_SESSION['msg_type']  = 'info';
    $_SESSION['msg_title'] = 'Check Your Email';
    $_SESSION['msg_text']  = 'If this email is registered, a reset link has been sent.';
    $_SESSION['msg_back']   = 'teacher_forgot_password.php';


    header("Location: message.php");
    exit;
}


$user = mysqli_fetch_assoc($q);

/* ================= GENERATE TOKEN ================= */
$token     = bin2hex(random_bytes(32));     // plain token (email)

/* ================= UPDATE USING EMAIL ================= */
$update = mysqli_query($conn, "
    UPDATE teachers
    SET reset_token='$token',
        token_expiry = DATE_ADD(NOW(), INTERVAL 15 MINUTE)
    WHERE email='{$user['email']}'
");

if (!$update) {
    die("UPDATE FAILED: " . mysqli_error($conn));
}

/* ================= RESET LINK ================= */
$resetLink = $baseUrl . "/teacher_reset_password.php?token=$token";

/* ================= PHPMAILER ================= */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $env['MAIL_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['MAIL_USER'];
    $mail->Password   = $env['MAIL_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $env['MAIL_PORT'];

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->setFrom($env['MAIL_USER'], 'Creative Theka');
    $mail->addAddress($user['email'], $user['name']);

    $mail->isHTML(false);
    $mail->Subject = 'Password Reset Link';

    $mail->Body =
"Hello {$user['name']},

Open the link below to reset your password:
$resetLink

This link expires in 15 minutes.

— Creative Theka";

   $mail->send();

$_SESSION['msg_type']  = 'success';
$_SESSION['msg_title'] = 'Email Sent!';
$_SESSION['msg_text']  = 'We have sent a password reset link to your email. Please check your inbox.';

header("Location: message.php");
exit;

}
catch (Exception $e) {

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Email Failed';
    $_SESSION['msg_text']  = 'Sorry, we could not send the reset link. Please try again later.';

    header("Location: message.php");
    exit;
}

