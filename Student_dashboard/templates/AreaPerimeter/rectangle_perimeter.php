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
$text_template = (string)($q['question_text'] ?? 'Find the Surface Area');
$payload_raw   = (string)($q['question_payload'] ?? '{}');

$data = json_decode($payload_raw, true);
if (!is_array($data)) $data = [];

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

.surface-wrapper{
    width:100%;
    max-width:1000px;
    margin:15px auto 25px;
    padding:25px;
    background:#fff;
    border-radius:14px;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.surface-heading{
    font-size:22px;
    font-weight:700;
    color:#222;
    margin-bottom:20px;
}

.q-label{
    font-weight:700;
    margin-right:6px;
}

.surface-row{
    display:flex;
    align-items:center;
    gap:18px;
    flex-wrap:wrap;
}

.surface-image{
    flex:0 0 320px;
    width:320px;
    min-height:250px;
}

.surface-image img{
    max-width:100%;
    max-height:400px;
    object-fit:contain;
    display:block;
}

.surface-answer{
    flex:1;
    min-width:300px;
}

.answer-label{
    font-size:15px;
    font-weight:600;
    color:#333;
}

.answer-input{
    flex:1;
    border:none;
    border-bottom:2px solid #1F669C;
    padding:6px 4px;
    font-size:16px;
    outline:none;
    background:transparent;
    text-align: center;
}

.answer-input:focus{
    border-bottom-color:#007bff;
}

.unit-text{
    margin-left:6px;
    font-weight:600;
    color:#444;
}

.answer-row{
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
}

@media(max-width:600px){

    .surface-row{
        flex-direction:column;
        align-items:flex-start;
    }

    .surface-image{
        width:100%;
        min-height:160px;
    }

    .answer-input{
        max-width:100%;
    }
}

/* Large Tablet */
@media (max-width:1024px){

    .surface-wrapper{
        padding:20px;
    }

    .surface-image{
        width:280px;
    }

    .surface-heading{
        font-size:20px;
    }

}

/* Tablet */
@media (max-width:768px){

    .surface-row{
        flex-direction:column;
        align-items:center;
        text-align:center;
    }

    .surface-image{
        flex:none;
        width:100%;
        max-width:100%;
        min-height:auto;
    }

    .surface-image img{
        width:100%;
        height:auto;
        max-height:none;
    }

    .surface-answer{
        width:100%;
        min-width:unset;
    }

    .answer-label{
        font-size:16px;
    }

}

/* Mobile */
@media (max-width:480px){

    .surface-wrapper{
        padding:15px;
        border-radius:10px;
    }

    .surface-heading{
        font-size:18px;
        line-height:1.4;
    }

    .surface-row{
        gap:15px;
    }

    .surface-image{
        width:100%;
    }

    .surface-image img{
    width:100%;
    height:auto;
}

    .surface-answer > div{
        flex-wrap:wrap;
        gap:8px;
    }

  
    .answer-row{
        flex-wrap:nowrap;
        align-items:center;
    }

    .answer-label{
        width:auto;
        white-space:nowrap;
    }

    .answer-input{
        flex:1;
        min-width:100px;
    }

    .unit-text{
        white-space:nowrap;
    }
}

</style>

<div class="surface-wrapper">

    <div class="surface-heading">
        <span class="q-label"><?= $h($question_label) ?>.</span>
        <?= $h($text_template) ?>
    </div>

    <div class="surface-row">

        <?php if($final_image_path !== ''): ?>
        <div class="surface-image">
            <img src="<?= $h($final_image_path) ?>" alt="loading...">
        </div>
        <?php endif; ?>

        <div class="surface-answer">

    <div class="answer-row">

        <div class="answer-label" style="margin-bottom:0; white-space:nowrap;">
            <?= $h($data['label'] ?? 'Answer') ?> =
        </div>

        <input
            type="text"
            class="answer-input"
            id="surface_<?= (int)$q['id'] ?>"
            name="answer[<?= (int)$q['id'] ?>]"
            style="flex:1;"
        >

        <?php if(!empty($data['unit'])): ?>
            <span class="unit-text"><?= $h($data['unit']) ?></span>
        <?php endif; ?>

    </div>

</div>

    </div>

</div>