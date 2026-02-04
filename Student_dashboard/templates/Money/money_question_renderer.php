<?php
declare(strict_types=1);

$q = $q ?? [];
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$data = json_decode($q['question_payload'] ?? '{}', true);
$images = $data['images'] ?? ($q['question_image'] ? [$q['question_image']] : []);

$firstImage = $images[0] ?? null;
$otherImages = array_slice($images, 1);
?>

<style>
.money-line {
    margin-bottom: 40px;
    font-size: 22px;
    padding: 10px 0;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.money-img {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 12px;
    width: 100%;
}

.money-img img, .money-first img {
    width: 320px;
    height: auto;
    border: 1px solid #555;
    border-radius: 8px;
}

.money-first {
    margin-left: 10px;
    display: flex;
    align-items: center;
}

.money-blank {
    border: none;
    border-bottom: 2px solid #000;
    width: 160px;
    font-size: 22px;
    text-align: center;
    background: transparent;
    margin-left: 5px;
}
</style>

<div class="money-line">
    <strong><?= ($index + 1) ?>)</strong>

    <?php if ($firstImage): ?>
        <span class="money-first">
            <img src="<?= $h($firstImage) ?>" alt="money">
        </span>
    <?php endif; ?>

    <span style="margin-left:15px;">
        Amount: $ 
        <input type="text" name="answer[<?= $q['id'] ?>][dollar]" class="money-blank">
        ¢
        <input type="text" name="answer[<?= $q['id'] ?>][cent]" class="money-blank">
    </span>

    <?php if (!empty($otherImages)): ?>
        <div class="money-img">
            <?php foreach ($otherImages as $img): ?>
                <img src="<?= $h($img) ?>" alt="money">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
