<?php
include 'db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';

$env = parse_ini_file(__DIR__ . '/.env');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid Request");
}

/* ================= SANITIZE FORM DATA ================= */

$parent_name = htmlspecialchars(trim($_POST['parent_name']));
$child_name  = htmlspecialchars(trim($_POST['child_name']));
$child_age   = intval($_POST['child_age']);
$phone       = htmlspecialchars(trim($_POST['phone']));
$email       = htmlspecialchars(trim($_POST['email']));
$date        = trim($_POST['appointment_date']);
$time        = trim($_POST['appointment_time']);
$message     = htmlspecialchars(trim($_POST['message']));

$created_at = date("Y-m-d H:i:s");

/* ================= FORMAT DATE & TIME ================= */

$formattedDate = date("d F Y", strtotime($date));
$formattedTime = date("h:i A", strtotime($time));

/* ================= INSERT INTO DATABASE ================= */

$stmt = $conn->prepare("
    INSERT INTO appointments 
    (parent_name, child_name, child_age, phone, email, appointment_date, appointment_time, message, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssissssss",
    $parent_name,
    $child_name,
    $child_age,
    $phone,
    $email,
    $date,
    $time,
    $message,
    $created_at
);

if (!$stmt->execute()) {
    die("Database Error: " . $stmt->error);
}

$stmt->close();

/* ================= MAIL FUNCTION ================= */

function sendMail($to, $subject, $body, $env, $replyToEmail = null, $replyToName = null) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $env['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $env['MAIL_USER'];
        $mail->Password   = $env['MAIL_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)$env['MAIL_PORT'];

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom($env['MAIL_USER'], 'Achievers Castle');
        $mail->addAddress($to);

        // Optional reply-to
        if ($replyToEmail) {
            $mail->addReplyTo($replyToEmail, $replyToName);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Mail Error for $to : " . $mail->ErrorInfo);
        return false;
    }
}

/* ================= PARENT CONFIRMATION MAIL ================= */

$parentBody = "
<div style='font-family: Arial, sans-serif; max-width:600px;'>

<h2 style='color:#2c3e50;'>Appointment Confirmation</h2>

<p>Dear <b>$parent_name</b>,</p>

<p>Thank you for booking an appointment with <b>Achievers Castle</b>.</p>

<div style='background:#f4f6f8;padding:15px;border-radius:5px;margin:15px 0;'>
<b>Child Name:</b> $child_name <br>
<b>Age:</b> $child_age <br>
<b>Date:</b> $formattedDate <br>
<b>Time:</b> $formattedTime
</div>

<p>We look forward to meeting you.</p>

<br>
<p>Regards,<br><b>Achievers Castle Team</b></p>

</div>
";

$parentMailSent = sendMail(
    $email,
    "Appointment Confirmation - Achievers Castle",
    $parentBody,
    $env
);

/* ================= ADMIN MAIL ================= */

$adminEmail = $env['MAIL_USER'];

$adminBody = "
<div style='font-family: Arial, sans-serif; max-width:600px;'>

<h2 style='color:#c0392b;'>New Appointment Booking Received</h2>

<p><b>Parent Name:</b> $parent_name</p>
<p><b>Child Name:</b> $child_name</p>
<p><b>Age:</b> $child_age</p>
<p><b>Email:</b> $email</p>
<p><b>Phone:</b> $phone</p>
<p><b>Date:</b> $formattedDate</p>
<p><b>Time:</b> $formattedTime</p>
<p><b>Message:</b> $message</p>
<p><b>Booked At:</b> $created_at</p>

</div>
";

$adminMailSent = sendMail(
    $adminEmail,
    "New Appointment - $child_name - $formattedDate",
    $adminBody,
    $env,
    $email,
    $parent_name
);

/* ================= FINAL RESPONSE ================= */

if ($parentMailSent && $adminMailSent) {
    header("Location: thank-you.php");
    exit();
} else {
    echo "Appointment saved but mail failed.";
}

$conn->close();
?>
