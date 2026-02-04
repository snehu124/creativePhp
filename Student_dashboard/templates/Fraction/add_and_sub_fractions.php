<?php
$payload = json_decode($q['question_payload'], true);
$num1 = (int)$payload['num1'];
$num2 = (int)$payload['num2'];
$den  = (int)$payload['den'];
$op   = $payload['op'];
$qid  = (int)$q['id'];
?>

<style>
.qcard{background:#fff;padding:14px 18px;margin:10px 0;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.08);}
.qrow{display:flex;align-items:center;gap:10px;font-size:16px;font-weight:600;white-space:nowrap;}
.frac{display:inline-flex;flex-direction:column;align-items:center;font-family:'Cambria Math',serif}
.frac input{width:48px;text-align:center;border:none;background:transparent;font-size:16px;outline:none}
.frac .line{width:48px;border-top:2px solid #000;margin:2px 0}
.op{font-size:18px;font-weight:700}
</style>

<div class="<?= isset($is_result_page) ? 'col-12' : 'col-lg-6 col-md-6 col-sm-12' ?>">
  <div class="qcard">
    <div class="qrow">
      <strong><?= $char++; ?>)</strong>

      <span class="frac">
        <input value="<?= $num1 ?>" readonly>
        <div class="line"></div>
        <input value="<?= $den ?>" readonly>
      </span>

      <span class="op"><?= $op ?></span>

      <span class="frac">
        <input value="<?= $num2 ?>" readonly>
        <div class="line"></div>
        <input value="<?= $den ?>" readonly>
      </span>

      <span class="op">=</span>

      <!-- STEP (UI ONLY) -->
      <span class="frac">
        <input placeholder="5+4">
        <div class="line"></div>
        <input placeholder="<?= $den ?>">
      </span>

      <span class="op">=</span>

      <!-- FINAL ANSWER -->
      <span class="frac">
        <input class="final-num" data-qid="<?= $qid ?>" placeholder="9">
        <div class="line"></div>
        <input class="final-den" data-qid="<?= $qid ?>" placeholder="<?= $den ?>">
      </span>
    </div>
  </div>
</div>

<!-- ✅ ALWAYS ENABLED -->
<input type="hidden"
       name="answer[<?= $qid ?>]"
       id="ans-<?= $qid ?>"
       value="">

<input type="hidden"
       name="question_id[]"
       value="<?= $qid ?>">

<script>
(function(){
    const qid = <?= $qid ?>;

    const fn  = document.querySelector('.final-num[data-qid="'+qid+'"]');
    const fd  = document.querySelector('.final-den[data-qid="'+qid+'"]');
    const out = document.getElementById('ans-'+qid);

    function update(){
        const n = fn.value.trim();
        const d = fd.value.trim();

        if(n && d){
            out.value = n + '/' + d;   // ✅ attempt
        }else{
            out.value = '';           // ✅ skip
        }
    }

    [fn,fd].forEach(el=>{
        el.addEventListener('input',update);
        el.addEventListener('blur',update);
    });
})();
</script>
