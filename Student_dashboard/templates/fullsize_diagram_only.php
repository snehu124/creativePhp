<?php
declare(strict_types=1);

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

/* MAIN WRAPPER */
.diagram-full{
    width:100%;
    padding:10px 20px;
    background:#fff;
}

/* IMAGE LEFT SIDE */
.diagram-full img{
    width:75%;
    max-width:75%;
    height:auto;
    max-height:90vh;
    object-fit:contain;
    display:block;
    margin:0;             
    border:none;
    box-shadow:none;
    border-radius:0;
    background:transparent;
}

</style>

<div class="diagram-full">

    <?php if ($imgUrl !== ''): ?>

        <img
            src="<?= $h($imgUrl) ?>"
            alt=""
            loading="lazy"
        >

    <?php else: ?>

        <div style="
            height:90vh;
            display:flex;
            align-items:center;
            justify-content:flex-start;
            color:#999;
            font-size:18px;
        ">
            No Image
        </div>

    <?php endif; ?>

</div>