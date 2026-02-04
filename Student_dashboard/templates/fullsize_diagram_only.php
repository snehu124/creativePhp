<?php
declare(strict_types=1);

/**
 * DIAGRAM ONLY – FULL WIDTH, MAX SIZE, NOTHING ELSE
 * -------------------------------------------------
 * Image stretches to full width of screen
 * Takes up maximum possible height (90vh)
 * No text, no inputs, no borders, no padding
 */

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$q = $q ?? [];
$questionImage = trim((string)($q['question_image'] ?? ''));

$makeUrl = function (string $path) use ($h): string {
    if ($path === '') return '';
    if (preg_match('~^https?://~i', $path)) return $path;
    $root = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
    $root = $root === '' ? '/' : $root;
    return $root . '/' . ltrim($path, '/');
};

$imgUrl = $makeUrl($questionImage);
?>
<style>
/* Full screen image — no distractions */
.diagram-full {
    margin: 0;
    padding: 0;
    width: 100vw;
    max-width: 100%;
    overflow: hidden;
    text-align: center;
    background: #fff;
}
.diagram-full img {
    width: 100vw;                    /* Full viewport width */
    height: 90vh;                    /* 90% of screen height */
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;             /* Keep aspect ratio, no cropping */
    display: block;
    margin: 0 auto;
    border: none;
    box-shadow: none;
    border-radius: 0;
    background: transparent;
}
</style>

<div class="diagram-full">
    <?php if ($imgUrl !== ''): ?>
        <img src="<?= $h($imgUrl) ?>" alt="" loading="lazy">
    <?php else: ?>
        <div style="height:90vh; display:flex; align-items:center; justify-content:center; color:#eee; font-size:18px;">
            No Image
        </div>
    <?php endif; ?>
</div>