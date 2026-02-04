<?php
session_start();
include '../db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../teacher_login.php');
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
$assessment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($assessment_id <= 0) {
    die("Invalid assessment ID.");
}

// For debugging only (remove in production)
// error_reporting(E_ALL); ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        mysqli_autocommit($conn, false);

        // Verify ownership
        $stmt = $conn->prepare("SELECT title FROM assessments WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $assessment_id, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Assessment not found or you don't have permission.");
        }
        $assessment = $result->fetch_assoc();
        $stmt->close();

        // 1. Delete from assessment_questions (junction table)
        $stmt = $conn->prepare("DELETE FROM assessment_questions WHERE assessment_id = ?");
        $stmt->bind_param("i", $assessment_id);
        $stmt->execute();
        $stmt->close();

        // 2. Delete the assessment itself
        // This will automatically delete from assessment_assignments because of ON DELETE CASCADE
        $stmt = $conn->prepare("DELETE FROM assessments WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $assessment_id, $teacher_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception("Failed to delete assessment (possibly already deleted).");
        }
        $stmt->close();

        mysqli_commit($conn);
        $success = true;
        $title = $assessment['title'];

    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Delete Assessment Error (ID: $assessment_id): " . $e->getMessage());
        $error = $e->getMessage();
    }

    mysqli_autocommit($conn, true);

} else {
    // Show confirmation page
    $stmt = $conn->prepare("SELECT title FROM assessments WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $assessment_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Assessment not found or access denied.");
    }
    $info = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Assessment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea, #764ba2); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Segoe UI', sans-serif;
        }
        .card { 
            border-radius: 30px; 
            overflow: hidden; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.3); 
            max-width: 500px; 
            width: 90%; 
        }
        .header { padding: 40px 30px; text-align: center; color: white; }
        .header-danger { background: linear-gradient(135deg, #ff6b6b, #ee5a52); }
        .header-success { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
        .body { padding: 40px; text-align: center; background: white; }
        .btn-custom {
            border-radius: 50px; 
            padding: 12px 40px; 
            font-weight: 600;
            min-width: 160px;
        }
        .success-check {
            font-size: 80px;
            animation: bounce 0.8s;
        }
        @keyframes bounce {
            0%,100%{transform:scale(1)} 50%{transform:scale(1.2)}
        }
    </style>
</head>
<body>

<?php if (isset($success)): ?>
    <div class="card">
        <div class="header header-success">
            <div class="success-check">Checkmark</div>
            <h2>Deleted Successfully!</h2>
        </div>
        <div class="body">
            <p class="lead mb-4">"<?= htmlspecialchars($title) ?>" has been permanently removed.</p>
            <a href="manage_assessments.php" class="btn btn-success btn-custom">
                Checkmark Back to Assessments
            </a>
        </div>
    </div>

<?php elseif (isset($error)): ?>
    <div class="card">
        <div class="header header-danger">
            <i class="bi bi-x-circle display-1"></i>
            <h3 class="mt-3">Delete Failed</h3>
        </div>
        <div class="body">
            <div class="alert alert-danger">
                <strong>Error:</strong> <?= htmlspecialchars($error) ?>
            </div>
            <a href="manage_assessments.php" class="btn btn-secondary btn-custom me-2">Back</a>
            <button onclick="history.back()" class="btn btn-outline-danger btn-custom">Try Again</button>
        </div>
    </div>

<?php else: ?>
    <div class="card">
        <div class="header header-danger">
            <i class="bi bi-exclamation-triangle display-1"></i>
            <h3 class="mt-3">Delete This Assessment?</h3>
        </div>
        <div class="body">
            <h4 class="text-danger mb-3">"<?= htmlspecialchars($info['title']) ?>"</h4>
            <p>This will permanently delete:</p>
            <ul class="text-start mx-auto" style="max-width:300px;">
                <li>The assessment</li>
                <li>All assigned students & submissions</li>
                <li>All linked questions</li>
            </ul>
            <p class="text-danger fw-bold mt-3">This action cannot be undone!</p>

            <form method="post" class="mt-4">
                <button type="submit" class="btn btn-danger btn-custom me-3">
                    Trash Delete Forever
                </button>
                <a href="manage_assessments.php" class="btn btn-secondary btn-custom">
                    Cancel
                </a>
            </form>
        </div>
    </div>
<?php endif; ?>

</body>
</html>