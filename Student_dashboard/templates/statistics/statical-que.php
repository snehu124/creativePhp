<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$optBadge = fn($val) =>
    preg_match('/^[A-D]$/', (string)$val)
        ? '<span class="opt-badge">'.$val.'</span>'
        : '';

$q = $q ?? [];

$payloadRaw = (string)($q['question_payload'] ?? '[]');
$payload = json_decode($payloadRaw, true) ?: [];

$real_question_id = (int)$q['id'];

$renderType  = $payload['type'] ?? '';
$items       = $payload['items'] ?? [];
$instruction = $payload['instruction'] ?? '';

/* MAIN QUESTION IMAGE */
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
    background:#f9f9f9;
    border-radius:14px;
    padding:24px;
    margin-bottom:24px;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
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

.statistics-question{
    font-size:18px;
    font-weight:600;
    color:#222;
    margin-bottom:20px;
    line-height:1.7;
}

.statistics-options{
    display:flex;
    flex-direction:column;
    gap:16px;
}

.statistics-option{
    display:flex;
    align-items:center;
    gap:12px;
    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;
    padding:12px 16px;
    cursor:pointer;
    transition:.2s;
}

.statistics-option:hover{
    background:#f4f8ff;
    border-color:#1976d2;
}

.statistics-option input[type="radio"]{
    transform:scale(1.2);
}

.statistics-image{
    width:110px;
    flex-shrink:0;
    margin-top: 49px;
}

.statistics-image img{
    width:100%;
    height:auto;
    object-fit:contain;
}

.opt-badge{
    display:inline-block;
    min-width:24px;
    height:24px;
    line-height:24px;
    text-align:center;
    border:1px solid #ccc;
    border-radius:6px;
    font-weight:600;
    margin-right:6px;
    background:#fff;
}
</style>

<?php if ($renderType === 'statistics_question_mcq'): ?>

<div class="statistics-wrap">

    <?php if ($instruction): ?>
        <div class="statistics-instruction">
            <?= $h($instruction) ?>
        </div>
    <?php endif; ?>

    <?php
    $item = $items[0] ?? [];

    $label    = $item['label'] ?? '1)';
    $question = $item['question'] ?? '';
    $options  = $item['options'] ?? [];
    ?>

    <div class="statistics-card">

        <div class="statistics-question-row">

            <div class="statistics-left">

                <div class="statistics-question">
                    <?= $h($label) ?>
                    <?= $h($question) ?>
                </div>

                <div class="statistics-options">

                    <?php foreach ($options as $opt):

                        $val  = $opt['value'] ?? '';
                        $text = $opt['text'] ?? '';
                    ?>

                    <label class="statistics-option">

                        <input type="radio"
                               name="answer[<?= $real_question_id ?>]"
                               value="<?= $h($val) ?>">

                        <span>
                            <?= $optBadge($val) ?>
                            <?= $h($text) ?>
                        </span>

                    </label>

                    <?php endforeach; ?>

                </div>

            </div>

            <?php if ($imgUrl): ?>
                <div class="statistics-image">
                    <img src="<?= $h($imgUrl) ?>" alt="">
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

<?php endif; ?>