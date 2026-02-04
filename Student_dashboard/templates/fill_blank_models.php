<?php
$data = json_decode($q['question_payload'], true);

// Map operator symbols
$operatorMap = [
    'x' => '&times;',
    '*' => '&times;',
    '/' => '÷',
    '+' => '+',
    '-' => '−'
];

$symbolMathML = $operatorMap[$data['operator']] ?? $data['operator'];

// Extract numbers
$numbers = [];
foreach ($data as $key => $value) {
    if (strpos($key, 'num') === 0) {
        $numbers[] = $value;
    }
}

// Layout type: inline or vertical
$layoutType = $data['layout'] ?? 'inline';
$isVertical = ($layoutType === 'vertical');

// Unique grid ID for each question
$gridId = "grid_" . $q['id'];
?>

<style>
/* Quiz line layout */
.quiz-line {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    font-size: 18px;
    flex-wrap: wrap;
    gap: 10px;
}

.quiz-line strong {
    margin-right: 10px;
}

/* Editable answer box */
.answer-blank {
    display: inline-block;
    border: none;
    border-bottom: 2px solid black;
    width: 120px;
    height: 28px;
    text-align: center;
    font-size: 18px;
    outline: none;
    background: transparent;
}

.answer-blank:focus {
    border-bottom: 2px solid #007bff;
}

/* Math display inline */
.math-inline {
    display: inline-block;
    white-space: nowrap;
    margin-right: 10px;
}

/* 10x10 grid */
.grid {
    border: 2px solid #0000FF;
    display: grid; /* Use CSS Grid for precise control */
    grid-template-columns: repeat(10, 1fr); /* Exactly 10 columns */
    grid-template-rows: repeat(10, 1fr); /* Exactly 10 rows */
    width: 200px;
    height: 200px;
    margin-top: 10px;
    background-color: #f9f9f9;
    position: relative;
}

.grid div {
    border: 1px solid #0000FF;
    box-sizing: border-box;
    background-color: transparent;
    transition: background-color 0.3s; /* Smooth color transition */
}
</style>

<div class="quiz-line">
    <strong><?= chr(97 + $index) ?>)</strong>

    <?php if ($isVertical): ?>
        <div class="math-inline">
            <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
                <mtable columnwidth="auto">
                    <mtr>
                        <mtd columnalign="right"><mn><?= htmlspecialchars($numbers[0]) ?></mn></mtd>
                    </mtr>
                    <mtr>
                        <mtd columnalign="right"><mo><?= $symbolMathML ?></mo><mn><?= htmlspecialchars($numbers[1]) ?></mn></mtd>
                    </mtr>
                </mtable>
            </math>
        </div>
    <?php else: ?>
        <span class="math-inline">
            <?= htmlspecialchars($numbers[0]) ?>
            <?= " " . $symbolMathML . " " ?>
            <?= htmlspecialchars($numbers[1]) ?> =
        </span>
    <?php endif; ?>

    <!-- Input box with data attributes for JS -->
    <input type="text" 
           name="answer[<?= $q['id'] ?>]" 
           class="answer-blank" 
           placeholder=""
           autocomplete="off"
           data-num1="<?= $numbers[0] ?>" 
           data-num2="<?= $numbers[1] ?>">

    <!-- 10x10 Grid -->
    <div class="grid" id="<?= $gridId ?>">
        <?php for ($i = 0; $i < 100; $i++): ?>
            <div></div>
        <?php endfor; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Function to fill the grid dynamically
    function fillGrid(gridId, factor1, factor2) {
        const grid = document.getElementById(gridId);
        if (!grid) return;
        const cells = grid.getElementsByTagName('div');
        const rows = 10;
        const cols = 10;

        // Clear previous colors
        for (let i = 0; i < cells.length; i++) {
            cells[i].style.backgroundColor = '';
        }

        const rowsToColor = Math.floor(factor1 * rows);
        const colsToColor = Math.floor(factor2 * cols);

        // Color rows red
        for (let i = 0; i < rowsToColor; i++) {
            for (let j = 0; j < cols; j++) {
                cells[i * cols + j].style.backgroundColor = 'red';
            }
        }

        // Color columns yellow
        for (let j = 0; j < colsToColor; j++) {
            for (let i = 0; i < rows; i++) {
                const index = i * cols + j;
                if (cells[index].style.backgroundColor !== 'red') {
                    cells[index].style.backgroundColor = 'yellow';
                }
            }
        }

        // Overlap orange
        for (let i = 0; i < rowsToColor; i++) {
            for (let j = 0; j < colsToColor; j++) {
                cells[i * cols + j].style.backgroundColor = 'orange';
            }
        }
    }

    // Attach event listeners to all inputs
    document.querySelectorAll('.answer-blank').forEach(input => {
        input.addEventListener('input', () => {
            const val = parseFloat(input.value);
            const factor1 = parseFloat(input.dataset.num1);
            const factor2 = parseFloat(input.dataset.num2);
            const grid = input.nextElementSibling;
            if (!grid) return;

            if (!isNaN(val) && val > 0 && val <= 1) {
                fillGrid(grid.id, factor1, factor2);
            } else {
                grid.querySelectorAll('div').forEach(cell => cell.style.backgroundColor = '');
            }
        });
    });
});
</script>