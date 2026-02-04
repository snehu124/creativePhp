<?php
include 'db_config.php';

$paymentId = $_GET['payment_id'] ?? '';
$courseId = intval($_GET['course_id'] ?? 0);

$updateMessage = "";
$student = null;

if (!empty($paymentId) && $courseId > 0) {
    // Get latest student of that course
    $query = "SELECT * FROM students WHERE course_id = $courseId ORDER BY id DESC LIMIT 1";
    $res = $conn->query($query);

    if ($res->num_rows > 0) {
        $student = $res->fetch_assoc();
        $studentId = $student['id'];

        // Update payment status & ID
        $stmt = $conn->prepare("UPDATE students SET payment_status = ?, payment_id = ? WHERE id = ?");
        $status = "Success";
        $stmt->bind_param("ssi", $status, $paymentId, $studentId);
        $stmt->execute();
        $stmt->close();

        // Update student array with new values
        $student['payment_status'] = $status;
        $student['payment_id'] = $paymentId;

        $updateMessage = "<p class='text-success'><strong>✅ Payment details saved successfully!</strong></p>";
    } else {
        $updateMessage = "<p class='text-danger'><strong>❌ No student found to update.</strong></p>";
    }
} else {
    $updateMessage = "<p class='text-danger'><strong>⚠️ Missing payment data.</strong></p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You & Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container py-5">

    <!-- Thank You Section -->
    <div class="text-center">
        <h1 class="text-success">🎉 Payment Successful!</h1>
        <p class="lead mt-3">Thank you for enrolling. Your payment has been processed successfully.</p>
        <?= $updateMessage ?>
        <p><strong>Payment ID:</strong> <?= htmlspecialchars($paymentId); ?></p>
    </div>

    <!-- Invoice Section -->
    <?php if ($student): ?>
        <div class="invoice-box card mt-5 shadow" id="invoice-content">
            <div class="card-body">
                <h3 class="text-center mb-4">🧾 Payment Invoice</h3>

                <h5 class="text-primary">Student Information</h5>
                <p><strong>Name:</strong> <?= $student['first_name'] . ' ' . $student['last_name']; ?></p>
                <p><strong>Email:</strong> <?= $student['email']; ?></p>
                <p><strong>Phone:</strong> <?= $student['phone']; ?></p>
                <p><strong>Grade:</strong> <?= $student['grade']; ?></p>
                <p><strong>Course:</strong> <?= $student['course_title']; ?></p>

                <hr>

                <h5 class="text-primary">Payment Details</h5>
                <p><strong>Payment ID:</strong> <?= $student['payment_id']; ?></p>
                <p><strong>Status:</strong>
                    <?php if (strtolower($student['payment_status']) === 'success'): ?>
                        <span class="badge bg-success">Success</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Failed</span>
                    <?php endif; ?>
                </p>
                <p><strong>Paid On:</strong> <?= date('d M Y, h:i A', strtotime($student['created_at'])); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Buttons -->
    <div class="text-center mt-4 no-print">
        <!--<button onclick="window.print()" class="btn btn-primary">🖨️ Print Invoice</button>-->
        <a href="generate_invoice.php?payment_id=<?= $paymentId ?>&download=1" class="btn btn-success">📥 Download Invoice</a>
        <a href="index.php" class="btn btn-secondary ms-2">🏠 Back to Home</a>
    </div>

</div>
</body>
</html>
