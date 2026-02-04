<?php
// Safe payload decode
$payload = json_decode($q['question_payload'], true) ?? [];

$n1 = (int)($payload['n1'] ?? 0);
$d1 = (int)($payload['d1'] ?? 1);
$n2 = (int)($payload['n2'] ?? 0);
$d2 = (int)($payload['d2'] ?? 1);
$w1 = (int)($payload['w1'] ?? 0);
$w2 = (int)($payload['w2'] ?? 0);
$op = $payload['op'] ?? '+';

$qid = (int)$q['id'];
?>
<?php
if (!function_exists('renderMixed')) {
    function renderMixed($w, $n, $d){
        // Only whole number
        if ($w > 0 && $n == 0) {
            return '<span class="whole">'.$w.'</span>';
        }

        // Mixed fraction
        if ($w > 0 && $d > 1) {
            return '
            <span class="mixed">
                <span class="whole">'.$w.'</span>
                <span class="frac">
                    <input value="'.$n.'" readonly>
                    <div class="line"></div>
                    <input value="'.$d.'" readonly>
                </span>
            </span>';
        }

        // Proper / improper fraction
        if ($d > 1) {
            return '
            <span class="frac">
                <input value="'.$n.'" readonly>
                <div class="line"></div>
                <input value="'.$d.'" readonly>
            </span>';
        }

        // Fallback whole
        return '<span class="whole">'.$n.'</span>';
    }
}
?>

<style>
.qcard{
    background:#fff;
    padding:16px 20px;
    margin:12px 0;
    border-radius:12px;
    box-shadow:0 2px 6px rgba(0,0,0,.08);
}

/* Main row */
.qrow{
    display:flex;
    align-items:center;
    gap:16px;
    font-size:16px;
    font-weight:600;
    flex-wrap: nowrap;            
}

/* Fraction block */
.frac{
    display:inline-flex;
    flex-direction:column;
    align-items:center;
    font-family:'Cambria Math','Times New Roman',serif;
    min-width:72px;
}

.frac input{
    width:72px;
    text-align:center;
    border:none;
    background:transparent;
    font-size:18px;
    outline:none;
}

.frac .line{
    width:100%;
    border-top:2px solid #000;
    margin:2px 0;
}

.frac input[readonly]{
    font-weight:600;
}
.mixed{
    display:inline-flex;
    align-items:center;
    gap:6px;
}


/* Operators */
.op{
    font-size:18px;
    font-weight:700;
    margin:0 4px;
    line-height:1;
}
.whole{
    font-size:18px;
    font-weight:600;
    min-width:40px;
    text-align:center;
    display:inline-block;
}


/* ---------------- MOBILE RESPONSIVE ---------------- */
@media (max-width: 768px){
    .qrow{
        flex-wrap: wrap;            
        row-gap:12px;
    }

    .frac{
        min-width:64px;
    }

    .frac input{
        width:64px;
        font-size:16px;
    }

    .op{
        font-size:16px;
    }
}

/* ---------------- SMALL MOBILE ---------------- */
@media (max-width: 480px){
    .qrow{
        font-size:15px;
    }

    .frac{
        min-width:58px;
    }

    .frac input{
        width:58px;
        font-size:15px;
    }
}
</style>

<div class="col-12">
  <div class="qcard">
<div class="qrow">
  <strong><?= $char++; ?>)</strong>

<?= renderMixed($w1, $n1, $d1); ?>
<span class="op"><?= htmlspecialchars($op) ?></span>
<?= renderMixed($w2, $n2, $d2); ?>


  <span class="op">=</span>

  <span class="frac">
    <input class="ans-num" data-qid="<?= $qid ?>">
    <div class="line"></div>
    <input class="ans-den" data-qid="<?= $qid ?>">
  </span>
</div>
  </div>
</div>

<!-- ✅ ONLY THIS GOES TO BACKEND -->
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

    const num = document.querySelector('.ans-num[data-qid="'+qid+'"]');
    const den = document.querySelector('.ans-den[data-qid="'+qid+'"]');
    const out = document.getElementById('ans-'+qid);

    function update(){
        const n = num.value.trim();
        const d = den.value.trim();

        if(n && d){
            out.value = n + '/' + d;   
        }else{
            out.value = '';            
        }
    }

    [num, den].forEach(el=>{
        el.addEventListener('input', update);
        el.addEventListener('blur', update);
    });
})();
</script>
