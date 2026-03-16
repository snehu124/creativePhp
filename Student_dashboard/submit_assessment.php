<?php
session_start();
include "../db_config.php";
include "student_sidebar.php";

if (!isset($_SESSION['student_id'])) {
    die("Unauthorized");
}

$student_id = (int)$_SESSION['student_id'];
$ass_id = (int)($_POST['assessment_id'] ?? 0);

if ($ass_id <= 0) {
    die("Invalid assessment ID");
}

// AB YAHAN DAALO DEBUG — SAB KUCH DEFINE HONE KE BAAD
file_put_contents('debug_log.txt', "=== NEW SUBMIT START ===\nAssessment ID: $ass_id\nStudent ID: $student_id\n\n", FILE_APPEND);

$conn->autocommit(false);
$score = 0;
$total_questions = 0;

try {
    // 1. Ensure assignment record
    $check = $conn->prepare("SELECT 1 FROM assessment_assignments WHERE assessment_id = ? AND student_id = ?");
    $check->bind_param("ii", $ass_id, $student_id);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;
    $check->close();

    if (!$exists) {
        $ins = $conn->prepare("INSERT INTO assessment_assignments (assessment_id, student_id, created_at) VALUES (?, ?, NOW())");
        $ins->bind_param("ii", $ass_id, $student_id);
        $ins->execute();
        $ins->close();
    }

    // 2. Mark submitted
    $stmt = $conn->prepare("UPDATE assessment_assignments SET submitted_at = NOW() WHERE assessment_id = ? AND student_id = ?");
    $stmt->bind_param("ii", $ass_id, $student_id);
    $stmt->execute();
    $stmt->close();

    // 3. Save answers
       // 3. Save student answers — AB ASSESSMENT KE LIYE ALAG TABLE
    $student_answers = $_POST['answer'] ?? [];
    file_put_contents('debug_log.txt', "Student Answers Received:\n" . print_r($student_answers, true) . "\n\n", FILE_APPEND);

    if (!empty($student_answers)) {
        $ins = $conn->prepare("
            INSERT INTO assessment_student_answers 
            (student_id, assessment_id, question_id, student_answer) 
            VALUES (?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE student_answer = VALUES(student_answer)
        ");
        
        foreach ($student_answers as $qid => $ans) {
            $qid = (int)$qid;
            $ans = trim($ans);
            if ($ans !== '') {
                $ins->bind_param("iiis", $student_id, $ass_id, $qid, $ans);
                $ins->execute();
            }
        }
        $ins->close();
    }

    // 4. Fetch correct answers — YE PAKKA CHALEGA AB
    $correct = [];
    $debug_questions = [];

    $q = $conn->prepare("
        SELECT qq.id, qq.correct_answer
        FROM assessment_questions aq
        JOIN quiz_questions qq ON aq.question_id = qq.id
        WHERE aq.assessment_id = ?
    ");
    $q->bind_param("i", $ass_id);
    $q->execute();
    $res = $q->get_result();

    while ($row = $res->fetch_assoc()) {
        $cid = $row['id'];
        $correct_ans = trim($row['correct_answer'] ?? '');
        $debug_questions[] = "QID: $cid | Correct: '$correct_ans'";
        $correct[$cid] = $correct_ans;
        $total_questions++;
    }
    $q->close();

    file_put_contents('debug_log.txt', "Questions Found in DB ($total_questions):\n" . implode("\n", $debug_questions) . "\n\n", FILE_APPEND);

    // 5. Score calculation
    foreach ($student_answers as $qid => $ans) {
        if (!isset($correct[$qid])) continue;

        $stu = trim($ans);
        $cor = $correct[$qid];

        $stu_norm = preg_replace('/\s+/', '', $stu);
        $stu_norm = str_replace(['×','x','X','*'], '×', $stu_norm);
        $stu_norm = str_replace(['÷','/'], '÷', $stu_norm);
        $stu_norm = str_replace(['−','–','—','-'], '-', $stu_norm);

        $cor_norm = preg_replace('/\s+/', '', $cor);
        $cor_norm = str_replace(['×','x','X','*'], '×', $cor_norm);
        $cor_norm = str_replace(['÷','/'], '÷', $cor_norm);
        $cor_norm = str_replace(['−','–','—','-'], '-', $cor_norm);

        if ($stu_norm === $cor_norm && $stu_norm !== '') {
            $score++;
            file_put_contents('debug_log.txt', "MATCH! QID $qid: '$stu' === '$cor'\n", FILE_APPEND);
        } else {
            file_put_contents('debug_log.txt', "NO MATCH QID $qid: '$stu_norm' vs '$cor_norm'\n", FILE_APPEND);
        }
    }

    file_put_contents('debug_log.txt', "FINAL SCORE: $score / $total_questions\n=== SUBMIT END ===\n\n", FILE_APPEND);

    // 6. Save score
    $upd = $conn->prepare("UPDATE assessment_assignments SET score = ?, total_questions = ? WHERE assessment_id = ? AND student_id = ?");
    $upd->bind_param("iiii", $score, $total_questions, $ass_id, $student_id);
    $upd->execute();
    $upd->close();

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    file_put_contents('debug_log.txt', "ERROR: " . $e->getMessage() . "\n\n", FILE_APPEND);
    $score = 0;
    $total_questions = 0;
}

$conn->autocommit(true);
?>

<!-- HTML SUCCESS PAGE (same as before) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Successfully!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
      html,body{
        overflow-x:hidden;
        margin:0;
    }

body{
    background:linear-gradient(160deg, #1e3a8a, #2563eb);
    font-family:'Segoe UI',sans-serif;
}

.main-content{
    margin-left:260px;
    padding:40px;
    max-width:calc(100% - 260px);
}

.card{
    max-width:500px;
    margin:auto;
    border-radius:30px;
    overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,0.3);
}

.header{
    background: linear-gradient(45deg,#11998e,#38ef7d);
    padding:40px 0;
    text-align:center;
    color:white;
}

.header i{
    font-size:5.5rem;
    animation: beat 1.5s infinite;
}

.score{
    font-size:2rem;
    font-weight:bold;
    color:#fff;
}

@keyframes bounce{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-20px)}
}

.body{
    background:white;
    padding:40px;
    text-align:center;
}

.btn-home{
    background:linear-gradient(45deg,#667eea,#764ba2);
    color:white;
    padding:15px 40px;
    font-size:1.2rem;
    border-radius:50px;
    text-decoration:none;
}

.btn-home:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 30px rgba(102,126,234,0.4);
    color:white;
}

@media(max-width:768px){
    .main-content{
        margin-left:0;
        max-width:100%;
    }
}
    </style>
</head>
<body>
<div class="container main-content">
    <div class="card mt-4">

        <div class="header">
            <i class="fas fa-check-circle"></i>
            <h1 class="mt-3">Submitted Successfully!</h1>
            <div class="score">Your Score: <?= $score ?> / <?= $total_questions ?></div>
        </div>

        <div class="body">
            <h3>Well Done!</h3>
            <p>Your assessment has been graded instantly.</p>

            <a href="student_dashboard.php" class="btn-home">
                <i class="fas fa-home"></i> Back to Dashboard
            </a>
        </div>

    </div>
</div>
</body>
</html>