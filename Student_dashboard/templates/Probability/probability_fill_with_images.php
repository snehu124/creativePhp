<?php
declare(strict_types=1);
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$q = $q ?? [];
$questionImage = trim((string)($q['question_image'] ?? ''));
$payloadRaw = (string)($q['question_payload'] ?? '[]');
$payload = json_decode($payloadRaw, true) ?: [];

// Detect render type
$renderType = $payload['type'] ?? 'unknown';
$items = $payload['items'] ?? [];
$instruction = $payload['instruction'] ?? '';

// Image URL helper
$makeUrl = fn($path) => $path && !preg_match('~^https?://~i', $path)
    ? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/') . '/' . ltrim($path, '/')
    : $path;
$imgUrl = $makeUrl($questionImage);

// THIS IS THE ONLY IMPORTANT LINE ADDED
$real_question_id = $q['id'] ?? 0;  // This is the actual quiz_questions.id from DB
?>
<style>
.probability-wrap { margin: 20px 0; padding: 0 15px; font-family: 'Segoe UI', Tahoma, sans-serif; max-width: 900px; }
.prob-title { font-weight: 600; font-size: 18px; margin: 0 0 16px; color: #1a1a1a; }
.prob-img { display: block; max-width: 100%; height: auto; margin: 0 auto 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.prob-instruction { font-weight: 500; color: #d32f2f; margin-bottom: 12px; line-height: 1.5; white-space: pre-line; }
.prob-outcomes-container { display: flex; flex-direction: column; gap: 18px; margin-top: 20px; }
.prob-outcome-item {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    background: #f8fbff;
    padding: 12px 16px;
    border-radius: 10px;
    border-left: 4px solid #1976d2;
}
.prob-outcome-icon {
    flex: 0 0 70px;
    text-align: center;
}
.prob-outcome-icon img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.prob-fill {
    display: inline-block;
    border-bottom: 3px solid #1976d2;
    width: 110px;
    padding: 6px 4px;
    font-family: monospace;
    font-size: 18px;
    text-align: center;
    background: transparent;
    border-top: none;
    border-left: none;
    border-right: none;
    outline: none;
}
.prob-fill:focus { border-bottom-color: #d32f2f; }
.prob-outcome-label { font-weight: 600; color: #1976d2; min-width: 120px; }
</style>

<div class="probability-wrap">
    <?php if (!empty($q['question_text'])): ?>
        <div class="prob-title"><?= $h($q['question_text']) ?></div>
    <?php endif; ?>
    <?php if ($questionImage): ?>
        <img src="<?= $h($imgUrl) ?>" alt="Question visual" class="prob-img" loading="lazy">
    <?php endif; ?>
    <?php if ($instruction): ?>
        <div class="prob-instruction"><?= $h($instruction) ?></div>
    <?php endif; ?>

    <?php if ($renderType === 'fill_outcomes_with_images'): ?>
        <div class="prob-outcomes-container">
            <?php foreach ($items as $i => $item):
                $part = $item['part'] ?? ('answer' . $i);
                $label = $item['label'] ?? 'Outcome';
                $icon = $item['icon'] ?? null;
                $iconUrl = $icon ? $makeUrl($icon) : null;
            ?>
                <div class="prob-outcome-item">
                    <?php if ($iconUrl): ?>
                        <div class="prob-outcome-icon">
                            <img src="<?= $h($iconUrl) ?>" alt="<?= $h($label) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="prob-outcome-label"><?= $h($label) ?>:</div>

                    <!-- THIS IS THE ONLY CHANGE: Use the REAL question ID as the array key -->
                    <input type="text"
                           name="answer[<?= $real_question_id ?>][<?= $h($part) ?>]"
                           class="prob-fill"
                           placeholder="__"
                           maxlength="12"
                           autocomplete="off">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>