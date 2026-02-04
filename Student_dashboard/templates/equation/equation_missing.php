<?php
declare(strict_types=1);

// Safe guards
$q    = $q    ?? [];
$char = $char ?? 'a';

// Safe escape
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Read data
$text_template = (string)($q['question_text'] ?? '');
$payload_raw   = (string)($q['question_payload'] ?? '{}');
$data = json_decode($payload_raw, true);
if (!is_array($data)) { $data = []; }

// Determine the variable for the answer
$var = isset($data['text']) ? $data['text'] : 'x';

// Placeholder replacements
$rendered_text = strtr($text_template, [
    '{digit}' => '<span class="highlight-digit">'.$h($data['digit'] ?? '').'</span>',
    '{text}'  => $h($data['text']  ?? ''),
    '{text2}' => $h($data['text2'] ?? ''),
]);

// Question image (if exists)
$question_image = trim((string)($q['question_image'] ?? ''));
$image_url = '';
if ($question_image !== '') {
    $image_url = '/' . ltrim($question_image, '/');
}
?>

<style>
/* Simple, clean layout */
.container-fluid {
    margin-left: 50px;
    margin-bottom: 20px;
    width: 90%;
    margin-top: 10px;
}
.container-fluid h6 {
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}
.highlight-digit {
    text-decoration: underline;
    font-weight: 700;
    color: #1F669C;
    font-size: 17px;
    margin-right: 4px;
}

/* The blue underline answer field */
.inline-answer {
    display: inline-block;
    border: none;
    border-bottom: 2px solid #1F669C;
    min-width: 200px;
    font-size: 16px;
    padding: 3px 4px;
    outline: none;
    background: transparent;
    transition: border-color 0.3s;
}
.inline-answer:focus {
    border-bottom-color: #007bff;
}
.inline-answer::placeholder {
    color: #aaa;
}
</style>

<div class="container-fluid">
    <h6><?= $h($char) . '. ' ?><span><?= $rendered_text ?: $h($q['question_text'] ?? '') ?></span></h6>

    <!-- Question Image (only if exists) -->
    <?php if ($image_url): ?>
        <div style="margin:10px 0;">
            <img 
                src="<?= $h($image_url) ?>" 
                alt="Question Image"
                style="max-width:100%; height:auto; border-radius:6px;"
            >
        </div>
    <?php endif; ?>

    <!-- Dynamic inline blue underline answer -->
    <div style="font-size:16px; margin-top:10px;">
        <?= $h($var) ?> = <input type="text"
       class="inline-answer"
       name="answer[<?= (int)$q['id'] ?>]"
       placeholder="Type your answer" />
    </div>
</div>

<?php
// Increment numbering (a, b, c, ...)
$char = is_numeric($char) ? ((int)$char + 1) : chr(ord((string)$char) + 1);
?>
