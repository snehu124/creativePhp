<?php
declare(strict_types=1);
$q = $q ?? [];
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$data = json_decode($q['question_payload'] ?? '{}', true);

/* ---------- QUESTION TYPE & PAYLOAD ---------- */
$type = $data['type'] ?? 'add';
$num1 = $data['num1'] ?? 0;
$num2 = $data['num2'] ?? 0;
$text1 = $data['text1'] ?? $data['desc'] ?? '';
$symbol = ($type === 'sub') ? '−' : '+';
$img = $q['question_image'] ?? '';

/* ---------- GLOBAL COUNTERS ---------- */
if (!isset($GLOBALS['normalQnum'])) $GLOBALS['normalQnum'] = 1;
if (!isset($GLOBALS['imageQnum'])) $GLOBALS['imageQnum'] = 1;
?>
<style>
/* =============================
   COMMON INPUT STYLE
============================= */
.money-box,
.add-block input {
    border: none;
    border-bottom: 2px solid #000;
    width: 140px;
    font-size: 20px;
    text-align: center;
    background: transparent;
    padding: 2px 0;
    margin-top: 6px;
    box-shadow: none;
    margin-left: 57px;
}

/* =============================
   ADD / SUB GRID (MAIN FIX)
============================= */
.sum-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px 40px;   /* tighter spacing like Image 2 */
    margin: 15px 0;
}

/* Each question box */
.sum-box {
    font-size: 20px;
    font-weight: 600;
}

/* Question number */
.sum-box b {
    display: inline-block;
    margin-bottom: 4px;
}

/* Number block */
.add-block {
    line-height: 1.5;     /* tighter lines */
    margin-top: 2px;
}

/* Each number line */
.add-block span {
    display: block;
    margin-bottom: 2px !important;
    margin-left: 84px;
}

/* + / - line */
.add-block .sign-line {
    margin-bottom: 4px;
}

span.sub-line {
   margin-left: 90px !important;
}

/* =============================
   PICTURE MONEY WORD SECTION
============================= */
.picture-money-row {
    margin: 22px 0;
    font-size: 18px;
    font-weight: 500;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.picture-money-row b {
    margin-bottom: 6px;
}

/* Image */
.picture-money-row .word-img {
    align-self: center;
    margin: 8px 0 10px;
}

.picture-money-row .word-img img {
    max-width: 300px;
    height: auto;
    margin-right: 621px !important;
}

/* Inline question + input */
.picture-money-row .question-inline {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
</style>

<?php
/* ---------- PICTURE-MONEY-WORD ---------- */
if ($q['question_type'] === 'picture_money_word') {
    if (!empty($GLOBALS['sumGridOpen'])) {
        echo '</div>';
        $GLOBALS['sumGridOpen'] = false;
    }
    ?>
    <div class="picture-money-row">
        <b>Ques. <?= $GLOBALS['imageQnum'] ?>)</b>
        <?php $GLOBALS['imageQnum']++; ?>
        <?php if ($img): ?>
            <div class="word-img"><img src="<?= $h($img) ?>" alt="item"></div>
        <?php endif; ?>
        <div class="question-inline">
            <span><?= $h($text1) ?></span>
            <input type="text"
                   name="answer[<?= $q['id'] ?>]"
                   class="money-box"
                   placeholder="Write amount">
        </div>
    </div>
    <?php
}
/* ---------- ADD / SUB ---------- */
else {
    if (empty($GLOBALS['sumGridOpen'])) {
        echo '<div class="sum-grid">';
        $GLOBALS['sumGridOpen'] = true;
    }
    ?>
    <div class="sum-box">
        <b><?= $GLOBALS['normalQnum'] ?>)</b>
        <?php $GLOBALS['normalQnum']++; ?>
        <div class="add-block">
            <span class="sub-line">$<?= number_format($num1, 2) ?></span>
            <span class="sign-line"><?= $symbol ?>$<?= number_format($num2, 2) ?></span>
            <input type="text" name="answer[<?= $q['id'] ?>]">
        </div>
    </div>
    <?php
}
?>