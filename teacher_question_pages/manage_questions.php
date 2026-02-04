<?php
session_start();
include '../db_config.php';
if (!isset($_SESSION['teacher_id'])) {
    exit('Unauthorized access.');
}

// Fetch all grades for dropdown
$grades = [];
$res_grade = mysqli_query($conn, "
    SELECT DISTINCT grade 
    FROM subjects 
    WHERE grade IS NOT NULL AND grade != ''
    ORDER BY CAST(grade AS UNSIGNED)
");
if ($res_grade) {
    while ($row = mysqli_fetch_assoc($res_grade)) {
        $grades[] = $row['grade'];
    }
}

/* Fetch all subjects for dropdown */
$subjects = [];
$res_sub = mysqli_query($conn, "SELECT id, subject_name FROM subjects ORDER BY subject_name ASC");
if ($res_sub) {
    while ($row = mysqli_fetch_assoc($res_sub)) {
        $subjects[] = $row;
    }
}

/* Build dynamic query based on filters */
$where = [];
$params = [];
$types = '';

if (!empty($_GET['grade'])) {
    $where[] = "s.grade = ?";
    $params[] = $_GET['grade'];
    $types .= 'i';
}
if (!empty($_GET['subject_id'])) {
    $where[] = "s.id = ?";
    $params[] = $_GET['subject_id'];
    $types .= 'i';
}
if (!empty($_GET['chapter_id'])) {
    $where[] = "c.id = ?";
    $params[] = $_GET['chapter_id'];
    $types .= 'i';
}
if (!empty($_GET['topic_id'])) {
    $where[] = "t.id = ?";
    $params[] = $_GET['topic_id'];
    $types .= 'i';
}
if (!empty($_GET['instruction_id'])) {
    $where[] = "i.id = ?";
    $params[] = $_GET['instruction_id'];
    $types .= 'i';
}

$where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$q = "
SELECT q.id, q.question_text, q.question_type, q.unit,
       i.instruction, t.title AS topic, c.chapter_name, s.subject_name
FROM quiz_questions q
LEFT JOIN instructions i ON q.instruction_id = i.id
LEFT JOIN topics t ON i.topic_id = t.id
LEFT JOIN chapters c ON t.chapter_id = c.id
LEFT JOIN subjects s ON c.subject_id = s.id
$where_clause
ORDER BY q.id DESC
";

$res = mysqli_prepare($conn, $q);
if ($params) {
    $res->bind_param($types, ...$params);
}
$res->execute();
$result = $res->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Questions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: row; }
        body > div:first-child { flex: 0 0 220px; }
        .main-content { flex: 1; min-height: 100vh; box-sizing: border-box; padding: 20px; background: #f7f7f7; }
        .filter-box { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .col-md-3 {
        flex: 0 0 auto;
        width: 20%;
    }
    </style>
</head>
<body style="margin:0; font-family:Arial, sans-serif;">
    <?php include 'sidebar.php'; ?>

    <div class="main-content" style="margin-left:220px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Manage Questions</h4>
            <a href="/teacher_question_pages/add_question.php" class="btn btn-success">Add New Question</a>
        </div>

        <!-- Filter Section -->
        <div class="filter-box">
            <form id="filter-form" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Grade</label>
                    <select name="grade" id="grade" class="form-select">
                        <option value="">-- All Grades --</option>
                        <?php foreach ($grades as $g): ?>
                            <option value="<?= $g ?>" <?= (!empty($_GET['grade']) && $_GET['grade'] == $g) ? 'selected' : '' ?>>
                                Grade <?= $g ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">-- All Subjects --</option>
                        <?php foreach ($subjects as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= (!empty($_GET['subject_id']) && $_GET['subject_id'] == $s['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['subject_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Chapter</label>
                    <select name="chapter_id" id="chapter_id" class="form-select">
                    <option value="">-- All Chapters --</option>
                    <?php
                    if (!empty($_GET['subject_id'])) {
                        $sid = (int)$_GET['subject_id'];
                        $chap = mysqli_query($conn, "SELECT id, chapter_name FROM chapters WHERE subject_id=$sid ORDER BY chapter_name");
                        while ($c = mysqli_fetch_assoc($chap)) {
                            $sel = (!empty($_GET['chapter_id']) && $_GET['chapter_id'] == $c['id']) ? 'selected' : '';
                            echo '<option value="'.$c['id'].'" '.$sel.'>'.$c['chapter_name'].'</option>';
                        }
                    }
                    ?>
                </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Topic</label>
                   <select name="topic_id" id="topic_id" class="form-select">
                    <option value="">-- All Topics --</option>
                    <?php
                    if (!empty($_GET['chapter_id'])) {
                        $cid = (int)$_GET['chapter_id'];
                        $top = mysqli_query($conn, "SELECT id, title FROM topics WHERE chapter_id=$cid ORDER BY title");
                        while ($t = mysqli_fetch_assoc($top)) {
                            $sel = (!empty($_GET['topic_id']) && $_GET['topic_id'] == $t['id']) ? 'selected' : '';
                            echo '<option value="'.$t['id'].'" '.$sel.'>'.$t['title'].'</option>';
                        }
                    }
                    ?>
                </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Instruction</label>
                        <select name="instruction_id" id="instruction_id" class="form-select">
                            <option value="">-- All Instructions --</option>
                            <?php
                            if (!empty($_GET['topic_id'])) {
                                $tid = (int)$_GET['topic_id'];
                                $ins = mysqli_query($conn, "SELECT id, instruction FROM instructions WHERE topic_id=$tid ORDER BY instruction");
                                while ($i = mysqli_fetch_assoc($ins)) {
                                    $sel = (!empty($_GET['instruction_id']) && $_GET['instruction_id'] == $i['id']) ? 'selected' : '';
                                    echo '<option value="'.$i['id'].'" '.$sel.'>'.$i['instruction'].'</option>';
                                }
                            }
                            ?>
                        </select>
                </div>
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="manage_questions.php" class="btn btn-secondary btn-sm">Clear</a>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Sr. No.</th>
                        <th>Subject</th>
                        <th>Chapter</th>
                        <th>Topic</th>
                        <th>Instruction</th>
                        <th>Type</th>
                        <th>Unit</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody id="questions-table-body">
                    <?php if ($result->num_rows > 0): ?>
                        <?php $sr = 1; while ($r = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $sr++ ?></td>
                                <td><?= htmlspecialchars($r['subject_name'] ?: '-') ?></td>
                                <td><?= htmlspecialchars($r['chapter_name'] ?: '-') ?></td>
                                <td><?= htmlspecialchars($r['topic'] ?: '-') ?></td>
                                <td><?= htmlspecialchars($r['instruction'] ?: '-') ?></td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?= htmlspecialchars($r['question_type']) ?></span>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($r['unit'] ?: '-') ?></td>
                                <td class="text-center">
                                    <a href="/teacher_question_pages/view_question.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="/teacher_question_pages/edit_question.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteQuestion(<?= $r['id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">No questions found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Script -->
    <script>
        function deleteQuestion(id) {
            if (confirm("Are you sure you want to delete this question?")) {
                $.post('/teacher_question_pages/delete_question.php', { id: id }, function(res) {
                    alert(res.trim());
                    location.reload();
                }).fail(function() {
                    alert('Failed to delete question.');
                });
            }
        }
    </script>

    <!-- Cascading Dropdowns & Filtering -->
    <script>
    $(document).ready(function() {
        // Load Subjects when Grade changes
        $('#grade').change(function () {
            const grade = $(this).val();
            $('#subject_id, #chapter_id, #topic_id, #instruction_id').html('<option>Loading...</option>');
        
            $.get('fetch_subjects.php', { grade: grade }, function (data) {
                $('#subject_id').html('<option value="">-- All Subjects --</option>' + data);
                $('#chapter_id').html('<option value="">-- All Chapters --</option>');
                $('#topic_id').html('<option value="">-- All Topics --</option>');
                $('#instruction_id').html('<option value="">-- All Instructions --</option>');
            });
        });

        // Load Chapters
        $('#subject_id').change(function() {
            const sid = $(this).val();
            $('#chapter_id, #topic_id, #instruction_id').html('<option value="">-- Loading... --</option>');
            if (!sid) {
                $('#chapter_id').html('<option value="">-- All Chapters --</option>');
                $('#topic_id').html('<option value="">-- All Topics --</option>');
                $('#instruction_id').html('<option value="">-- All Instructions --</option>');
                return;
            }
            $.get('fetch_chapters.php', {subject_id: sid}, function(data) {
                $('#chapter_id').html('<option value="">-- All Chapters --</option>' + data);
                $('#topic_id').html('<option value="">-- All Topics --</option>');
                $('#instruction_id').html('<option value="">-- All Instructions --</option>');
            });
        });

        // Load Topics
        $('#chapter_id').change(function() {
            const cid = $(this).val();
            $('#topic_id, #instruction_id').html('<option value="">-- Loading... --</option>');
            if (!cid) {
                $('#topic_id').html('<option value="">-- All Topics --</option>');
                $('#instruction_id').html('<option value="">-- All Instructions --</option>');
                return;
            }
            $.get('fetch_topics.php', {chapter_id: cid}, function(data) {
                $('#topic_id').html('<option value="">-- All Topics --</option>' + data);
                $('#instruction_id').html('<option value="">-- All Instructions --</option>');
            });
        });

        // Load Instructions
        $('#topic_id').change(function() {
            const tid = $(this).val();
            $('#instruction_id').html('<option value="">-- Loading... --</option>');
            if (!tid) {
                $('#instruction_id').html('<option value="">-- All Instructions --</option>');
                return;
            }
            $.get('fetch_instructions.php', {topic_id: tid}, function(data) {
                $('#instruction_id').html('<option value="">-- All Instructions --</option>' + data);
            });
        });

        // Trigger initial load if filters are pre-selected
        <?php if (!empty($_GET['subject_id'])): ?>
            $('#subject_id').trigger('change');
            <?php if (!empty($_GET['chapter_id'])): ?>
                setTimeout(() => $('#chapter_id').val('<?= $_GET['chapter_id'] ?>').trigger('change'), 300);
                <?php if (!empty($_GET['topic_id'])): ?>
                    setTimeout(() => $('#topic_id').val('<?= $_GET['topic_id'] ?>').trigger('change'), 600);
                    <?php if (!empty($_GET['instruction_id'])): ?>
                        setTimeout(() => $('#instruction_id').val('<?= $_GET['instruction_id'] ?>'), 900);
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        // Submit filter via GET
        $('#filter-form').submit(function(e) {
            e.preventDefault();
            const params = $(this).serialize();
            window.location = 'manage_questions.php?' + params;
        });
    });
    </script>
</body>
</html>