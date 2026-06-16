<?php
declare(strict_types=1);

$q = $q ?? [];

$h = fn($s) => htmlspecialchars(
    (string)$s,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);

$id = (int)($q['id'] ?? 0);

$payload = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];
?>

<style>

.math-expression-wrap{
    margin-bottom:40px;
    padding-bottom:10px;
}

/* =========================
   QUESTION ROW
========================= */

.math-question{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    font-size:20px;
    color:#111;
    font-weight:600;
}

.question-number{
    width:35px;
    flex-shrink:0;
    font-weight:700;
}

.question-text{
    width:260px;
    flex-shrink:0;
    word-break:break-word;
}

/* =========================
   QUESTION BLANK
========================= */

.blank-input{
    width:280px;
    min-width:280px;
    border:none;
    border-bottom:2px solid #000;
    background:transparent;
    outline:none;
    font-size:18px;
    text-align:center;
    padding:4px 0;
}

.blank-input:focus{
    border-bottom-width:3px;
}

/* =========================
   EXPRESSION ROW
========================= */

.expression-row{
    display:flex;
    align-items:center;
    gap:10px;
    margin-left:35px;
    margin-top:8px;
}

.expression-title{
    width:260px;
    flex-shrink:0;
    color:#9c27ff;
    font-size:20px;
    font-weight:700;
}

.expression-input{
    width:280px;
    min-width:280px;
    border:none;
    border-bottom:2px solid #000;
    background:transparent;
    outline:none;
    font-size:18px;
    text-align:center;
    padding:4px 0;
    margin-left:14px !important;
}

.expression-input:focus{
    border-bottom-width:3px;
}

/* =========================
   TABLET
========================= */

@media (max-width:992px){

    .question-text,
    .expression-title{
        width:220px;
    }

    .blank-input,
    .expression-input{
        width:220px;
        min-width:220px;
    }
}

/* =========================
   MOBILE
========================= */

@media (max-width:768px){

    .math-question{
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }

    .question-number{
        width:auto;
    }

    .question-text{
        width:100%;
    }

    .blank-input{
        width:100%;
        min-width:unset;
    }

    .expression-row{
        margin-left:0;
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }

    .expression-title{
        width:100%;
        font-size:18px;
    }

    .expression-input{
        width:100%;
        min-width:unset;
        font-size:18px;
    }
}

/* =========================
   SMALL MOBILE
========================= */

@media (max-width:480px){

    .math-question{
        font-size:18px;
    }

    .question-text{
        width:100%;
    }

    .blank-input,
    .expression-input{
        font-size:18px;
    }

    .expression-title{
        font-size:18px;
    }
}

</style>

<div class="math-expression-wrap">

    <div class="math-question">

        <span class="question-number">
            <?= ($index + 1) ?>)
        </span>

        <span class="question-text">
            <?= $h($payload['sentence'] ?? '') ?>
        </span>

        <input
            type="text"
            class="blank-input"
            name="answer[<?= $id ?>][blank]"
        >

    </div>

    <div class="expression-row">

        <span class="expression-title">
            Math Expression:
        </span>

        <input
            type="text"
            class="expression-input"
            name="answer[<?= $id ?>][expression]"
            placeholder="<?= $h($payload['example'] ?? '16 = 4^2') ?>"
        >

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const form = document.querySelector('form');

    if(!form) return;

    form.addEventListener('submit', function(){

        document.querySelectorAll('.expression-input').forEach(function(input){

            let val = input.value.trim();

            // Remove spaces
            val = val.replace(/\s+/g, '');

            // Convert powers
            val = val.replace(/\^2/g, '²');
            val = val.replace(/\^3/g, '³');

            input.value = val;

        });

    });

});
</script>