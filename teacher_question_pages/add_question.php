<?php
// DEBUG: Remove in production
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../teacher_login.php');
    exit();
}

/* -------------------------------------------------------------
   Keep teacher active
-------------------------------------------------------------- */
$teacher_id = $_SESSION['teacher_id'];
$now = date('Y-m-d H:i:s');
mysqli_query($conn, "UPDATE teachers SET last_activity = '$now' WHERE id = '$teacher_id'");

/* -------------------------------------------------------------
   Fetch all unique grades from subjects table
-------------------------------------------------------------- */
$grades = [];
$res = mysqli_query($conn, "SELECT DISTINCT grade FROM subjects WHERE grade IS NOT NULL AND grade <> '' ORDER BY grade ASC");
if ($res && mysqli_num_rows($res) > 0) {
    while ($r = mysqli_fetch_assoc($res)) {
        $grades[] = $r['grade'];
    }
}


/* -------------------------------------------------------------
   Fetch all subjects
-------------------------------------------------------------- */
$subjects = [];
$res = mysqli_query($conn, "SELECT id, subject_name FROM subjects ORDER BY subject_name ASC");
if ($res && mysqli_num_rows($res) > 0) {
    while ($r = mysqli_fetch_assoc($res)) {
        $subjects[] = $r;
    }
}

/* -------------------------------------------------------------
   All question types
-------------------------------------------------------------- */
/* -------------------------------------------------------------
   Fetch ENUM values dynamically for question_type
-------------------------------------------------------------- */
$question_types = [];
$res = mysqli_query($conn, "SHOW COLUMNS FROM quiz_questions LIKE 'question_type'");
if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    if (preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches)) {
        $question_types = explode("','", $matches[1]);
    }
}


