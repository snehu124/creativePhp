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
$mode = $data['mode'] ?? '';
?>

<?php if ($mode === 'missing_addition'):
    $rows = $data['rows'];
    $numRows = count($rows);
    $maxCols = max(array_map('count', $rows));
?>
<style>
    /* .missing-add-wrap = inner layout only. Width/columns come from the
       Bootstrap grid class (col-md-4) on the div below — 3 per row.          */
    .missing-add-wrap {
        display: flex;
        align-items: flex-start;
        font-size: 18px;
        margin-bottom: 26px;
    }
    .missing-add-wrap strong {
        margin-right: 10px;
        font-weight: 600;
        line-height: 2.4;
    }
    .missing-add-table {
        border-collapse: collapse;
    }
    .missing-add-table td {
        width: 34px;
        height: 40px;
        text-align: center;
        vertical-align: middle;
        font-size: 18px;
        padding: 2px;
    }
    .missing-add-table td.op-cell {
        width: 18px;
        text-align: left;
        font-weight: 600;
        padding-left: 0;
    }
    .missing-add-table tr.sum-row td {
        border-top: 2px solid #000;
        padding-top: 6px;
    }
    .digit-blank {
        width: 28px;
        height: 28px;
        border: 2px solid #2b3fae;
        border-radius: 4px;
        text-align: center;
        font-size: 15px;
        outline: none;
        background: #fff;
        padding: 0;
    }
    .digit-blank:focus {
        border-color: #007bff;
    }
</style>
<!-- col-md-4 = 3 per row. For 2 per row change it to col-md-6 -->
<div class="missing-add-wrap col-md-4">
    <strong><?= chr(97 + $index) ?>)</strong>
    <table class="missing-add-table">
        <?php foreach ($rows as $rIndex => $row):
            $isFirstRow = ($rIndex === 0);
            $isLastRow  = ($rIndex === $numRows - 1);
            $pad = $maxCols - count($row);
            $rowClass = $isLastRow ? 'sum-row' : '';
        ?>
        <tr class="<?= $rowClass ?>">
            <td class="op-cell">
                <?= (!$isFirstRow && !$isLastRow) ? $symbolMathML : '' ?>
            </td>
            <?php for ($p = 0; $p < $pad; $p++): ?>
                <td></td>
            <?php endfor; ?>
            <?php foreach ($row as $cell): ?>
                <td>
                    <?php if ($cell === ''): ?>
                        <input type="text"
                               name="answer[<?= $q['id'] ?>][]"
                               class="digit-blank"
                               maxlength="1"
                               inputmode="numeric"
                               autocomplete="off">
                    <?php else: ?>
                        <?= htmlspecialchars($cell) ?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php else: ?>

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

<?php endif; ?>