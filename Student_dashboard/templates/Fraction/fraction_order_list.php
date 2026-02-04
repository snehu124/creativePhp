<?php 
$isReview = defined('IS_CHECK_ANSWER');
$payload   = json_decode($q['question_payload'], true) ?? [];
$fractions = $payload['fractions'] ?? [];
$mode      = $payload['mode'] ?? 'asc';

$qid  = (int)$q['id'];
$sign = ($mode === 'asc') ? '<' : '>';
?>

<style>
.order-card{
    background:#fff;
    padding:26px 28px;
    margin:25px auto;
    border-radius:16px;
    box-shadow:0 4px 14px rgba(0,0,0,.1);
    max-width:100%;
    box-sizing:border-box;
    display:flex;
    flex-direction:column;
    align-items:center; 
}

/* fraction display */
.frac-line{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    white-space:normal;
    font-size:20px;
    margin-bottom:16px;
    flex-wrap: wrap;
    max-width:100%;
    font-weight:bold;
}

/* fraction style */
.frac{
    display:inline-flex;
    flex-direction:column;
    align-items:center;
    line-height:1.1;
}
.frac .num{
    font-size:18px;
}
.frac .den{
    font-size:16px;
    border-top:2px solid #000;
    width:100%;
    text-align:center;
}

/* answer row */
.answer-row{
    display:flex;
    align-items:center;
    gap:12px;
    white-space:normal;
    flex-wrap: wrap;
    max-width:100%;
}

/* AO / DO */
.order-label{
    font-size:18px;
    min-width:55px;
    font-weight:bold;
}

/* inputs */
.frac-input{
    width:32px;
    max-width:100%;
    border:none;
    border-bottom:2px solid #000;
    text-align:center;
    font-size:15px;
    outline:none;
    background:transparent;
    min-width:60px;
}

.sign{
    font-size:15px;
    margin:0 2px;
    font-weight:bold;
}
@media (max-width: 576px){
    .order-card{
        padding:20px 18px;
        max-width:100%;
    }

    .frac-line{
        font-size:18px;
        gap:8px;
    }

    .order-label{
        width:100%;
        margin-bottom:6px;
    }
}

</style>

    <div class="order-card">

        <!-- subpart -->
<div style="font-size:18px;font-weight:bold;margin-bottom:8px; align-self:flex-start;">

            <?= $char ?>)
        </div>
        <?php $char++; ?>

        <!-- fractions -->
        <div class="frac-line">
            <?php foreach ($fractions as $i => $f):
                [$n,$d] = explode('/', $f);
            ?>
                <div class="frac">
                    <div class="num"><?= $n ?></div>
                    <div class="den"><?= $d ?></div>
                </div>
                <?php if ($i < count($fractions)-1): ?>,<?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- answer -->
        <div class="answer-row">
            <div class="order-label"><?= $mode === 'asc' ? 'A.O.' : 'D.O.' ?></div>

            <?php for ($i=0; $i<count($fractions); $i++): ?>
            <input
              class="frac-input"
              type="text"
              name="answer[<?= $qid ?>][]"
              inputmode="numeric"
            />
                <?php if ($i < count($fractions)-1): ?>
                    <span class="sign"><?= $sign ?></span>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

    </div>
</div>

<input type="hidden" name="answer[<?= $qid ?>]" id="final_answer_<?= $qid ?>">
<input type="hidden" name="question_id[]" value="<?= $qid ?>">

<script>
document.addEventListener("input", function () {
    const inputs = document.querySelectorAll(
        '.order-card input[name="answer[<?= $qid ?>][]"]'
    );

    let values = [];
    inputs.forEach(i => {
        if (i.value.trim() !== '') {
            values.push(i.value.trim());
        }
    });

    if (values.length === inputs.length) {
        document.getElementById("final_answer_<?= $qid ?>").value =
            JSON.stringify(values);
    }
});
</script>
