<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$q = $q ?? [];

$payloadRaw = (string)($q['question_payload'] ?? '{}');
$payload = json_decode($payloadRaw, true) ?: [];

$real_question_id = (int)($q['id'] ?? 0);

$type = $payload['type'] ?? '';

$instruction   = $payload['instruction'] ?? '';
$question      = $payload['question'] ?? '';
$data          = $payload['data'] ?? '';

$answerLabel   = $payload['answer_label'] ?? 'Answer =';

$extraLabel    = $payload['extra_label'] ?? '';

$highestLabel  = $payload['highest_label'] ?? '';
$lowestLabel   = $payload['lowest_label'] ?? '';

$fieldName = 'answer';

if (!empty($highestLabel) || !empty($lowestLabel)) {

    $fieldName = 'range';

} elseif (stripos($question, 'Mean') !== false) {

    $fieldName = 'mean';

} elseif (stripos($question, 'Median') !== false) {

    $fieldName = 'median';

} elseif (stripos($question, 'Mode') !== false) {

    $fieldName = 'mode';
}

/* IMAGE */
$questionImage = trim((string)($q['question_image'] ?? ''));

$makeUrl = fn($path) =>
    $path && !preg_match('~^https?://~i', $path)
        ? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/') . '/' . ltrim($path, '/')
        : $path;

$imgUrl = $makeUrl($questionImage);
?>

<style>

.statistics-wrapper{
    margin:25px 0;
}

/* MAIN HEADING */

.statistics-main-heading{
    font-size:34px;
    font-weight:600;
    color:#111;
    margin-bottom:35px;
    line-height:1.5;
}

/* DATA BOX */

.statistics-global-box{
    background:#fff;
    border-radius:18px;
    padding:30px;
    margin-bottom:35px;
    border:1px solid #e6e6e6;
    box-shadow:0 2px 10px rgba(0,0,0,.05);

    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:30px;
}

.statistics-global-data{
    flex:1;
    font-size:24px;
    line-height:2;
    color:#111;
}

.statistics-top-image{
    width:95px;
    flex-shrink:0;
    margin-top:8px;
}

.statistics-top-image img{
    width:100%;
    height:auto;
    object-fit:contain;
}

/* QUESTION CARD */

.statistics-card{
    background:#fff;
    border-radius:18px;
    padding:30px;
    margin-bottom:35px;
    border:1px solid #e6e6e6;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.statistics-question{
    font-size:22px;
    font-weight:600;
    color:#111;
    line-height:1.8;
    margin-bottom:30px;
}

/* LABELS */

.statistics-label{
    font-size:20px;
    font-weight:600;
    color:#111;
    white-space:nowrap;
}

/* INPUT ROW */

.answer-row{
    display:flex;
    align-items:center;
    gap:18px;
    margin-bottom:22px;
    flex-wrap:wrap;
}

/* INPUT */

.statistics-input{
    width:260px;
    border:none;
    border-bottom:3px solid #1976d2;
    padding:8px 4px;
    font-size:20px;
    outline:none;
    background:transparent;
}

/* EXTRA TEXT */

.statistics-extra-label{
    font-size:20px;
    font-weight:600;
    margin-bottom:20px;
    text-decoration:underline;
}

/* MOBILE */

@media(max-width:768px){

    .statistics-global-box{
        flex-direction:column;
    }

    .statistics-top-image{
        width:75px;
    }

    .statistics-question{
        font-size:19px;
    }

    .statistics-main-heading{
        font-size:26px;
    }

    .statistics-global-data{
        font-size:20px;
    }

    .statistics-input{
        width:100%;
        max-width:250px;
    }

}

</style>

<div class="statistics-wrapper">

    <?php if(!empty($instruction)): ?>
        <div class="statistics-main-heading">
            <?= $h($instruction) ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($data)): ?>

        <div class="statistics-global-box">

            <div class="statistics-global-data">
                <?= nl2br($h($data)) ?>
            </div>

            <?php if($imgUrl): ?>
                <div class="statistics-top-image">
                    <img
                        src="<?= $h($imgUrl) ?>"
                        alt=""
                        loading="lazy">
                </div>
            <?php endif; ?>

        </div>

    <?php endif; ?>

    <div class="statistics-card">

        <?php if(!empty($question)): ?>
            <div class="statistics-question">
                <?= $h($question) ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($extraLabel)): ?>
            <div class="statistics-extra-label">
                <?= $h($extraLabel) ?>
            </div>
        <?php endif; ?>

       <?php if(!empty($highestLabel)): ?>
    <div class="answer-row">

        <label class="statistics-label">
            <?= $h($highestLabel) ?>
        </label>

        <input
            type="text"
            class="statistics-input"
            name="answer[<?= $real_question_id ?>][highest]">

    </div>
<?php endif; ?>

<?php if(!empty($lowestLabel)): ?>
    <div class="answer-row">

        <label class="statistics-label">
            <?= $h($lowestLabel) ?>
        </label>

        <input
            type="text"
            class="statistics-input"
            name="answer[<?= $real_question_id ?>][lowest]">

    </div>
<?php endif; ?>

<div class="answer-row">

    <label class="statistics-label">
        <?= $h($answerLabel) ?>
    </label>

  <input
    type="text"
    class="statistics-input"
    name="answer[<?= $real_question_id ?>][<?= $fieldName ?>]">

</div>

    </div>

</div>