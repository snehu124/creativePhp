<?php
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer includes (same as your working mail file)
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

include 'db_config.php';

// -----------------------------
// 1️⃣ Get payment ID
// -----------------------------
$paymentId = $_GET['payment_id'] ?? '';
if (!$paymentId) {
    die("Payment ID missing");
}

// -----------------------------
// 2️⃣ Fetch student
// -----------------------------
$stmt = $conn->prepare("SELECT * FROM students WHERE payment_id = ?");
$stmt->bind_param("s", $paymentId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("No invoice found");
}

$student = $res->fetch_assoc();
$stmt->close();

// -----------------------------
// 3️⃣ Amounts & data
// -----------------------------
$price = (float)$student['price'];
$gst   = (float)$student['gst'];
$total = (float)$student['total'];

$fullName = $student['first_name'] . ' ' . $student['last_name'];
$course   = $student['course_title'];
$email    = $student['email'];

// -----------------------------
// 4️⃣ Logo → Base64 (Dompdf safe)
// -----------------------------
$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/logo1.png';
if (!file_exists($logoPath)) {
    die("Logo not found: " . $logoPath);
}

$logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
$logoData = base64_encode(file_get_contents($logoPath));
$logoBase64 = "data:image/{$logoType};base64,{$logoData}";

// -----------------------------
// 5️⃣ Load invoice template
// -----------------------------
ob_start();
include 'invoice_template.php';
$html = ob_get_clean();

// -----------------------------
// 6️⃣ Generate PDF
// -----------------------------
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// -----------------------------
// 7️⃣ Save PDF on server
// -----------------------------
$pdfOutput = $dompdf->output();

$invoiceDir = __DIR__ . '/invoices';
if (!is_dir($invoiceDir)) {
    mkdir($invoiceDir, 0777, true);
}

$pdfPath = $invoiceDir . "/Invoice_{$paymentId}.pdf";
file_put_contents($pdfPath, $pdfOutput);

// -----------------------------
// 8️⃣ Send Email with PDF
// -----------------------------
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'mail.creativetheka.in';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'test@creativetheka.in';
    $mail->Password   = 'Ay.)My%qVStG';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('test@creativetheka.in', 'Achievers Castle');
    $mail->addAddress($email, $fullName);

    // Attach invoice
    $mail->addAttachment($pdfPath);

    $mail->isHTML(true);
    $mail->Subject = 'Your Enrollment Invoice – Achievers Castle';

    $mail->Body = "
        <p>Dear <strong>{$fullName}</strong>,</p>

        <p>Thank you for enrolling with <strong>Achievers Castle</strong>.</p>

        <p>Please find attached your invoice for the course:</p>

        <p>
            <strong>Course:</strong> {$course}<br>
            <strong>Amount Paid:</strong> CAD {$total}
        </p>

        <p>If you have any questions, feel free to reply to this email.</p>

        <p>Warm regards,<br>
        Achievers Castle Team</p>
    ";

    $mail->send();

} catch (Exception $e) {
    // Email error should not block invoice display
}

// -----------------------------
// 9️⃣ Stream PDF in browser
// -----------------------------
$dompdf->stream("Invoice_{$paymentId}.pdf", ['Attachment' => false]);
exit;
