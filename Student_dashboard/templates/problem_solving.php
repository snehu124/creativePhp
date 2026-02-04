<?php
declare(strict_types=1);

$q = $q ?? [];
$index = $index ?? 0;

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$data = json_decode($q['question_payload'] ?? '{}', true);
$isInstruction = !empty($data['instruction']);
$image = $data['image'] ?? null;

/**
 * Detect sub-question:
 * starts with a) b) c) d)
 */
$isSubQuestion = preg_match('/^[a-d]\)/i', trim($q['question_text'])) === 1;
?>

<style>
.ps-image {
    max-width: 260px;
    margin: 10px 0;
}
.ps-input {
    border: none;
    border-bottom: 2px solid #ccc;
    width: 160px;
    font-size: 18px;
    outline: none;
}
</style>

<div class="quiz-box mb-4">

    <!-- ✅ QUESTION HEADING -->
    <p class="fw-bold">
        <?php if (!$isSubQuestion): ?>
            Que<?= ($index + 1) ?>. <?= $h($q['question_text']) ?>
        <?php else: ?>
            <?= $h($q['question_text']) ?>
        <?php endif; ?>
    </p>

    <!-- ✅ IMAGE -->
    <?php if ($image): ?>
        <img src="<?= $h($image) ?>" class="ps-image">
    <?php endif; ?>

    <?php if ($isInstruction): ?>

        <!-- ✅ INSTRUCTION TEXT -->
        <h6 class="mt-3">How far is:</h6>

    <?php else: ?>

        <!-- ✅ ANSWER INPUT -->
        <div class="d-flex align-items-center gap-2 mt-2">
            <input
                type="text"
                name="answer[<?= $q['id'] ?>]"
                class="ps-input"
                placeholder="Enter your answer"
            >
            <?php if (!empty($q['unit'])): ?>
                <span class="fw-bold"><?= $h($q['unit']) ?></span>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</div>
