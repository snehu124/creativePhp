<?php
// Decode question data
$data = json_decode($q['question_payload'], true);
$mode = $data['mode'] ?? null;

// Image
$image_path = $q['question_image'] ?? '';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'];
$base_path = "/Student_dashboard/";
$final_image_path = $protocol . "://" . $domain . $base_path . ltrim($image_path, '/');
?>

<style>


.question-row {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 20px;
    flex-wrap: wrap;
}

.answer-group {
    flex: 1 1 250px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.answer-line {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
}

.quiz-input {
    min-width: 120px;
    max-width: 250px;
    padding: 6px 4px;
    font-size: 15px;
    border: none;
    border-bottom: 2px solid #ccc;
    background: transparent;
    outline: none;
    transition: border-color 0.3s;
}

.quiz-input:focus {
    border-bottom-color: #1F669C;
}

.question-image {
    flex: 0 0 auto;
    max-width: 180px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

h6 {
    margin-bottom: 12px;
}

@media (max-width: 768px) {
    .question-row {
        flex-direction: column;
        align-items: flex-start;
    }
    .question-image {
        max-width: 100%;
        margin-bottom: 10px;
    }
}
</style>
<?php if ($mode === 'single'): ?>

<!-- ================= SINGLE MODE ================= -->
<div class="quiz-box mb-4">
    <p class="fw-bold">(<?= $char ?>)</p>


    <div class="question-row">
        <?php if ($image_path): ?>
            <img src="<?= htmlspecialchars($final_image_path) ?>" class="question-image">
        <?php endif; ?>

        <div class="answer-group">
            <div class="answer-line">
                <strong><?= htmlspecialchars($data['fraction'] ?? '') ?></strong>
                of
                <strong><?= htmlspecialchars($data['of'] ?? '') ?></strong>
                =
                <input type="text" name="answer[<?= $q['id'] ?>]" class="quiz-input">
            </div>
        </div>
    </div>
</div>
<?php $char++; ?>

<?php elseif ($mode === 'double'): ?>

<!-- ================= DOUBLE MODE ================= -->
<div class="quiz-box mb-4">
    <p class="fw-bold">(<?= $char ?>)</p>


    <div class="question-row">
        <?php if ($image_path): ?>
            <img src="<?= htmlspecialchars($final_image_path) ?>" class="question-image">
        <?php endif; ?>

        <div class="answer-group">
            <div class="answer-line">
                <?= htmlspecialchars($data['label1'] ?? 'Shaded') ?> =
                <input type="text" name="answer[<?= $q['id'] ?>][one]" class="quiz-input">
                <?= htmlspecialchars($data['num1'] ?? '') ?>
            </div>

            <div class="answer-line">
                <?= htmlspecialchars($data['label2'] ?? 'Unshaded') ?> =
                <input type="text" name="answer[<?= $q['id'] ?>][two]" class="quiz-input">
                <?= htmlspecialchars($data['num2'] ?? '') ?>
            </div>
        </div>
    </div>
</div>
<?php $char++; ?>

<?php else: ?>

<!-- ============== OLD LEGACY MODE ============== -->
<?php
$shaded_label = $data['Shaded_part'] ?? 'Shaded part';
$unshaded_label = $data['Unshaded_part'] ?? 'Unshaded part';
?>

<div class="quiz-box mb-4">
    <p class="fw-bold">(<?= $char ?>)</p>


    <div class="question-row">
        <?php if ($image_path): ?>
            <img src="<?= htmlspecialchars($final_image_path) ?>" class="question-image">
        <?php endif; ?>

        <div class="answer-group">
            <div class="answer-line">
                <?= htmlspecialchars($shaded_label) ?> =
                <input type="text" name="answer[<?= $q['id'] ?>][shaded]" class="quiz-input">
            </div>

            <div class="answer-line">
                <?= htmlspecialchars($unshaded_label) ?> =
                <input type="text" name="answer[<?= $q['id'] ?>][unshaded]" class="quiz-input">
            </div>
        </div>
    </div>
</div>
<?php $char++; ?>

<?php endif; ?>
