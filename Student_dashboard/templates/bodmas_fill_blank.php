<?php
$data = json_decode($q['question_payload'], true);

$operatorMap = [
    'x' => '&times;',
    '*' => '&times;',
    '/' => '÷',
    '+' => '+',
    '-' => '−'
];

$symbolMathML = $operatorMap[$data['operator']] ?? $data['operator'];

$numbers = [];
foreach ($data as $key => $value) {
    if (strpos($key, 'num') === 0) {
        $numbers[] = $value;
    }
}

$layoutType = $data['layout'] ?? 'inline';
$isVertical = ($layoutType === 'vertical');
?>

<style>
    .quiz-line {
        display: flex;
        align-items: center;
        margin-bottom: 18px; 
        font-size: 18px;
        line-height: 2.4;
    }

    .quiz-line strong {
        margin-right: 10px;
        font-weight: 600;
    }

    /* Editable underline box */
    .answer-blank {
        display: inline-block;
        border: none;
        border-bottom: 2px solid black;
        width: 120px;
        height: 28px;
        margin-left: 10px;
        text-align: center;
        font-size: 18px;
        outline: none;
        background: transparent;
    }

    .answer-blank:focus {
        border-bottom: 2px solid #007bff; /* highlight on focus */
    }

    .math-inline {
        display: inline-block;
        white-space: nowrap;
    }
</style>

<div class="quiz-line">
    <strong><?= chr(97 + $index) ?>)</strong>
    
    <?php if ($isVertical): ?>
        <!-- Vertical layout -->
        <div class="math-inline">
            <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
                <mtable columnwidth="auto">
                    <mtr>
                        <mtd columnalign="right">
                            <mn><?= htmlspecialchars($numbers[0]) ?></mn>
                        </mtd>
                    </mtr>
                    <mtr>
                        <mtd columnalign="right">
                            <mo><?= $symbolMathML ?></mo>
                            <mn><?= htmlspecialchars($numbers[1]) ?></mn>
                        </mtd>
                    </mtr>
                </mtable>
            </math>
        </div>
        <input type="text" 
               name="answer[<?= $q['id'] ?>]" 
               class="answer-blank" 
               placeholder=""
               autocomplete="off">
    <?php else: ?>
        <!-- Inline layout -->
        <span class="math-inline">
            <?= htmlspecialchars($numbers[0]) ?>
            <?= " " . $symbolMathML . " " ?>
            <?= htmlspecialchars($numbers[1]) ?> =
        </span>
        <input type="text" 
               name="answer[<?= $q['id'] ?>]" 
               class="answer-blank" 
               placeholder=""
               autocomplete="off">
    <?php endif; ?>
</div>
