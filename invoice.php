<?php
require 'vendor/autoload.php'; // Dompdf autoload

use Dompdf\Dompdf;
use Dompdf\Options;

include 'db_config.php';

// Get payment_id from URL
$paymentId = $_GET['payment_id'] ?? '';

if (!$paymentId) {
    die("❌ Payment ID is missing.");
}

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE payment_id = ?");
$stmt->bind_param("s", $paymentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("❌ No invoice found for this Payment ID.");
}

$student = $result->fetch_assoc();
$stmt->close();

// Format dynamic values
$fullName = $student['first_name'] . ' ' . $student['last_name'];
$date = date('F d, Y', strtotime($student['created_at']));
$course = $student['course_title'];
$grade = $student['grade'];
$amount = 50; // Or fetch from DB if dynamic
$address = $student['address'];
$email = $student['email'];
$phone = $student['phone'];

// Build HTML
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        @page {
            margin: 1cm 2cm 3cm 2cm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
            margin: 0;
            color: #000;
        }
        h1, h2, h3 {
            font-weight: bold;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10mm;
        }
        td, th {
            padding: 5px;
            vertical-align: top;
        }
        .header {
            font-size: 16pt;
            font-weight: bold;
        }
        .shop-info h3 {
            margin: 0;
        }
        .order-data-addresses th {
            text-align: left;
            padding-right: 10px;
            font-weight: normal;
        }
        .order-details th {
            background: #000;
            color: #fff;
            border: 1px solid #000;
        }
        .order-details td {
            border: 1px solid #ccc;
        }
        .totals th, .totals td {
            border-top: 1px solid #ccc;
            padding: 6px 0;
        }
        .totals tr:last-child td {
            border-top: 2px solid #000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table class="head">
        <tr>
            <td class="header">Invoice</td>
            <td class="shop-info" align="right">
                <h3>Achievers Castle</h3>
                <div>www.achieverscastle.com</div>
            </td>
        </tr>
    </table>

    <table class="order-data-addresses">
        <tr>
            <td>
                <h3>Billing Address:</h3>
                <?= $fullName ?><br>
                <?= $address ?><br>
                <?= $email ?><br>
                <?= $phone ?>
            </td>
            <td>
                <h3>Shipping Address:</h3>
                <?= $fullName ?><br>
                <?= $address ?><br>
                <?= $email ?><br>
                <?= $phone ?>
            </td>
            <td>
                <table>
                    <tr><th>Order Number:</th><td><?= $student['id'] ?></td></tr>
                    <tr><th>Order Date:</th><td><?= $date ?></td></tr>
                    <tr><th>Payment Method:</th><td>Online</td></tr>
                    <tr><th>Payment ID:</th><td><?= $paymentId ?></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="order-details">
        <thead>
            <tr>
                <th class="product">Course</th>
                <th class="quantity">Grade</th>
                <th class="price">Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $course ?></td>
                <td><?= $grade ?></td>
                <td>$<?= number_format($amount, 2) ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" align="right"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($amount, 2) ?></strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php
$html = ob_get_clean();

// Initialize Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Stream in browser
$dompdf->stream("Invoice_" . $paymentId . ".pdf", ["Attachment" => false]);
exit;
