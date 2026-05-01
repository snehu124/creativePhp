<?php
$data = json_decode($q['question_payload'], true);

// Detect type from payload
$is_scientific  = isset($data['number']);
$is_exponential = isset($data['expression']);
$is_evaluate    = isset($data['variable']);

// ---------- STUDENT ANSWER ----------
$student_base  = '';
$student_power = '';

if (isset($_POST['answer'][$q['id']])) {
    $student_base  = trim($_POST['answer'][$q['id']]['base'] ?? '');
    $student_power = trim($_POST['answer'][$q['id']]['power'] ?? '');
} else {
    $student = json_decode($q['student_answer'] ?? '{}', true);
    $student_base  = trim($student['base'] ?? '');
    $student_power = trim($student['power'] ?? '');
}

// ---------- CORRECT ----------
$correct_parts = explode(',', $q['correct_answer']);
$correct_base  = trim($correct_parts[0] ?? '');
$correct_power = trim($correct_parts[1] ?? '');

// ---------- CHECK ----------
$is_correct = false;

// Evaluate case: only base check needed
if ($is_evaluate) {
    if ($student_base !== '' && floatval($student_base) == floatval($correct_base)) {
        $is_correct = true;
    }
} else {
    if ($student_base !== '' && $student_power !== '') {
        if (
            floatval($student_base) == floatval($correct_base) &&
            intval($student_power) == intval($correct_power)
        ) {
            $is_correct = true;
        }
    }
}

// Highlight
$cls = '';
if (isset($_POST['answer']) || isset($is_result_page)) {
    $cls = $is_correct ? 'correct' : 'wrong';
}
?>

<style>
.sn-box{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.sn-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:15px;
}

.sn-input{
    width:60px;
    border:none;
    border-bottom:2px solid #000;
    text-align:center;
    outline:none;
}

.correct{
    background:#d4edda;
    padding:6px;
    border-radius:6px;
}

.wrong{
    background:#f8d7da;
    padding:6px;
    border-radius:6px;
}

.badge{
    padding:4px 10px;
    border-radius:6px;
    color:#fff;
    font-size:13px;
    margin-left:10px;
}

.badge-correct{
    background:#28a745;
}

.badge-wrong{
    background:#dc3545;
}
</style>

<div class="sn-box">

    <div class="sn-title">
        <?= $char++; ?>)

        <?php if ($is_scientific): ?>
            Write in scientific notation
        <?php elseif ($is_exponential): ?>
            Write in exponential form
        <?php else: ?>
            Evaluate the expression
        <?php endif; ?>
    </div>

    <div>

        <!-- QUESTION -->
        <strong>
            <?php if ($is_scientific): ?>
                <?= htmlspecialchars($data['number']) ?>

            <?php elseif ($is_exponential): ?>
                <?= htmlspecialchars($data['expression']) ?>

            <?php else: ?>
                <?= $data['variable'] ?><sup><?= $data['power'] ?></sup>
                if <?= $data['variable'] ?> = <?= $data['value'] ?>
            <?php endif; ?>
        </strong>

        <!-- INPUT -->
        <div class="<?= $cls ?>" style="margin-top:10px;">

            <?php if ($is_scientific): ?>

                <input type="text" name="answer[<?= $q['id'] ?>][base]" value="<?= htmlspecialchars($student_base) ?>" class="sn-input">
                × 10<sup>
                    <input type="text" name="answer[<?= $q['id'] ?>][power]" value="<?= htmlspecialchars($student_power) ?>" class="sn-input" style="width:40px;">
                </sup>

            <?php elseif ($is_exponential): ?>

                <input type="text" name="answer[<?= $q['id'] ?>][base]" value="<?= htmlspecialchars($student_base) ?>" class="sn-input">
                <sup>
                    <input type="text" name="answer[<?= $q['id'] ?>][power]" value="<?= htmlspecialchars($student_power) ?>" class="sn-input" style="width:40px;">
                </sup>

            <?php else: ?>

                <input type="text" name="answer[<?= $q['id'] ?>][base]" value="<?= htmlspecialchars($student_base) ?>" class="sn-input">

            <?php endif; ?>

            <!-- RESULT -->
            <?php if (isset($_POST['answer']) || isset($is_result_page)): ?>
                <?php if ($is_correct): ?>
                    <span class="badge badge-correct">Correct</span>
                <?php else: ?>
                    <span class="badge badge-wrong">Wrong</span>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <!-- CORRECT -->
        <?php if ((isset($_POST['answer']) || isset($is_result_page)) && !$is_correct): ?>
            <div style="margin-top:8px; color:green;">
                Correct Answer:

                <?php if ($is_scientific): ?>
                    <?= $correct_base ?> × 10<sup><?= $correct_power ?></sup>

                <?php elseif ($is_exponential): ?>
                    <?= $correct_base ?><sup><?= $correct_power ?></sup>

                <?php else: ?>
                    <?= $correct_base ?>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>

</div>