<?php
/* ================= SUBPART FIX ================= */
if (!isset($subIndex)) {
    $subIndex = 0;
}

/* ================= DATA ================= */
$payload = json_decode($q['question_payload'], true) ?? [];
$correct = json_decode($q['correct_answer'], true) ?? [];

/* ================= DENOMINATOR FIX ================= */
/* Denominator hamesha correct_answer se lo */
$den = 0;
if (!empty($correct['left'])) {
    [, $den] = array_pad(explode('/', $correct['left']), 2, 0);
    $den = (int)$den;
}
if ($den <= 0) {
    $den = (int)($payload['denominator'] ?? 5); // fallback
}

/* positions */
$given  = $payload['given_positions'] ?? [];
$blanks = $payload['blank_positions'] ?? [];

[$lNum,$lDen] = array_pad(explode('/',$correct['left'] ?? ''),2,'');
[$rNum,$rDen] = array_pad(explode('/',$correct['right'] ?? ''),2,'');

$qid  = (int)$q['id'];
$char = chr(97 + $subIndex);
$subIndex++;
?>

<style>
.book-card{
    background:#fff;
    padding:28px;
    margin:25px auto;            
    border-radius:16px;
    box-shadow:0 2px 12px rgba(0,0,0,.08);
    position:relative;
}

.label{
    position:absolute;
    left:24px;
    top:24px;
    font-size:20px;
}

/* ✅ SVG CENTER FIX */
.svg-center{
    display:flex;
    justify-content:center;
    align-items:center;
    margin-top:10px;
}

/* invisible input on number line */
.line-input{
    width:26px;
    height:22px;
    border:none;
    outline:none;
    background:transparent;
    text-align:center;
    font-size:16px;
}

/* compare section */
.book-card .frac{
    display:flex;
    flex-direction:column;
    align-items:center;
}
.book-card .frac input{
    width:54px;
    height:38px;
    border:3px solid #0d6efd;
    border-radius:6px;
    text-align:center;
    font-size:18px;
}
.book-card .sign-box{
    width:54px;
    height:54px;
    border:3px solid #0d6efd;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.book-card .sign-box input{
    width:100%;
    height:100%;
    border:none;
    outline:none;
    background:none;
    font-size:26px;
    text-align:center;
}
.book-card .note{
    font-size:15px;
    margin-left:16px;
}
/* ================= RESPONSIVE SAFETY ================= */

.book-card{
    max-width:100%;
    box-sizing:border-box;
}

/* SVG container responsive */
.svg-center svg{
    max-width:100%;
    height:auto;
}

/* number line inputs scale safely */
.line-input{
    max-width:100%;
}

/* compare section wrap support */
.book-card .svg-center,
.book-card .compare-row{
    flex-wrap:wrap;
}

/* prevent horizontal overflow */
.book-card *{
    box-sizing:border-box;
}

/* 🔥 MOBILE OPTIMIZATION (no desktop change) */
@media (max-width: 576px){

    .book-card{
        padding:20px 16px;
    }

    .label{
        position:static;
        margin-bottom:8px;
        display:block;
        font-size:18px;
    }

    /* compare section stack nicely */
.book-card  .sign-box{
        width:48px;
        height:48px;
    }

.book-card .frac input{
        width:48px;
        height:36px;
        font-size:16px;
    }

.book-card .note{
        width:100%;
        margin-left:0;
        margin-top:6px;
        font-size:14px;
        text-align:center;
    }
}

</style>

<div class="book-card"
     data-qid="<?= $qid ?>"
     data-den="<?= $den ?>"
     data-left="<?= htmlspecialchars($correct['left'] ?? '', ENT_QUOTES) ?>"
     data-right="<?= htmlspecialchars($correct['right'] ?? '', ENT_QUOTES) ?>">
<div class="label"><?= $char ?>)</div>

<!-- ================= SVG NUMBER LINE ================= -->
<div class="svg-center">
    <svg viewBox="0 0 600 150" style="max-width:100%; height:auto;">

<!-- main line -->
<line x1="50" y1="60" x2="550" y2="60" stroke="#1f4fd8" stroke-width="4"/>

<!-- arrows -->
<polygon points="50,60 64,52 64,68" fill="#1f4fd8"/>
<polygon points="550,60 536,52 536,68" fill="#1f4fd8"/>

<?php
$step = 460 / $den;
for ($i = 0; $i <= $den; $i++):
    $x = 70 + $i * $step;
?>

<!-- tick -->
<line x1="<?= $x ?>" y1="48" x2="<?= $x ?>" y2="72" stroke="red" stroke-width="3"/>

<?php if ($i === 0): ?>
    <text x="<?= $x ?>" y="96" text-anchor="middle">0</text>
<?php else: ?>

    <?php if (in_array($i, $blanks, true)): ?>
        <text x="<?= $x ?>" y="96" text-anchor="middle" font-size="18">_</text>
        <foreignObject x="<?= $x-15 ?>" y="78" width="30" height="24">
            <input class="line-input line-num"
                   maxlength="1"
                   inputmode="numeric"
                   data-i="<?= $i ?>">
        </foreignObject>
    <?php else: ?>
        <text x="<?= $x ?>" y="96" text-anchor="middle"><?= $i ?></text>
    <?php endif; ?>

    <text x="<?= $x ?>" y="120" text-anchor="middle"><?= $den ?></text>
<?php endif; ?>

<?php endfor; ?>

<!-- circled 1 -->
<circle cx="430" cy="26" r="11" stroke="#0d6efd" fill="none" stroke-width="2"/>
<text x="430" y="30" text-anchor="middle" font-size="13" fill="#0d6efd">1</text>

</svg>
</div>

<!-- ================= COMPARE SECTION ================= -->
<div style="display:flex;align-items:center;margin-top:14px;justify-content:center;">
    
<div style="display:flex;align-items:center;gap:18px;">

    <div class="frac">
        <input value="<?= $lNum ?>" disabled>
        <input value="<?= $lDen ?>" disabled>
    </div>

    <div class="sign-box">
        <input type="text" class="sign" maxlength="1">
    </div>

    <div class="frac">
        <input value="<?= $rNum ?>" disabled>
        <input value="<?= $rDen ?>" disabled>
    </div>

</div>
<div class="note">( Put &gt; / &lt; )</div>
</div>
</div>

<!-- ================= HIDDEN ANSWERS ================= -->
<input type="hidden" name="answer[<?= $qid ?>]" id="final_answer_<?= $qid ?>">
<input type="hidden" name="question_id[]" value="<?= $qid ?>">

<script>
document.addEventListener("input", function(e){

  if(e.target.classList.contains("sign")){
    if(!['>','<'].includes(e.target.value)){
      e.target.value = '';
    }
  }

  document.querySelectorAll(".book-card").forEach(card=>{
    const qid   = card.dataset.qid;
    const den   = card.dataset.den;
    const left  = card.dataset.left;
    const right = card.dataset.right;

    let line = [];

    card.querySelectorAll(".line-num").forEach(inp=>{
      if(inp.value.trim()){
        line.push(inp.value.trim() + "/" + den);
      }
    });

    const sign = card.querySelector(".sign")?.value.trim();

    if(line.length === <?= count($blanks) ?> && sign){
      const answerObj = {
        left: left,
        sign: sign,
        right: right,
        line: line
      };

      document.getElementById("final_answer_"+qid).value =
        JSON.stringify(answerObj);
    }
  });
});
</script>
