<?php
// ===== DATA =====
$payload  = json_decode($q['question_payload'], true);
$frac_num = $payload['frac_num'] ?? '';
$frac_den = $payload['frac_den'] ?? '';
$qid      = (int)$q['id'];
$expected = $q['correct_answer'];
?>

<style>
.qcard{
    background:#fff;
    padding:14px 18px;
    margin:10px 0;
    border-radius:14px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}
.eq-row{
    display:flex;
    align-items:center;
    gap:12px;
    white-space:nowrap;
}
.vfrac{
    display:inline-flex;
    flex-direction:column;
    align-items:center;
    font-family:'Cambria Math','Times New Roman',serif;
}
.vfrac .num{
    border-bottom:2px solid #000;
    font-size:18px;
    font-weight:600;
}
.vfrac .den{ font-size:18px; }

.frac-input-box{
    width:60px;
    height:70px;
    border:3px solid #e8063c;
    border-radius:8px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    position:relative;
}
.frac-input-box::before{
    content:'';
    position:absolute;
    left:6px;
    right:6px;
    top:50%;
    height:2px;
    background:#000;
}
.frac-input-box input{
    width:100%;
    border:none;
    outline:none;
    background:transparent;
    text-align:center;
    font-size:18px;
    font-weight:600;
}
.frac-input-box .num-input{ margin-bottom:6px; }
.frac-input-box .den-input{ margin-top:6px; }
</style>

<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="qcard">
        <div class="eq-row">

            <strong><?= $char++; ?>)</strong>

            <!-- GIVEN FRACTION -->
            <span class="vfrac">
                <span class="num"><?= htmlspecialchars($frac_num) ?></span>
                <span class="den"><?= htmlspecialchars($frac_den) ?></span>
            </span>

            <span>=</span>

            <!-- INTERMEDIATE -->
            <div class="frac-input-box">
                <input type="text"
                       class="num-input f1-num"
                       data-qid="<?= $qid ?>"
                       maxlength="3">
                <input type="text"
                       class="den-input f1-den"
                       data-qid="<?= $qid ?>"
                       maxlength="3">
            </div>

            <span>=</span>

            <!-- FINAL -->
            <div class="frac-input-box">
                <input type="text"
                       class="num-input f2-num"
                       data-qid="<?= $qid ?>"
                       maxlength="3">
                <input type="text"
                       class="den-input f2-den"
                       data-qid="<?= $qid ?>"
                       maxlength="3">
            </div>

        </div>
    </div>
</div>

<!-- ✅ ONLY THIS IS SUBMITTED -->
<input type="hidden"
       name="answer[<?= $qid ?>]"
       id="final-answer-<?= $qid ?>"
       value="">

<input type="hidden" name="expected[<?= $qid ?>]" value="<?= htmlspecialchars($expected) ?>">
<input type="hidden" name="question_id[]" value="<?= $qid ?>">

<script>
(function(){
    const qid = <?= $qid ?>;

    const f1n = document.querySelector('.f1-num[data-qid="'+qid+'"]');
    const f1d = document.querySelector('.f1-den[data-qid="'+qid+'"]');
    const f2n = document.querySelector('.f2-num[data-qid="'+qid+'"]');
    const f2d = document.querySelector('.f2-den[data-qid="'+qid+'"]');
    const out = document.getElementById('final-answer-'+qid);

    function v(el){ return el ? el.value.trim() : ''; }

    function update(){
        const a = v(f1n), b = v(f1d);
        const c = v(f2n), d = v(f2d);

        // 🔑 NOTHING typed → SKIPPED
        if (!a && !b && !c && !d){
            out.value = '';
            return;
        }

        // 🔑 Final box has priority
        if (c && d){
            out.value = c + '/' + d;
            return;
        }

        // 🔑 Intermediate only
        if (a && b){
            out.value = a + '/' + b;
            return;
        }

        // partial typing → still skip
        out.value = '';
    }

    [f1n,f1d,f2n,f2d].forEach(el=>{
        if(!el) return;
        el.addEventListener('input', update);
        el.addEventListener('blur', update);
    });
})();
</script>
