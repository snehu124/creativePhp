<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$q = $q ?? [];

$payloadRaw = (string)($q['question_payload'] ?? '[]');
$payload = json_decode($payloadRaw, true) ?: [];

$real_question_id = (int)$q['id'];

$renderType  = $payload['type'] ?? '';
$items       = $payload['items'] ?? [];
$instruction = $payload['instruction'] ?? '';

/* MAIN IMAGE */
$questionImage = trim((string)($q['question_image'] ?? ''));

$makeUrl = fn($path) => $path && !preg_match('~^https?://~i', $path)
    ? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/') . '/' . ltrim($path, '/')
    : $path;

$imgUrl = $makeUrl($questionImage);
?>

<style>
.statistics-wrap{
    margin:20px 0;
    font-family:'Segoe UI',Tahoma,sans-serif;
}

.statistics-instruction{
    font-size:18px;
    font-weight:600;
    color:#d32f2f;
    margin-bottom:24px;
    text-align:left;
}

.statistics-card{
    background:#fff;
    border-radius:14px;
    padding:24px;
    margin-bottom:24px;
    box-shadow:0 1px 5px rgba(0,0,0,.05);
}

.statistics-question-row{
    display:flex;
    justify-content:space-between;
    gap:20px;
    align-items:flex-start;
}

.statistics-left{
    flex:1;
}

.statistics-data{
    font-size:22px;
    line-height:1.8;
    margin-bottom:30px;
    color:#111;
    font-family:Georgia, serif;
}

.statistics-question{
    font-size:18px;
    font-weight:600;
    color:#222;
    margin-bottom:18px;
    line-height:1.7;
}

.answer-label{
    display:inline-block;
    font-size:18px;
    font-weight:700;
    margin-right:12px;
}

.answer-input{
    width:220px;
    max-width:320px;
    border:none;
    border-bottom:3px solid #1976d2;
    padding:10px 4px;
    font-size:18px;
    outline:none;
    background:transparent;
}

.answer-row{
    display:flex;
    align-items:center;
    gap:12px;
}

.statistics-image{
    width:110px;
    flex-shrink:0;
    margin-top:49px;
}

.statistics-image img{
    width:100%;
    height:auto;
    object-fit:contain;
}

.only-question-card{
    padding-top:10px;
}

.no-image-layout{
    display:block;
}

.statistics-main-heading{
    font-size:28px;
    font-weight:700;
    color:#111;
    margin-bottom:35px;
    padding-left:5px;
    line-height:1.5;
}

.statistics-global-box{
    background:#fff;
    border-radius:16px;
    padding:28px;
    margin-bottom:35px;
    border:1px solid #e5e5e5;
    box-shadow:0 2px 8px rgba(0,0,0,.04);

    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:30px;
}

.statistics-global-data{
    flex:1;
    font-size:22px;
    line-height:1.9;
    color:#111;
    font-family:Georgia, serif;
}

.statistics-top-image{
    width:90px;
    flex-shrink:0;
    margin-top:10px;
}

.statistics-question{
    font-size:20px;
}

.statistics-top-image img{
    width:100%;
    height:auto;
    object-fit:contain;
}

</style>

<?php if ($renderType === 'statistics_data_single'): ?>

<div class="statistics-wrap">
    
    <?php
    $item = $items[0] ?? [];
    $data     = $item['data'] ?? '';
    $label    = $item['label'] ?? '1)';
    $isFirstQuestion = trim($label) === '1)';
    $question = $item['question'] ?? '';
    ?>
        <?php if ($isFirstQuestion && $instruction): ?>
            <div class="statistics-main-heading">
                <?= $h($instruction) ?>
            </div>
        <?php endif; ?>

<?php if ($isFirstQuestion && $data): ?>

<div class="statistics-global-box">

    <div class="statistics-global-data">
        <?= nl2br($h($data)) ?>
    </div>

    <?php if ($imgUrl): ?>
    <div class="statistics-top-image">
        <img
            src="<?= $h($imgUrl) ?>"
            alt=""
            loading="lazy">
    </div>
    <?php endif; ?>

</div>

<?php endif; ?>
    
    <div class="statistics-card <?= !$isFirstQuestion ? 'only-question-card' : '' ?>">

        <div class="statistics-question-row <?= !$isFirstQuestion ? 'no-image-layout' : '' ?>">

            <div class="statistics-left">

                <div class="statistics-question">
                    <?= $h($label) ?>
                    <?= $h($question) ?>
                </div>

               <div class="answer-row">

    <label class="answer-label">
        Answer:
    </label>

    <input type="text"
           class="answer-input"
           name="answer[<?= $real_question_id ?>]"
           value="">

</div>
            </div>

        </div>

    </div>

</div>

<?php endif; ?>