/* -------------------------------------------------------------
   Handle form submission
-------------------------------------------------------------- */
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instruction_id   = (int)($_POST['instruction_id'] ?? 0);
    $question_text    = trim($_POST['question_text'] ?? '');
    $question_type    = trim($_POST['question_type'] ?? '');
    $correct_answer   = trim($_POST['correct_answer'] ?? '');
    $unit             = trim($_POST['unit'] ?? '');

    // === VALIDATION ===
    if (!$instruction_id) {
        $msg = "<div class='alert alert-danger mt-2'>Please select an Instruction.</div>";
        goto end_submit;
    }
    if (empty($question_type)) {
        $msg = "<div class='alert alert-danger mt-2'>Please select Question Type.</div>";
        goto end_submit;
    }

    // === IMAGE UPLOAD ===
    $question_image = '';
    if (!empty($_FILES['question_image']['name'])) {
        $upload_dir = "../uploads/questions/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_path = $upload_dir . time() . '_' . basename($_FILES["question_image"]["name"]);
        if (move_uploaded_file($_FILES["question_image"]["tmp_name"], $file_path)) {
            $question_image = $file_path;
        } else {
            $msg = "<div class='alert alert-danger mt-2'>Image upload failed.</div>";
            goto end_submit;
        }
    }

    // === GET extra[] fields correctly ===
    $extra = $_POST['extra'] ?? [];

    // === BUILD PAYLOAD ===
    $payload = [];
    if ($question_type === 'BODMAS') {
        $numbers = [];
        foreach ($extra as $k => $v) {
            if (preg_match('/^num(\d+)$/', $k, $m)) {
                $idx = (int)$m[1];
                $numbers[$idx] = trim($v);
            }
        }
        ksort($numbers);

        foreach ($numbers as $idx => $val) {
            if ($val !== '') {
                $payload["num$idx"] = $val;
            }
        }

        $payload['operator'] = $extra['operator'] ?? '+';

        // Validate: at least 2 numbers
        if (count($payload) < 3 || !isset($payload['num1'], $payload['num2'])) {
            $msg = "<div class='alert alert-danger mt-2'>BODMAS requires at least two numbers.</div>";
            goto end_submit;
        }
    } else {
        // Other question types
        switch ($question_type) {
            case 'fraction_diagram':
                $payload = [
                    'left' => $extra['left'] ?? '',
                    'right' => $extra['right'] ?? ''
                ];
                break;
            case 'fill_blank':
                $payload = ['text' => $extra['text'] ?? ''];
                break;
            case 'compare':
                $payload = [
                    'num1' => $extra['num1'] ?? '',
                    'num2' => $extra['num2'] ?? ''
                ];
                break;
            case 'long_division':
                $payload = [
                    'dividend' => $extra['dividend'] ?? '',
                    'divisor' => $extra['divisor'] ?? ''
                ];
                break;
            default:
                $payload = $extra;
                break;
        }
    }

    $payload_json = json_encode($payload, JSON_UNESCAPED_UNICODE);
    if ($payload_json === false) {
        $msg = "<div class='alert alert-danger mt-2'>Failed to encode question data.</div>";
        goto end_submit;
    }

    // === INSERT INTO DB ===
    $sql = "INSERT INTO quiz_questions
            (instruction_id, question_text, question_type, correct_answer, question_payload, question_image, unit)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $msg = "<div class='alert alert-danger mt-2'>DB Error: " . $conn->error . "</div>";
        goto end_submit;
    }

    $stmt->bind_param("issssss",
        $instruction_id, $question_text, $question_type,
        $correct_answer, $payload_json, $question_image, $unit
    );

    if ($stmt->execute()) {
        header("Location: manage_questions.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger mt-2'>Save failed: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
end_submit:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {margin:0; font-family:Arial, sans-serif;}
        .sidebar {width:220px; background:#2c3e50; color:#fff; padding:20px 10px; min-height:100vh; position:fixed; top:0; left:0; z-index:1000;}
        .sidebar h4 {text-align:center; margin-bottom:30px; font-size:1.2rem;}
        .sidebar a {display:block; color:#fff; padding:12px 15px; margin:6px 0; text-decoration:none; border-radius:6px; font-size:0.95rem; transition:background .2s;}
        .sidebar a:hover, .sidebar a.active {background:#34495e;}
        .sidebar a.active {background:#1a252f; font-weight:bold;}
        .main-content {margin-left:220px; padding:20px; background:#f7f7f7; min-height:100vh;}
        .dynamic-number {margin-bottom:8px;}
        .remove-num {cursor:pointer; color:#dc3545; font-weight:bold;}
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
    <h4 class="mb-3">Add New Question</h4>
    <hr>
    <?= $msg ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">

           <!-- Grade -->
<div class="col-md-6">
    <label class="form-label">Grade</label>
    <select name="grade" id="grade" class="form-select" required>
        <option value="">-- Select Grade --</option>
        <?php foreach ($grades as $g): ?>
            <option value="<?= htmlspecialchars($g) ?>"><?= htmlspecialchars($g) ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Subject -->
<div class="col-md-6">
    <label class="form-label">Subject</label>
    <select name="subject_id" id="subject_id" class="form-select" required>
        <option value="">-- Select Subject --</option>
    </select>
</div>


            <!-- Chapter -->
            <div class="col-md-6">
                <label class="form-label">Chapter</label>
                <select name="chapter_id" id="chapter_id" class="form-select" required>
                    <option value="">-- Select Chapter --</option>
                </select>
            </div>

            <!-- Topic -->
            <div class="col-md-6">
                <label class="form-label">Topic</label>
                <select name="topic_id" id="topic_id" class="form-select" required>
                    <option value="">-- Select Topic --</option>
                </select>
            </div>

            <!-- Instruction -->
            <div class="col-md-6">
                <label class="form-label">Instruction</label>
                <select name="instruction_id" id="instruction_id" class="form-select" required>
                    <option value="">-- Select Instruction --</option>
                </select>
            </div>

            <!-- Question Text -->
            <div class="col-md-12">
                <label class="form-label">Question Text (optional)</label>
                <textarea name="question_text" class="form-control" rows="2"></textarea>
            </div>

            <!-- Question Type -->
            <div class="col-md-6">
                <label class="form-label">Question Type</label>
                <select name="question_type" id="qtype" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    <?php foreach ($question_types as $t): ?>
                        <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Correct Answer -->
            <div class="col-md-6">
                <label class="form-label">Correct Answer</label>
                <input type="text" name="correct_answer" class="form-control" placeholder="e.g. 12345" required>
            </div>

            <!-- Dynamic Fields -->
            <div id="dynamic-fields" class="col-12 mt-2 p-3 border bg-light rounded">
                <em>Select a question type to see extra fields.</em>
            </div>

            <!-- Image -->
            <div class="col-md-6">
                <label class="form-label">Image (optional)</label>
                <input type="file" name="question_image" class="form-control" accept="image/*">
            </div>

            <!-- Unit -->
            <div class="col-md-6">
                <label class="form-label">Unit (optional)</label>
                <input type="text" name="unit" class="form-control" maxlength="10" placeholder="e.g. cm">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Question</button>
                <a href="manage_questions.php" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </form>
</div>

<!-- ==================== AJAX CASCADING DROPDOWNS ==================== -->
<script>
// When Grade changes -> load Subjects
$('#grade').change(function(){
    const grade = $(this).val();
    $('#subject_id').html('<option>Loading...</option>');
    $.get('fetch_subjects.php', { grade }, function(data){
        $('#subject_id').html(data);
        $('#chapter_id, #topic_id, #instruction_id').html('<option value="">-- Select --</option>');
    });
});

// When Subject changes -> load Chapters
$('#subject_id').change(function(){
    const sid = $(this).val();
    $('#chapter_id').html('<option>Loading...</option>');
    $.get('fetch_chapters.php', { subject_id: sid }, function(data){
        $('#chapter_id').html(data);
        $('#topic_id, #instruction_id').html('<option value="">-- Select --</option>');
    });
});

// When Chapter changes -> load Topics
$('#chapter_id').change(function(){
    const cid = $(this).val();
    $('#topic_id').html('<option>Loading...</option>');
    $.get('fetch_topics.php', { chapter_id: cid }, function(data){
        $('#topic_id').html(data);
        $('#instruction_id').html('<option value="">-- Select Instruction --</option>');
    });
});

// When Topic changes -> load Instructions
$('#topic_id').change(function(){
    const tid = $(this).val();
    $('#instruction_id').html('<option>Loading...</option>');
    $.get('fetch_instructions.php', { topic_id: tid }, function(data){
        $('#instruction_id').html(data);
    });
});

</script>

<!-- ==================== DYNAMIC FIELDS (BODMAS + OTHERS) ==================== -->
<script>
const dyn = $('#dynamic-fields');
const qtype = $('#qtype');
let counter = 2;

const templates = {
    'fraction_diagram': `
        <label>Left Fraction</label>
        <input type="text" name="extra[left]" class="form-control mb-2" placeholder="e.g. 1/2">
        <label>Right Fraction</label>
        <input type="text" name="extra[right]" class="form-control mb-2" placeholder="e.g. 3/4">
    `,
    'fill_blank': `
        <label>Fill Blank Text</label>
        <textarea name="extra[text]" class="form-control mb-2" placeholder="e.g. 5 + __ = 10"></textarea>
    `,
    'compare': `
        <label>Number 1</label><input type="text" name="extra[num1]" class="form-control mb-2">
        <label>Number 2</label><input type="text" name="extra[num2]" class="form-control mb-2">
    `,
    'long_division': `
        <label>Dividend</label><input type="text" name="extra[dividend]" class="form-control mb-2">
        <label>Divisor</label><input type="text" name="extra[divisor]" class="form-control mb-2">
    `,
    'BODMAS': `
        <div id="bodmas-container">
            <div class="d-flex align-items-center dynamic-number mb-2">
                <input type="text" name="extra[num1]" class="form-control me-2" placeholder="Number 1" required>
                <span class="remove-num" style="display:none;">X</span>
            </div>
            <div class="d-flex align-items-center dynamic-number mb-2">
                <input type="text" name="extra[num2]" class="form-control me-2" placeholder="Number 2" required>
                <span class="remove-num">X</span>
            </div>
        </div>
        <button type="button" id="add-number" class="btn btn-sm btn-outline-primary mb-2">+ Add Number</button>

        <label class="mt-3">Operator (between each pair)</label>
        <select name="extra[operator]" class="form-select" required>
            <option value="+">Addition (+)</option>
            <option value="-">Subtraction (-)</option>
            <option value="*">Multiplication (×)</option>
            <option value="/">Division (÷)</option>
        </select>
    `
};

qtype.on('change', function () {
    const type = $(this).val();
    if (type) {
    dyn.html('<em>Loading dynamic fields...</em>');
    $.get('fetch_payload_fields.php', { type }, function(data){
        dyn.html(data || `<em>No extra fields required for "${type}".</em>`);
    });
} else {
    dyn.html('<em>Select a question type to see extra fields.</em>');
}

    counter = 2;

    if (type === 'BODMAS') {
        $('#add-number').off('click').on('click', function () {
            counter++;
            const html = `
                <div class="d-flex align-items-center dynamic-number mb-2">
                    <input type="text" name="extra[num${counter}]" class="form-control me-2" placeholder="Number ${counter}" required>
                    <span class="remove-num">X</span>
                </div>`;
            $('#bodmas-container').append(html);
        });

        $(document).off('click', '.remove-num').on('click', '.remove-num', function () {
            if ($('#bodmas-container .dynamic-number').length <= 2) {
                alert('At least two numbers are required.');
                return;
            }
            $(this).closest('.dynamic-number').remove();
        });
    }
});
</script>

<!-- ==================== SIDEBAR ACTIVE ==================== -->
<script>
$(function () {
    $('.sidebar a[data-page*="add_question.php"]').addClass('active');
});
</script>
</body>
</html>