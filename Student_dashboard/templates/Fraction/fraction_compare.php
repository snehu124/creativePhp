<?php
$isReview = defined('IS_CHECK_ANSWER');

$payload = json_decode($q['question_payload'], true) ?? [];

$left  = $payload['left']  ?? '';
$right = $payload['right'] ?? '';

$qid   = (int)$q['id'];
$value = trim($q['student_answer'] ?? '');
?>

<style>
.compare-card{
    background:#fff;
    padding:26px;
    margin:24px 0;
    border-radius:16px;
    box-shadow:0 4px 14px rgba(0,0,0,.1);
}

.compare-row{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
}

/* fraction look */
.frac{
    display:flex;
    flex-direction:column;
    align-items:center;
}
.frac .num{
    font-size:20px;
    font-weight:bold;
    }
.frac .den{
    font-size:18px;
    border-top:2px solid #000;
    width:100%;
    text-align:center;
    font-weight:bold;
}

/* sign input */
.sign-input{
    width:60px;
    height:60px;
    border:3px solid #0d6efd;
    border-radius:8px;
    font-size:28px;
    text-align:center;
    outline:none;
}

.sign-input:disabled{
    background:#eee;
}

@media(max-width:576px){
    .sign-input{
        width:50px;
        height:50px;
        font-size:24px;
    }
}
</style>

<div class="compare-card">

    <div style="font-weight:bold;font-size:18px;margin-bottom:14px;">
        <?= $char ?>)
    </div>
    <?php $char++; ?>

    <div class="compare-row">

        <?php [$ln,$ld] = explode('/', $left); ?>
        <div class="frac">
            <div class="num"><?= $ln ?></div>
            <div class="den"><?= $ld ?></div>
        </div>

        <input
            type="text"
            maxlength="1"
            class="sign-input"
            name="answer[<?= $qid ?>]"
            value="<?= htmlspecialchars($value) ?>"
            <?= $isReview ? 'disabled' : '' ?>
        >

        <?php [$rn,$rd] = explode('/', $right); ?>
        <div class="frac">
            <div class="num"><?= $rn ?></div>
            <div class="den"><?= $rd ?></div>
        </div>

    </div>
</div>

<script>
document.addEventListener("input", e=>{
    if(e.target.classList.contains("sign-input")){
        if(!['>','<','='].includes(e.target.value)){
            e.target.value='';
        }
    }
});
</script>
