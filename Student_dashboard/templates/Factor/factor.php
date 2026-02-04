<?php

// GLOBAL COUNTERS
if (!isset($GLOBALS['main_question'])) {
    $GLOBALS['main_question'] = 1;
}
if (!isset($GLOBALS['grid_question'])) {
    $GLOBALS['grid_question'] = 1;
}
if (!isset($GLOBALS['common_question'])) {
    $GLOBALS['common_question'] = 1;
}

$data = json_decode($q['question_payload'], true);

$mode = $data['mode'] ?? 'pairs';

// OLD TYPE
$number = $data['number'] ?? '';
$pairs_left = $data['pairs_left'] ?? [];
$blankCount = $data['blanks'] ?? 0;

// GRID TYPE
$grid = $data['grid'] ?? [];

// COMMON FACTORS TYPE
$num1 = $data['num1'] ?? null;
$num2 = $data['num2'] ?? null;
$common_blanks = $data['common_blanks'] ?? 0;

?>

<style>
.quiz-box {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 25px;
    margin-bottom: 25px;
}

/* Titles */
.factor-line {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 10px;
}

/* OLD TYPE BLANKS */
.blank-row {
    display: flex;
    flex-wrap: nowrap;
    gap: 35px;
    margin-top: 15px;
    width: 100%;
    overflow-x: auto;
}

.blank-field {
    width: 110px;
    border-bottom: 2px solid #000;
    height: 28px;
    display: inline-block;
}

/* GRID TYPE */
.grid-box {
    background: #f05454;
    padding: 20px;
    border-radius: 20px;
    display: inline-block;
    margin-top: 20px;
}

.grid-row {
    display: flex;
    gap: 25px;
    margin-bottom: 12px;
}

.grid-cell {
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    padding: 12px 18px;
    border-radius: 12px;
    cursor: pointer;
    transition: 0.2s;
    user-select: none;
}

.grid-cell.selected {
    background: #1f75fe !important;
    transform: scale(1.1);
}

/* COMMON FACTORS BOX */
.common-box label {
    font-size: 20px;
    font-weight: 600;
}

.common-input {
    width: 120px;
    border: none;
    border-bottom: 2px solid #000;
    font-size: 20px;
    margin-bottom: 15px;
}
</style>

<div class="quiz-box">

    <h5><strong>

    <?php 
        if ($mode == "grid") {
            echo $GLOBALS['grid_question']++ . ") Factors of $number";
        } 
        elseif ($mode == "common") {
            echo $GLOBALS['common_question']++ . ") $num1 :<br>$num2 :<br><br>Common factors of $num1 and $num2 are:";
        } 
        else {
            echo $GLOBALS['main_question']++ . ") $number :";
        }
    ?>

    </strong></h5>

    <?php if ($mode == "pairs"): ?>

        <!-- OLD TEMPLATE OUTPUT -->
        <?php foreach($pairs_left as $left): ?>
            <div class="factor-line"><?= $left ?> ×</div>
        <?php endforeach; ?>

        <p><strong>Factors of <?= $number ?> are:</strong></p>

        <div class="blank-row">
            <?php for($i = 0; $i < $blankCount; $i++): ?>
                <span class="blank-field"></span>
            <?php endfor; ?>
        </div>

    <?php elseif ($mode == "grid"): ?>

        <!-- GRID TEMPLATE OUTPUT -->
        <div class="grid-box" data-qid="<?= $q['id']; ?>">
            <?php foreach($grid as $row): ?>
                <div class="grid-row">
                    <?php foreach($row as $cell): ?>
                        <div class="grid-cell" data-value="<?= $cell ?>" onclick="toggleSelect(this)">
                            <?= $cell ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <input type="hidden" name="answer[<?= $q['id'] ?>]" id="selected_<?= $q['id'] ?>">

    <?php elseif ($mode == "common"): ?>

        <!-- COMMON FACTORS TEMPLATE -->
        <div class="common-box">

            <label><?= $num1 ?> :</label><br>
            <input type="text" class="common-input" disabled><br><br>

            <label><?= $num2 ?> :</label><br>
            <input type="text" class="common-input" disabled><br><br>

            <div class="blank-row">
            <?php for($i = 0; $i < $common_blanks; $i++): ?>
                <span class="blank-field"></span>
            <?php endfor; ?>
            </div>

        </div>

    <?php endif; ?>

</div>

<script>
function toggleSelect(el) {
    el.classList.toggle("selected");

    let parentBox = el.closest(".quiz-box");
    let hiddenInput = parentBox.querySelector('input[type="hidden"]');

    if (!hiddenInput) return;

    let selected = [];
    parentBox.querySelectorAll(".grid-cell.selected").forEach(cell => {
        selected.push(cell.getAttribute("data-value"));
    });

    hiddenInput.value = selected.join(",");
}
</script>
