<?php
declare(strict_types=1);

// Safe guards
$q    = $q    ?? [];
$char = $char ?? 'a';

// Safe escape function
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Read data from the database
$text_template = (string)($q['question_text'] ?? ''); // Default value if question_text is empty
$payload_raw   = (string)($q['question_payload'] ?? '{}'); // Default value if question_payload is empty
$data = json_decode($payload_raw, true);
if (!is_array($data)) { $data = []; }

// Extract the dimensions from the payload (length, width, height, unit)
$length = $data['length'] ?? '';
$width = $data['width'] ?? '';
$height = $data['height'] ?? '';
$unit = $data['unit'] ?? 'yd'; // Default to yards if no unit is provided

// Placeholder replacements (digit to blue underlined span)
$rendered_text = strtr($text_template, [
    '{length}' => '<span class="highlight-digit">'.$h($length).'</span>',
    '{width}'  => '<span class="highlight-digit">'.$h($width).'</span>',
    '{height}' => '<span class="highlight-digit">'.$h($height).'</span>',
]);

// Get image path (If exists)
$image_path = $q['question_image'] ?? ''; // Image path from database
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http"; 
$domain = $_SERVER['HTTP_HOST'];  // Get domain name
$base_path = "/Student_dashboard/";  // Adjust according to your folder structure
$final_image_path = $protocol . "://" . $domain . $base_path . ltrim($image_path, '/');
?>

<style>
/* Simple layout for the container */
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

/* Underlined digits for length, width, height */
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

/* Flexbox Layout for Image on Right and Inputs on Left */
.question-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

/* Image container with simple style */
.image-container {
    width: 200px; /* Adjust the width as needed */
    height: 200px; /* Adjust the height as needed */
    overflow: hidden;
    position: relative;
    margin-top: 20px;
}

/* Ensure the image fits within the container */
.image-container img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Prevent distortion and cropping */
    object-position: center; /* Ensure the image is centered */
}

.answer-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.answer-line {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
}

/* Fixed size for the answer label and field */
.answer-label {
    font-weight: bold;
    color: #333;
}

/* Styling for the question numbering */
.question-number {
    font-weight: bold;
    color: #1F669C;
    font-size: 18px;
}
</style>

<div class="container-fluid">
    <!-- Question Header with Label and Numbering -->
    <h6><span class="question-number"><?= $h($char) ?>. </span><span><?= $rendered_text ?: $h($q['question_text'] ?? '') ?></span></h6>

    <!-- Render Length, Width, and Height under each question -->
    <div class="question-row">
        <!-- LEFT: Input Fields for Volume -->
        <div class="answer-group">
            <div class="answer-line">
                <label class="answer-label" for="length">Length = </label>
                <span><?= $h($length) ?> <?= $unit ?></span>
            </div>
            <div class="answer-line">
                <label class="answer-label" for="width">Width = </label>
                <span><?= $h($width) ?> <?= $unit ?></span>
            </div>
            <div class="answer-line">
                <label class="answer-label" for="height">Height = </label>
                <span><?= $h($height) ?> <?= $unit ?></span>
            </div>
            <div class="answer-line">
                <label class="answer-label" for="volume">Volume = </label>
                <input type="text" class="inline-answer" id="volume" name="answer[<?= (int)$q['id'] ?>]" placeholder="Enter volume in <?= $unit ?>" />
            </div>
        </div>

        <!-- RIGHT: Image -->
        <?php if ($image_path): ?>
            <div class="image-container">
                <img src="<?= htmlspecialchars($final_image_path) ?>" alt="Shape Image">
            </div>
        <?php endif; ?>
    </div>

    <?php $char++; ?>
</div>
