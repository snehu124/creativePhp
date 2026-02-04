<?php
session_start();
include 'db_config.php';

$teacher_id = $_SESSION['teacher_id'] ?? null;

// Step 1: Fetch teacher's subject
$sub_q = mysqli_query($conn, "SELECT subject FROM teachers WHERE id = '$teacher_id'");
$sub_row = mysqli_fetch_assoc($sub_q);
$teacher_subject = $sub_row['subject'] ?? '';

// Step 2: Fetch students whose subject matches & parent_email is set
$students_q = mysqli_query($conn, "
    SELECT id, first_name, parent_email 
    FROM students 
    WHERE subject = '$teacher_subject' AND parent_email IS NOT NULL
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Email Updates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #dee2e6 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .email-form-wrapper {
            max-width: 620px;
            margin: 60px auto;
        }
        .form-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .form-title {
            font-weight: 700;
            margin-bottom: 30px;
            color: #c0392b;
        }
        label i {
            margin-right: 8px;
            color: #c0392b;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
        button.btn {
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            background: linear-gradient(135deg, #c0392b, #2980b9);
            border: none;
            color: white;
        }
        button.btn:hover {
            background: linear-gradient(135deg, #a93226, #21618c);
        }
    </style>
</head>
<body>

<div class="email-form-wrapper">
    <div class="form-card">
        <h3 class="form-title text-center"><i class="bi bi-envelope-paper"></i> Send Email Updates</h3>

        <form method="POST" action="send_email_action.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label><i class="bi bi-person-lines-fill"></i>Select Student</label>
                <select name="student_email" class="form-select" required>
                    <option value="">-- Select Student --</option>
                    <?php while ($row = mysqli_fetch_assoc($students_q)) {
                        $email = $row['parent_email'];
                        $name = $row['name'];
                        echo "<option value='{$email}'>{$name} ({$email})</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label><i class="bi bi-file-earmark-text"></i>Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Enter email subject..." required>
            </div>
            <div class="mb-3">
                <label><i class="bi bi-chat-left-dots"></i>Message</label>
                <textarea name="message" class="form-control" rows="6" placeholder="Type your message here..." required></textarea>
            </div>
            <div class="mb-3">
                <label><i class="bi bi-paperclip"></i>Attach File (PDF/Image)</label>
                <input type="file" name="attachment" class="form-control" accept=".pdf,image/*">
            </div>
            <button type="submit" class="btn w-100">
                <i class="bi bi-send-fill"></i> Send Email
            </button>
        </form>
    </div>
</div>

</body>
</html>
