<?php
declare(strict_types=1);

// Safe guards
$q = $q ?? [];
$char = $char ?? 'a';

// Safe escape
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Payload data
$payload_raw = (string)($q['question_payload'] ?? '{}');
$data = json_decode($payload_raw, true);
if (!is_array($data)) { $data = []; }

// Extract values from payload
$left_digit = $data['left'] ?? 0;
$right_digit = $data['right'] ?? 0;
$operator = $data['operator'] ?? '+'; // + or -
$var = $data['var'] ?? '★'; 

// Determine which side has the symbol
$symbol_on_left = strpos($q['question_text'], '{symbol}') === 0; // true if starts with {symbol}
?>

<style>
.container-fluid {
    margin-left: 50px;
    margin-bottom: 20px;
    width: 90%;
    margin-top: 10px;
}
.container-fluid h6 {
    font-weight: 600;
    margin-bottom: 12px;
    color: #333;
}
.equation {
    font-size: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: Arial, sans-serif;
}
.symbol-box {
    width: 40px;
    height: 40px;
    border: 2px solid #1F669C;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    background-color: #f8fdff;
}
.inline-answer {
    display: inline-block;
    border: none;
    border-bottom: 2px solid #1F669C;
    min-width: 180px;
    font-size: 18px;
    padding: 4px 6px;
    outline: none;
    background: transparent;
    font-family: Arial, sans-serif;
}
</style>

<div class="container-fluid">
    <h6><?= $h($char) ?>.</h6>

    <!-- Dynamic Equation -->
    <div class="equation">
        <?php if ($symbol_on_left): ?>
            <!-- Case: {symbol} + 3 = 8  or  {symbol} - something -->
            <div class="symbol-box"><?= $h($var) ?></div>
            <span><?= $h($operator) ?></span>
            <span><?= $h($left_digit) ?></span>
            <span>=</span>
            <span><?= $h($right_digit) ?></span>

        <?php else: ?>
            <!-- Case: 4 + {symbol} = 6  or  13 - {symbol} = 8 -->
            <span><?= $h($left_digit) ?></span>
            <span><?= $h($operator) ?></span>
            <div class="symbol-box"><?= $h($var) ?></div>
            <span>=</span>
            <span><?= $h($right_digit) ?></span>
        <?php endif; ?>
    </div>

    <!-- Ask for the value of symbol -->
    <div style="margin-top: 18px; font-size: 18px;">
        <?= $h($var) ?> =
        <input type="text"
               class="inline-answer"
               name="answer[<?= (int)$q['id'] ?>]"
               placeholder="Type your answer">
    </div>
</div>

<?php
// Increment char (a → b → c ...)
$char = is_numeric($char) ? ((int)$char + 1) : chr(ord((string)$char) + 1);
?>