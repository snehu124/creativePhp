<?php
declare(strict_types=1);

// Safe guards
$q    = $q    ?? [];
$char = $char ?? 'a';

// Safe escape function
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Read data from the database
$text_template = (string)($q['question_text'] ?? '');
$payload_raw   = (string)($q['question_payload'] ?? '{}');
$data = json_decode($payload_raw, true);
if (!is_array($data)) { $data = []; }

// Get image path
$image_path = $q['question_image'] ?? ''; // Image path from database

// Correct the image URL handling
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http"; 
$domain = $_SERVER['HTTP_HOST'];  // Get domain name
$base_path = "/Student_dashboard/";  // Adjust according to your folder structure

// Make sure the image URL is correctly formed
$final_image_path = $protocol . "://" . $domain . $base_path . ltrim($image_path, '/');

// Extract the sides from the payload (assuming it's a triangle or other polygon)
$sides = $data['sides'] ?? [0, 0, 0]; // Default to [0, 0, 0] if no sides are provided
$perimeter = array_sum($sides); // Calculate perimeter

// Extract the unit from the payload (cm, m, mm, etc.)
$unit = $data['unit'] ?? 'cm,cm,mm,yd,ft';  // Default to 'cm' if no unit is specified

// Determine the variable for the answer, for example 'p', 'y', etc.
$var = 'p';  // Use 'p' instead of 'x' as the dynamic variable

// Placeholder replacements (digit to blue underlined span)
$rendered_text = strtr($text_template, [
    '{digit}' => '<span class="highlight-digit">'.$h($data['digit'] ?? '').'</span>',
    '{text}'  => $h($data['text']  ?? ''),  // This will be the question text (like "Find the perimeter")
    '{text2}' => $h($data['text2'] ?? ''), // Any additional info can be passed here
]);

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

/* Flexbox Layout for Image on Left and Inputs on Right */
.question-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

/* Image container with fixed width and height */
.image-container {
    width: 200px; /* Adjust the width as needed */
    height: 200px; /* Adjust the height as needed */
    overflow: hidden;
    position: relative;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* Ensure the image fits within the container, fixing the cropping issue */
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
</style>

<div class="container-fluid">
    <!-- Question Header with Label and Image -->
    <h6><?= $h($char) . '. ' ?><span><?= $rendered_text ?: $h($q['question_text'] ?? '') ?></span></h6>

    <div class="question-row">
        <!-- LEFT: Image -->
        <?php if ($image_path): ?>
            <div class="image-container">
                <img src="<?= htmlspecialchars($final_image_path) ?>" alt="Shape Image">
            </div>
        <?php endif; ?>

        <!-- RIGHT: Input Fields for Perimeter -->
        <div class="answer-group">
            <div class="answer-line">
                <label class="answer-label" for="perimeter"><?= $var ?> = </label> <!-- Show 'p = ______' -->
                <input type="text" class="inline-answer" id="perimeter" name="answer[<?= (int)$q['id'] ?>]" placeholder="Enter in <?= $unit ?>" />
            </div>
        </div>
    </div>

    <?php $char++; ?>
</div>
