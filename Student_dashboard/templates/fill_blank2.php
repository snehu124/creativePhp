<?php
$text_template = $q['question_text'];
$data = json_decode($q['question_payload'], true);

$replacements = [
    '{digit}' => '<span class="highlight-digit">' . htmlspecialchars($data['digit'] ?? '') . '</span>',
    '{text}'  => htmlspecialchars($data['text'] ?? ''),
    '{text2}' => htmlspecialchars($data['text2'] ?? ''),
];

$rendered_text = strtr($text_template, $replacements);
?>

<style>
    .question-block {
        background: #fff;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        margin: 15px 50px;
        transition: box-shadow 0.3s, transform 0.2s;
    }

    .question-block:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .question-block h6 {
        font-weight: 600;
        font-size: 16px;
        color: #333;
        margin-bottom: 10px;
    }

    .highlight-digit {
        text-decoration: underline;
        font-weight: 700;
        color: #1F669C;
        font-size: 17px;
        margin-right: 4px;
    }

    .answer-line {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin: 8px 0;
    }

    .quiz-input {
        min-width: 120px;
        max-width: 250px;
        padding: 6px 4px;
        font-size: 15px;
        border: none;
        border-bottom: 2px solid #ccc;
        background: transparent;
        outline: none;
        transition: border-color 0.3s;
    }

    .quiz-input:focus {
        border-bottom-color: #1F669C;
    }
</style>

<div class="container-fluid col-lg-12 col-sm-12 col-md-12 question-block">
    <h6><?= $char . '. ' . $rendered_text ?></h6>
    <?php $char++; ?>

    <?php if (!empty($data['digit'])): ?>
        <div class="answer-line">
            <span class="highlight-digit"><?= htmlspecialchars($data['digit'] ?? '') ?></span>
            <span><?= htmlspecialchars($data['text'] ?? '') ?></span>
            <input type="text" 
                   name="answer[<?= $q['id'] ?>][place]" 
                   class="quiz-input" 
                   placeholder="place (e.g. hundreds)"
                   >
            <span>place</span>
        </div>
        <div class="answer-line">
            <span><?= htmlspecialchars($data['text2'] ?? '') ?></span>
            <input type="text" 
                   name="answer[<?= $q['id'] ?>][numeric]" 
                   class="quiz-input" 
                   placeholder="value (e.g. 500)"
                   >
        </div>
    <?php else: ?>
        <div class="answer-line">
            <span><?= htmlspecialchars($data['text2'] ?? '') ?></span>
            <input type="text" 
                   name="answer[<?= $q['id'] ?>][numeric]" 
                   class="quiz-input" 
                   placeholder="Type answer">
        </div>
        <?php $char++; ?>
    <?php endif; ?>
</div>
