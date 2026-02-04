<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../db_config.php";
include "student_sidebar.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$student_name = $student['first_name'] . ' ' . $student['last_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href ="student.css" rel ="stylesheet">
    <style>
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .table-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
            font-size: 15px;
        }
        th {
            background-color: #f1f3f5;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }
        .bi {
            margin-right: 6px;
        }
        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

    <div class="main">


        <!-- Main Content -->
        <div class="content">
            <h3 class="page-title mb-4">🧾 Purchase History</h3>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Price</th>
                            <th>GST</th>
                            <th>Total</th>
                            <th>Payment ID</th>
                            <th>Status</th>
                            <th>Mode</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($student['course_title']) ?></td>
                            <td>₹<?= number_format($student['price'], 2) ?></td>
                            <td>₹<?= number_format($student['gst'], 2) ?></td>
                            <td>₹<?= number_format($student['total'], 2) ?></td>
                            <td><?= htmlspecialchars($student['payment_id'] ?? 'N/A') ?></td>
                            <td><?= ucfirst($student['payment_status']) ?></td>
                            <td><?= ucfirst($student['mode_of_education']) ?></td>
                            <td><?= ucfirst($student['payment_type']) ?></td>
                            <td><?= date("d M Y, h:i A", strtotime($student['created_at'])) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
