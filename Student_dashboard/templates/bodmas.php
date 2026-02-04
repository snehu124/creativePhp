<?php
$data = json_decode($q['question_payload'], true);
$operatorMap = [
    'x' => '&times;',
    '/' => '÷',
    '+' => '+',
    '-' => '-'
];
$symbolMathML = $operatorMap[$data['operator']] ?? $data['operator'];

// Collect all number keys dynamically (num1, num2, num3, etc.)
$numbers = [];
foreach ($data as $key => $value) {
    if (strpos($key, 'num') === 0) {
        $numbers[] = $value;
    }
}
?>

<style>
.quiz-box {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 20px;
    transition: box-shadow 0.3s, transform 0.2s;
}
.quiz-box:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}
.quiz-box h6 {
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}
.math-container {
    font-size: 28px;
    font-weight: bold;
    line-height: 1.2;
    text-align: right;
    display: inline-block;
    width: 100%;
}
.divider {
    display: block;
    border-top: 2px solid #000;
    width: 60%;
    margin: 0 auto 8px auto;
}
.answer-input {
    max-width: 120px;
    margin: 0 auto;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 16px;
    text-align: center;
}
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}
</style>

<div class="col-md-4 mb-4">
    <div class="quiz-box text-center">
        <h6 class="text-start"><strong><?= $index + 1 ?>)</strong></h6>

        <div class="math-container">
            <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
                <mtable columnwidth="auto">
                    <?php
                    foreach ($numbers as $i => $num) {
                        echo "<mtr><mtd columnalign='right'>";
                        if ($i == count($numbers) - 1 && isset($symbolMathML)) {
                            echo "<mo>{$symbolMathML}</mo>";
                        }
                        echo "<mn>" . htmlspecialchars($num) . "</mn>";
                        echo "</mtd></mtr>";
                    }
                    ?>
                </mtable>
            </math>
        </div>

        <span class="divider"></span>

       <input type="number" 
       name="answer[<?= $q['id'] ?>]" 
       class="form-control answer-input" 
       step="any"
       onkeydown="return event.keyCode !== 38 && event.keyCode !== 40">
    </div>
</div>
