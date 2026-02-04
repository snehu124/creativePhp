<?php
$payload     = json_decode($q['question_payload'], true);
$numerator   = (int)$payload['numerator'];
$denominator = (int)$payload['denominator'];

$whole     = intdiv($numerator, $denominator);
$remainder = $numerator % $denominator;
$expected  = $whole . ' ' . $remainder . '/' . $denominator;
$qid = (int)$q['id'];
?>
<style>
.qcard{
    background:#fff;
    padding:12px 18px;
    margin:8px 0;
    border-radius:10px;
    box-shadow:0 2px 6px rgba(0,0,0,.08);
}
.qcard h6{font-size:16px;font-weight:600;margin:0}
.vfrac{display:inline-flex;flex-direction:column;align-items:center;font-family:'Cambria Math',serif}
.vfrac .num{border-bottom:2px solid #000;font-size:18px}
.vfrac .den{font-size:18px}
.ans{display:flex;gap:8px}
.box{
    width:50px;height:36px;border:2px solid #000;
    border-radius:6px;text-align:center;font-size:18px;
}
.f{position:relative}
.f .line{position:absolute;left:0;right:0;top:50%;border-top:2px solid #000}
</style>

<div class="col-lg-4 col-md-4 col-sm-12">
    <div class="qcard">
        <div class="row align-items-center">
            <div class="col-7">
                <h6>
                    <strong><?= $char++; ?>)</strong>
                    <span class="vfrac">
                        <span class="num"><?= $numerator ?></span>
                        <span class="den"><?= $denominator ?></span>
                    </span> =
                </h6>
            </div>

            <div class="col-5">
                <div class="ans">
                    <input type="text" class="box fi-whole" data-qid="<?= $qid ?>" maxlength="2">
                    <div class="f">
                        <input type="text" class="box fi-num" data-qid="<?= $qid ?>" maxlength="2">
                        <div class="line"></div>
                        <input type="text" class="box fi-den" data-qid="<?= $qid ?>" maxlength="2">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ THIS is what submit_quiz will read -->
<input type="hidden" name="answer[<?= $qid ?>]" id="fi-answer-<?= $qid ?>" value="">

<script>
(function(){
    const qid = <?= $qid ?>;
    const whole = document.querySelector('.fi-whole[data-qid="'+qid+'"]');
    const num   = document.querySelector('.fi-num[data-qid="'+qid+'"]');
    const den   = document.querySelector('.fi-den[data-qid="'+qid+'"]');
    const out   = document.getElementById('fi-answer-'+qid);

    function update(){
        const w = whole.value.trim();
        const n = num.value.trim();
        const d = den.value.trim();

        if (w || n || d) {
            out.value = (w ? w : '0') + ' ' + (n ? n : '0') + '/' + (d ? d : '1');
        } else {
            out.value = '';
        }
    }

    [whole,num,den].forEach(i => {
        i.addEventListener('input', update);
        i.addEventListener('blur', update);
    });
})();
</script>

<!-- Hidden for result page -->
<input type="hidden" name="expected[<?= $qid ?>]" value="<?= htmlspecialchars($expected) ?>">
<input type="hidden" name="question_id[]" value="<?= $qid ?>">
