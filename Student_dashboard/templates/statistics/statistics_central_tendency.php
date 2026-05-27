<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$q = $q ?? [];

$payloadRaw = (string)($q['question_payload'] ?? '{}');
$payload = json_decode($payloadRaw, true) ?: [];

$real_question_id = (int)($q['id'] ?? 0);

$instruction = $payload['instruction'] ?? '';
$question    = $payload['question'] ?? '';
$data        = $payload['data'] ?? '';
$extraLabel  = $payload['extra_label'] ?? '';

$fields = $payload['fields'] ?? [];

$questionImage = trim((string)($q['question_image'] ?? ''));

$makeUrl = fn($path) =>
    $path && !preg_match('~^https?://~i', $path)
        ? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/') . '/' . ltrim($path, '/')
        : $path;

$imgUrl = $makeUrl($questionImage);
?>

<style>

.central-wrapper{
    margin:25px 0;
}

.central-card{
    background:#fff;
    border-radius:18px;
    padding:35px;
    margin-bottom:35px;
    border:1px solid #e5e5e5;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.central-heading{
    font-size:18px;
    font-weight:600;
    text-align:center;
    margin-bottom:35px;
}

.central-question{
    font-size:18px;
    font-weight:600;
    line-height:1.8;
    margin-bottom:20px;
}

.central-data{
    font-size:18px;
    line-height:2;
    margin-bottom:25px;
}

.central-extra{
    font-size:18px;
    font-weight:600;
    margin-bottom:30px;
}

.answer-row{
    display:flex;
    align-items:center;
    gap:20px;
    margin-bottom:35px;
}

.answer-label{
    font-size:18px;
    font-weight:600;
    min-width:140px;
}

.answer-input{
    width:260px;
    border:none;
    border-bottom:3px solid #1976d2;
    padding:8px 5px;
    font-size:18px;
    outline:none;
    background:transparent;
}

.outside-question{
    font-size:18px;
    font-weight:600;
    color:#111;
    margin-bottom:25px;
    line-height:1.7;
}

.top-image{
    width:90px;
    margin-bottom:20px;
}

.top-image img{
    width:100%;
    height:auto;
}

.outside-data{
    font-size:18px;
    line-height:2;
    color:#111;
    margin-bottom:30px;
}
@media(max-width:768px){

    .central-heading{
        font-size:26px;
    }

    .central-question,
    .central-data,
    .central-extra,
    .answer-label{
        font-size:18px;
    }

    .answer-row{
        flex-direction:column;
        align-items:flex-start;
    }

    .answer-input{
        width:100%;
    }
}
</style>

<div class="central-wrapper">

<?php if(!empty($question)): ?>
    <div class="outside-question">
        <?= $h($question) ?>
    </div>
<?php endif; ?>
<?php if(!empty($data)): ?>
    <div class="outside-data">
        <?= nl2br($h($data)) ?>
    </div>
<?php endif; ?>
<div class="central-card">

    <?php if($imgUrl): ?>
        <div class="top-image">
            <img src="<?= $h($imgUrl) ?>" alt="">
        </div>
    <?php endif; ?>

    <?php if(!empty($instruction)): ?>
        <div class="central-heading">
            <?= $h($instruction) ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($extraLabel)): ?>
        <div class="central-extra">
            <?= $h($extraLabel) ?>
        </div>
    <?php endif; ?>

    <?php foreach($fields as $field): ?>

        <div class="answer-row">

            <div class="answer-label">
                <?= $h($field['label']) ?>
            </div>

            <input
                type="text"
                class="answer-input"
                name="answer[<?= $real_question_id ?>][<?= $h($field['name']) ?>]">

        </div>

    <?php endforeach; ?>

</div>

</div>