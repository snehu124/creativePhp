<?php
declare(strict_types=1);

// ---------- SAFE GUARDS ----------
$q = $q ?? [];
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// ---------- AUTO NUMBER ----------
if (!empty($q['char'])) {
    $question_label = strtolower((string)$q['char']);
} else {
    if (!isset($GLOBALS['__q_auto_index'])) $GLOBALS['__q_auto_index'] = 0;
    $idx = isset($q['serial']) && (int)$q['serial'] > 0 ? (int)$q['serial'] : ++$GLOBALS['__q_auto_index'];
    $question_label = ($idx >= 1 && $idx <= 26) ? chr(ord('a') + ($idx - 1)) : (string)$idx;
}

// ---------- QUESTION TEXT ----------
$text_template = (string)($q['question_text'] ?? '');
$payload_raw   = (string)($q['question_payload'] ?? '{}');
$data = json_decode($payload_raw, true);
if (!is_array($data)) $data = [];

$rendered_text = strtr($text_template, [
    '{digit}' => '<span class="highlight-digit">'.$h($data['digit'] ?? '').'</span>',
    '{text}'  => $h($data['text']  ?? 'Identify the angle as RIGHT | ACUTE | STRAIGHT | OBTUSE - RIGHT (90°), ACUTE (<90°), STRAIGHT (180°), OBTUSE (>90° and <180°)'),
    '{text2}' => $h($data['text2'] ?? 'Please observe the angle carefully and select the appropriate type based on its measure.'),
]);

// ---------- DEGREE ----------
$degree_hint = '';
foreach (['deg','g','h','i','j'] as $k) {
    if (!empty($data[$k])) { $degree_hint = (string)$data[$k]; break; }
}

// ---------- IMAGE ----------
$image_path = (string)($q['question_image'] ?? '');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$domain   = $_SERVER['HTTP_HOST'] ?? '';
$base_path = '/Student_dashboard/';
$final_image_path = $image_path !== ''
    ? rtrim($protocol.'://'.$domain.$base_path, '/') . '/' . ltrim($image_path, '/')
    : '';
?>

<style>
/* Wrapper */
.container-fluid{
    margin:6px auto;
    width:100%;
    max-width:900px;
    padding:0 12px;
}

/* Question heading */
.container-fluid h6{
    font-weight:600;
    margin:0 0 6px 0;
    color:#222;
    font-size:15px;
    line-height:1.4;
}

.q-label{
    font-weight:700;
    margin-right:6px;
}

/* Degree text under label */
.angle-under-number{
    font-size:14px;
    font-weight:600;
    margin:2px 0 6px 22px;
}

/* Main row */
.question-row{
    display:flex;
    align-items:center;
    gap:14px;
}

/* Image box */
.image-container{
    width:120px;
    height:120px;
    border:1px solid #ddd;
    border-radius:6px;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
}

.image-container img{
    max-width:100%;
    max-height:100%;
    object-fit:contain;
}

/* Answer area */
.answer-group{
    flex:1;
    display:flex;
    align-items:flex-end;
}

/* Answer line */
.inline-answer{
    width:100%;
    max-width:260px;
    border:none;
    border-bottom:2px solid #1F669C;
    font-size:15px;
    padding:2px 4px;
    outline:none;
    background:transparent;
}

.inline-answer:focus{
    border-bottom-color:#007bff;
}

.degree-only-row{
    display:flex;
    align-items:center;
    gap:14px;
    margin:6px 0 18px 22px;
}

.degree-only-row .angle-text{
    font-size:15px;
    font-weight:600;
    white-space:nowrap;
}

.degree-only-row .inline-answer{
    max-width:320px;
}

.degree-only-line-fix .answer-group{
    margin-left:134px; 
}

/* -------- MOBILE -------- */
@media (max-width:600px){
    .question-row{
        flex-direction:column;
        align-items:flex-start;
    }

    .image-container{
        width:100px;
        height:100px;
    }

    .inline-answer{
        max-width:100%;
    }

    .angle-under-number{
        margin-left:0;
    }
    .degree-only-row{
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
        margin-left:0;
    }

    .degree-only-row .inline-answer{
        max-width:100%;
    }
    
    .degree-only-line-fix .answer-group{
        margin-left:0;
    }
}

</style>

<div class="container-fluid">
  <!-- numbering -->
  <h6>
    <span class="q-label"><?= $h($question_label) ?>.</span>
    <span><?= $rendered_text !== '' ? $rendered_text : $h($text_template) ?></span>
  </h6>

  <!-- show angle just below numbering -->
  <?php if ($degree_hint !== ''): ?>
    <div class="angle-under-number">Angle: <?= $h($degree_hint) ?></div>
  <?php endif; ?>

 <div class="question-row <?= ($final_image_path === '' && $degree_hint !== '') ? 'degree-only-line-fix' : '' ?>">
    <?php if ($final_image_path !== ''): ?>
      <div class="image-container">
        <img src="<?= $h($final_image_path) ?>" alt="Angle Image">
      </div>
    <?php endif; ?>

    <div class="answer-group">
    <input
  type="text"
  class="inline-answer"
  id="angle_<?= (int)$q['id'] ?>"
  name="answer[<?= (int)$q['id'] ?>]"
>
    </div>
  </div>
</div>
