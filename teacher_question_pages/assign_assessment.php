<?php
session_start();
include '../db_config.php';
// ================== AUTH CHECK ==================
if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../teacher_login.php');
    exit();
}

$teacher_id = (int)$_SESSION['teacher_id'];
$msg = "";

// ================== FETCH GRADES ==================
$grades = [];
$res = mysqli_query($conn, "SELECT DISTINCT grade FROM subjects WHERE grade IS NOT NULL AND grade != '' ORDER BY CAST(grade AS UNSIGNED)");
while ($r = mysqli_fetch_assoc($res)) {
    $grades[] = $r['grade'];
}

// ================== FETCH STUDENTS ==================
$students = [];
$stmt = $conn->prepare("
    SELECT id,
           TRIM(CONCAT(
               COALESCE(first_name, ''),
               IF(first_name IS NOT NULL AND last_name IS NOT NULL, ' ', ''),
               COALESCE(last_name, '')
           )) AS name
    FROM students
    ORDER BY first_name, last_name, id
");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $name = !empty($row['name']) ? $row['name'] : 'Student #' . $row['id'];
    $students[] = ['id' => $row['id'], 'name' => $name];
}
$stmt->close();

// ================== FORM SUBMISSION ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Basic fields
    $title          = trim($_POST['title'] ?? '');
    $description    = trim($_POST['description'] ?? '');
    $due_date       = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    $time_limit     = max(5, (int)($_POST['time_limit'] ?? 30));
    $allow_retake   = isset($_POST['allow_retake']) ? 1 : 0;
    $topic_id       = !empty($_POST['topic_id']) ? (int)$_POST['topic_id'] : null;
    $selected_questions = $_POST['questions'] ?? [];
    $student_ids    = $_POST['student_ids'] ?? [];

    // === VALIDATION ===
    if (empty($title)) {
        $msg = "<div class='alert alert-danger mt-3'>Assessment title is required!</div>";
        goto end_submit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // 1. INSERT ASSESSMENT
        $sql = "INSERT INTO assessments 
                (teacher_id, title, description, topic_id, due_date, time_limit_minutes, allow_retake)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("issisii",
            $teacher_id,
            $title,
            $description,
            $topic_id,
            $due_date,
            $time_limit,
            $allow_retake
        );

        if (!$stmt->execute()) {
            throw new Exception("Insert assessment failed: " . $stmt->error);
        }
        $assessment_id = $conn->insert_id;
        $stmt->close();

        // 2. INSERT QUESTIONS
        if ($topic_id && empty($selected_questions)) {
            // Auto-include all questions from the selected topic
            $qsel = $conn->prepare("
                SELECT qq.id
                FROM quiz_questions qq
                JOIN instructions i ON qq.instruction_id = i.id
                WHERE i.topic_id = ?
                ORDER BY qq.id
            ");
            $qsel->bind_param("i", $topic_id);
            $qsel->execute();
            $qres = $qsel->get_result();

            $qinsert = $conn->prepare("INSERT INTO assessment_questions (assessment_id, question_id, question_order) VALUES (?, ?, ?)");
            if (!$qinsert) throw new Exception("Prepare question insert failed");

            $order = 1;
            while ($row = $qres->fetch_assoc()) {
                $qid = (int)$row['id'];
                $qinsert->bind_param("iii", $assessment_id, $qid, $order);
                $qinsert->execute();
                $order++;
            }
            $qinsert->close();
            $qsel->close();
        } elseif (!empty($selected_questions)) {
            // Manual selection
            $qstmt = $conn->prepare("INSERT INTO assessment_questions (assessment_id, question_id, question_order) VALUES (?, ?, ?)");
            if (!$qstmt) throw new Exception("Prepare manual questions failed");

            foreach ($selected_questions as $index => $qid) {
                $qid = (int)$qid;
                $order = $index + 1;
                $qstmt->bind_param("iii", $assessment_id, $qid, $order);
                $qstmt->execute();
            }
            $qstmt->close();
        }

        // 3. ASSIGN TO STUDENTS (if any)
        if (!empty($student_ids)) {
            $assign_stmt = $conn->prepare("INSERT INTO assessment_assignments (assessment_id, student_id) VALUES (?, ?)");
            if (!$assign_stmt) throw new Exception("Prepare assignment failed");

            foreach ($student_ids as $sid) {
                $sid = (int)$sid;
                $assign_stmt->bind_param("ii", $assessment_id, $sid);
                $assign_stmt->execute();
            }
            $assign_stmt->close();
        }

        // Everything went fine → commit
        $conn->commit();

        // Success → redirect
        header("Location: manage_assessments.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $msg = "<div class='alert alert-danger mt-3'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

end_submit:
?>
<?php include 'sidebar.php'; ?>
<div class="main-content">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
        /* ==== PERMANENT FIX: No extra margin ever ==== */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
            background: #f7f7f7;
        }

        /* BODY KO HI SHIFT KARO - SABSE SAFE AUR CLEAN TAREEKA */
        body {
            padding-left: 220px;   /* ← Ye ek line sab fix karti hai */
            box-sizing: border-box;
        }

        /* Sidebar fixed left pe */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            background: #2c3e50;
            color: #fff;
            padding: 20px 10px;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.2rem;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px 15px;
            margin: 6px 0;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #34495e;
        }

        .sidebar a.active {
            background: #1a252f;
            font-weight: bold;
        }

        /* Main content bilkul normal - koi margin-left nahi */
        .main-content {
            padding: 20px;
            min-height: 100vh;
        }

        /* Container full width */
        .main-content .container {
            max-width: none;
            padding-left: 15px;
            padding-right: 15px;
        }

        .checkbox-list label {
            cursor: pointer;
            display: block;
            padding: 8px 12px;
            margin: 2px 0;
            border-radius: 6px;
        }
        .checkbox-list label:hover { background: #e9ecef; }
        .checkbox-list input[type=checkbox] { margin-right: 10px; }
    </style>

<div class="container p-4">
    <div class="card">
        <div class="card-header bg-primary text-white text-center py-4">
            <h3 class="mb-0">Create New Assessment</h3>
        </div>
        <div class="card-body p-5">
            <?= $msg ?>
            <form method="POST">
                <div class="row g-4">
                    <!-- TITLE & DUE DATE -->
                    <div class="col-lg-8">
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="Assessment Title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                    </div>
                    <div class="col-lg-4">
                        <input type="datetime-local" name="due_date" class="form-control form-control-lg" value="<?= htmlspecialchars($_POST['due_date'] ?? '') ?>">
                        <small class="text-muted">Optional due date</small>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="col-12">
                        <textarea name="description" class="form-control" rows="3" placeholder="Description (optional)"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>

                    <!-- OPTIONS -->
                    <div class="col-md-4">
                        <input type="number" name="time_limit" class="form-control" min="5" value="<?= $time_limit ?? 30 ?>">
                        <small class="text-muted">Time limit (minutes, min 5)</small>
                    </div>
                    <div class="col-md-4 d-flex align-items-center mt-3">
                        <div class="form-check">
                            <input type="checkbox" name="allow_retake" class="form-check-input" <?= isset($_POST['allow_retake']) ? 'checked' : 'checked' ?>>
                            <label class="form-check-label">Allow Retake</label>
                        </div>
                    </div>

                    <hr class="my-5">

                    <!-- CASCADING DROPDOWNS -->
                    <div class="col-md-3">
                        <select id="grade" class="form-select" required>
                            <option value="">-- Grade --</option>
                            <?php foreach($grades as $g): ?>
                                <option value="<?= $g ?>" <?= (isset($_POST['grade']) && $_POST['grade'] == $g) ? 'selected' : '' ?>>Grade <?= $g ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3"><select id="subject_id" class="form-select"><option>-- Subject --</option></select></div>
                    <div class="col-md-3"><select id="chapter_id" class="form-select"><option>-- Chapter --</option></select></div>
                    <div class="col-md-3">
                        <select name="topic_id" id="topic_id" class="form-select">
                            <option value="">-- Topic (Auto Include All Questions) --</option>
                        </select>
                    </div>

                    <!-- QUESTION LIST -->
                    <div class="col-12 mt-4" id="question-list">
                        <em>Select a topic above to load questions (or leave blank to manually select later).</em>
                    </div>

                    <hr class="my-5">

                    <!-- ASSIGN STUDENTS -->
                    <div class="col-12">
                        <h5>Assign to Students <small class="text-muted">(optional)</small></h5>
                        <div class="checkbox-list border p-3 rounded bg-light" style="max-height:300px; overflow-y:auto;">
                            <?php foreach($students as $s): ?>
                                <label class="d-block p-2">
                                    <input type="checkbox" name="student_ids[]" value="<?= $s['id'] ?>">
                                    <?= htmlspecialchars($s['name']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <small class="text-muted">Leave blank = create assessment without assigning</small>
                    </div>

                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Create & Assign Assessment</button>
                        <a href="manage_assessments.php" class="btn btn-secondary btn-lg px-5">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================== AJAX CASCADING & QUESTIONS ================== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $('#grade').change(function(){
        let g = $(this).val();
        $('#subject_id').html('<option>Loading...</option>');
        $.get('fetch_subjects.php',{grade:g},function(d){
            $('#subject_id').html('<option value="">-- Subject --</option>'+d);
            $('#chapter_id,#topic_id').html('<option value="">-- Select --</option>');
            $('#question-list').html('<em>Select a topic to load questions.</em>');
        });
    });

    $('#subject_id').change(function(){
        let s = $(this).val();
        $('#chapter_id').html('<option>Loading...</option>');
        $.get('fetch_chapters.php',{subject_id:s},function(d){
            $('#chapter_id').html('<option value="">-- Chapter --</option>'+d);
            $('#topic_id').html('<option value="">-- Topic --</option>');
        });
    });

    $('#chapter_id').change(function(){
        let c = $(this).val();
        $('#topic_id').html('<option>Loading...</option>');
        $.get('fetch_topics.php',{chapter_id:c},function(d){
            $('#topic_id').html('<option value="">-- Topic (Auto Include All) --</option>'+d);
        });
    });

    $('#topic_id').change(function(){
        let t = $(this).val();
        if(!t){
            $('#question-list').html('<em>No topic selected – you can manually pick questions after creation if needed.</em>');
            return;
        }
        $('#question-list').html('<div class="text-center"><div class="spinner-border text-primary"></div> Loading questions...</div>');
        $.get('fetch_questions_for_assessment.php',{topic_id:t},function(d){
            $('#question-list').html(d || '<em>No questions found for this topic.</em>');
        }).fail(()=>$('#question-list').html('<em class="text-danger">Failed to load questions.</em>'));
    });
});
</script>
</div>
</body>
</html>