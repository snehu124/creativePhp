<?php
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

$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    exit('Invalid ID');
}

// Fetch question
$stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    exit('Question not found.');
}
$data = $res->fetch_assoc();
$payload = json_decode($data['question_payload'], true) ?? [];

/* -------------------------------------------------------------
   All question types (same as add)
-------------------------------------------------------------- */
$question_types = [
    'display_angles','fill_blank','fill_blank2','compare','compare2','BODMAS','long_division',
    'fill_blank_underline','fill_blank_models','order_arrange','bodmas_fill_blank',
    'fraction_diagram','fraction_fill_diagram','fraction_improper','equation_missing',
    'equation_diagram','equation_volume','angles_classification','types_angles','polygons_intro',
    'color_prisms_pyramids','question_renderer','complete_table','match_nets','money_question_renderer',
    'money_addsub','picture_money_word','fraction_mixed_to_improper','fraction_mixed_to_improper_fill',
    'fraction_order_diagram'
];

/* -------------------------------------------------------------
   Handle form submission
-------------------------------------------------------------- */
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_text   = trim($_POST['question_text'] ?? '');
    $question_type   = trim($_POST['question_type'] ?? '');
    $correct_answer  = trim($_POST['correct_answer'] ?? '');
    $unit            = trim($_POST['unit'] ?? '');

    // === IMAGE UPLOAD (keep old if no new) ===
    $question_image = $data['question_image'];
    if (!empty($_FILES['question_image']['name'])) {
        $upload_dir = "../uploads/questions/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_path = $upload_dir . time() . '_' . basename($_FILES["question_image"]["name"]);
        if (move_uploaded_file($_FILES["question_image"]["tmp_name"], $file_path)) {
            $question_image = $file_path;
            // Optional: delete old image
            if ($data['question_image'] && file_exists($data['question_image'])) {
                @unlink($data['question_image']);
            }
        } else {
            $msg = '<div class="alert alert-danger">Image upload failed.</div>';
            goto end_submit;
        }
    }

    // === GET extra[] fields ===
    $extra = $_POST['extra'] ?? [];

    // === BUILD PAYLOAD (same logic as add_question.php) ===
    $new_payload = [];
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
                $new_payload["num$idx"] = $val;
            }
        }
        $new_payload['operator'] = $extra['operator'] ?? '+';

        if (count($new_payload) < 3 || !isset($new_payload['num1'], $new_payload['num2'])) {
            $msg = '<div class="alert alert-danger">BODMAS requires at least two numbers.</div>';
            goto end_submit;
        }
    } else {
        switch ($question_type) {
            case 'fraction_diagram':
                $new_payload = [
                    'left' => $extra['left'] ?? '',
                    'right' => $extra['right'] ?? ''
                ];
                break;
            case 'fill_blank':
                $new_payload = ['text' => $extra['text'] ?? ''];
                break;
            case 'compare':
                $new_payload = [
                    'num1' => $extra['num1'] ?? '',
                    'num2' => $extra['num2'] ?? ''
                ];
                break;
            case 'long_division':
                $new_payload = [
                    'dividend' => $extra['dividend'] ?? '',
                    'divisor' => $extra['divisor'] ?? ''
                ];
                break;
            default:
                $new_payload = $extra;
                break;
        }
    }

    $payload_json = json_encode($new_payload, JSON_UNESCAPED_UNICODE);
    if ($payload_json === false) {
        $msg = '<div class="alert alert-danger">Failed to encode payload.</div>';
        goto end_submit;
    }

    // === UPDATE DB ===
    $stmt = $conn->prepare("
        UPDATE quiz_questions SET
        question_text = ?, question_type = ?, correct_answer = ?,
        question_payload = ?, question_image = ?, unit = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        "ssssssi",
        $question_text, $question_type, $correct_answer,
        $payload_json, $question_image, $unit, $id
    );

    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Question updated successfully!</div>';
        // Refresh $data
        $data['question_text'] = $question_text;
        $data['question_type'] = $question_type;
        $data['correct_answer'] = $correct_answer;
        $data['unit'] = $unit;
        $data['question_image'] = $question_image;
        $payload = $new_payload; // update for form
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}
end_submit:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question #<?= $id ?></title>
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
    <h4>Edit Question #<?= $id ?></h4>
    <hr>
    <?= $msg ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">

            <!-- Question Text -->
            <div class="col-12">
                <label class="form-label">Question Text</label>
                <textarea name="question_text" class="form-control" rows="3"><?= htmlspecialchars($data['question_text']) ?></textarea>
            </div>

            <!-- Question Type (SELECT - same as add) -->
            <div class="col-md-6">
                <label class="form-label">Question Type</label>
                <select name="question_type" id="qtype" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    <?php foreach ($question_types as $t): ?>
                        <option value="<?= htmlspecialchars($t) ?>" <?= $data['question_type'] === $t ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Correct Answer -->
            <div class="col-md-6">
                <label class="form-label">Correct Answer</label>
                <input type="text" name="correct_answer" class="form-control"
                       value="<?= htmlspecialchars($data['correct_answer']) ?>" required>
            </div>

            <!-- Unit -->
            <div class="col-md-6">
                <label class="form-label">Unit (e.g. cm, kg)</label>
                <input type="text" name="unit" class="form-control"
                       value="<?= htmlspecialchars($data['unit']) ?>" maxlength="10">
            </div>

            <!-- Current Image -->
            <div class="col-md-6">
                <label class="form-label">Current Image</label><br>
                <?php if (!empty($data['question_image'])): ?>
                    <img src="<?= htmlspecialchars($data['question_image']) ?>" class="img-thumbnail mb-2" style="max-width:150px;">
                    <br>
                <?php endif; ?>
                <input type="file" name="question_image" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep current image.</small>
            </div>

            <!-- Dynamic Extra Fields -->
            <div class="col-12 mt-3" id="dynamic-fields">
                <em class="text-muted">Select question type to load extra fields.</em>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Update Question</button>
                <a href="manage_questions.php" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </form>
</div>

<!-- ==================== DYNAMIC FIELDS (BODMAS + OTHERS) ==================== -->
<script>
const dyn = $('#dynamic-fields');
const qtypeSelect = $('#qtype');
let counter = 0;

// Escape PHP values for JS
const payload = <?= json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

const templates = {
    'fraction_diagram': () => `
        <label>Left Fraction</label>
        <input type="text" name="extra[left]" class="form-control mb-2" value="${payload.left || ''}">
        <label>Right Fraction</label>
        <input type="text" name="extra[right]" class="form-control mb-2" value="${payload.right || ''}">
    `,
    'fill_blank': () => `
        <label>Fill-Blank Text</label>
        <textarea name="extra[text]" class="form-control mb-2">${payload.text || ''}</textarea>
    `,
    'compare': () => `
        <label>Number 1</label>
        <input type="text" name="extra[num1]" class="form-control mb-2" value="${payload.num1 || ''}">
        <label>Number 2</label>
        <input type="text" name="extra[num2]" class="form-control mb-2" value="${payload.num2 || ''}">
    `,
    'long_division': () => `
        <label>Dividend</label>
        <input type="text" name="extra[dividend]" class="form-control mb-2" value="${payload.dividend || ''}">
        <label>Divisor</label>
        <input type="text" name="extra[divisor]" class="form-control mb-2" value="${payload.divisor || ''}">
    `,
    'BODMAS': () => {
        let html = '<div id="bodmas-container">';
        counter = 0;

        // Add existing numbers
        for (const [key, val] of Object.entries(payload)) {
            if (key.startsWith('num')) {
                counter = Math.max(counter, parseInt(key.replace('num', '')));
                const removable = counter >= 2 ? '' : 'style="display:none;"';
                html += `
                    <div class="d-flex align-items-center dynamic-number mb-2">
                        <input type="text" name="extra[${key}]" class="form-control me-2" placeholder="Number ${counter}" value="${val}" required>
                        <span class="remove-num" ${removable}>X</span>
                    </div>`;
            }
        }

        // Ensure at least 2
        while (counter < 2) {
            counter++;
            const removable = counter >= 2 ? '' : 'style="display:none;"';
            html += `
                <div class="d-flex align-items-center dynamic-number mb-2">
                    <input type="text" name="extra[num${counter}]" class="form-control me-2" placeholder="Number ${counter}" required>
                    <span class="remove-num" ${removable}>X</span>
                </div>`;
        }

        html += `</div>
        <button type="button" id="add-number" class="btn btn-sm btn-outline-primary mb-2">+ Add Number</button>
        <label class="mt-3">Operator</label>
        <select name="extra[operator]" class="form-select" required>
            <option value="+" ${payload.operator === '+' ? 'selected' : ''}>Addition (+)</option>
            <option value="-" ${payload.operator === '-' ? 'selected' : ''}>Subtraction (-)</option>
            <option value="*" ${payload.operator === '*' ? 'selected' : ''}>Multiplication (×)</option>
            <option value="/" ${payload.operator === '/' ? 'selected' : ''}>Division (÷)</option>
        </select>`;

        return html;
    }
};

function renderFields() {
    const type = qtypeSelect.val();
    if (templates[type]) {
        dyn.html(templates[type]());
        if (type === 'BODMAS') setupBODMAS();
    } else {
        dyn.html(`<em class="text-muted">No extra fields for "${type}".</em>`);
    }
}

function setupBODMAS() {
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

// Initial render
renderFields();
qtypeSelect.on('change', renderFields);
</script>

<!-- ==================== SIDEBAR ACTIVE ==================== -->
<script>
$(function () {
    $('.sidebar a[data-page*="edit_question.php"]').addClass('active');
});
</script>
</body>
</html>