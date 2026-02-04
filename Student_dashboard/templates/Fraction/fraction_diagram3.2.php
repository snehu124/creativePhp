<?php
$q    = $q ?? [];
$char = $char ?? 'a';

$fractions = json_decode($q['question_payload'] ?? '{}', true);
if (!is_array($fractions) || empty($fractions)) return;

// detect denominator
$denominator = 0;
foreach ($fractions as $f) {
    if (strpos($f, '/') !== false) {
        [, $d] = array_map('intval', explode('/', $f));
        $denominator = max($denominator, $d);
    }
}

$colorHex = [
    'red'    => '#ff0000',
    'blue'   => '#0000ff',
    'green'  => '#00a651',
    'yellow' => '#ffd200',
    'pink'   => '#ff69b4'
];

$colors = [];
foreach ($fractions as $name => $f) {
    $key = strtolower($name);
    if (isset($colorHex[$key])) {
        $colors[$name] = $colorHex[$key];
    }
}
?>

<style>
/*.question-block{*/
/*    background:#fff;*/
/*    padding:20px;*/
/*    margin:20px 50px;*/
/*    border-radius:10px;*/
/*    box-shadow:0 2px 6px rgba(0,0,0,0.08);*/
/*}*/
.svg-box{
    width:220px;
    height:auto;
    overflow:visible;
}
.part{
    fill:#fff;
    stroke:#444;
    stroke-width:2;
    cursor:pointer;
}
.color-option{
    width:26px;height:26px;border-radius:50%;
    cursor:pointer;border:2px solid transparent;
}
.color-option.selected{border-color:#000}
.fraction-row{
    display:grid;
    grid-template-columns: 260px 1fr;
    gap:40px;
    align-items:center;
}

.fraction-right{
    text-align:left;
}

@media (max-width: 768px){
    .fraction-row{
        grid-template-columns: 1fr;
        gap:20px;
    }
    .svg-box{
        margin:auto;
    }
}

</style>

<div class="quiz-box mb-4">
    <p class="fw-bold">(<?= htmlspecialchars($char) ?>)</p>

<input type="hidden"
       name="answer[<?= (int)$q['id'] ?>]"
       id="fraction-answer-<?= (int)$q['id'] ?>"
       value="">

<!--<div style="display:flex;gap:30px;flex-wrap:wrap;align-items:center">-->
<div class="fraction-row">

<svg viewBox="0 0 260 260" class="svg-box">

<?php
/* ===== CASE A : CIRCLE (3) ===== */
if ($denominator === 3) {
?>
<path class="part" data-q="<?= $q['id'] ?>"
 d="M100,80 L100,0 A80,80 0 0,1 169,120 Z"/>
<path class="part" data-q="<?= $q['id'] ?>"
 d="M100,80 L169,120 A80,80 0 0,1 31,120 Z"/>
<path class="part" data-q="<?= $q['id'] ?>"
 d="M100,80 L31,120 A80,80 0 0,1 100,0 Z"/>
<?php }

/* ===== CASE B : TRIANGLES (10) ===== */
elseif ($denominator === 10) {
    $size = 36;
    $h = $size * 0.866;

    // ▲ top row
    for ($i=0;$i<5;$i++):
        $x = 30 + $i*$size;
        $y = 30;
?>
<polygon class="part" data-q="<?= $q['id'] ?>"
 points="<?= $x ?>,<?= $y+$h ?> <?= $x+$size/2 ?>,<?= $y ?> <?= $x+$size ?>,<?= $y+$h ?>" />
<?php endfor;

    // ▼ bottom row
    for ($i=0;$i<5;$i++):
        $x = 48 + $i*$size;
        $y = 30 + $h;
?>
<polygon class="part" data-q="<?= $q['id'] ?>"
 points="<?= $x ?>,<?= $y ?> <?= $x+$size ?>,<?= $y ?> <?= $x+$size/2 ?>,<?= $y+$h ?>" />
<?php endfor;
}

/* ===== CASE C : GRID (12) ===== */
elseif ($denominator === 12) {
    for ($y=0;$y<4;$y++):
        for ($x=0;$x<3;$x++):
?>
<rect class="part" data-q="<?= $q['id'] ?>"
 x="<?= $x*60 ?>" y="<?= $y*40 ?>" width="60" height="40"/>
<?php endfor; endfor;
}

/* ===== CASE D : SQUARE (4) ===== */
elseif ($denominator === 4) {
?>
<polygon class="part" data-q="<?= $q['id'] ?>" points="30,30 130,130 30,230"/>
<polygon class="part" data-q="<?= $q['id'] ?>" points="30,30 230,30 130,130"/>
<polygon class="part" data-q="<?= $q['id'] ?>" points="230,30 230,230 130,130"/>
<polygon class="part" data-q="<?= $q['id'] ?>" points="30,230 230,230 130,130"/>
<?php } ?>

</svg>

<div class="fraction-right">
<strong>Select Color</strong><br><br>

<div style="display:flex;gap:10px;margin-bottom:15px">
<?php foreach ($colors as $name=>$hex): ?>
<div class="color-option"
 data-q="<?= $q['id'] ?>"
 data-color="<?= $hex ?>"
 style="background:<?= $hex ?>"></div>
<?php endforeach; ?>
</div>

<?php foreach ($fractions as $name=>$f): ?>
<div><?= htmlspecialchars($name) ?> = <?= htmlspecialchars($f) ?></div>
<?php endforeach; ?>
</div>

</div>
</div>

<script>
(function(qid){
 let selected=null, count={};

 document.querySelectorAll('.color-option[data-q="'+qid+'"]').forEach(c=>{
  c.onclick=()=>{
    document.querySelectorAll('.color-option[data-q="'+qid+'"]').forEach(o=>o.classList.remove('selected'));
    c.classList.add('selected');
    selected=c.dataset.color;
  };
 });

 document.querySelectorAll('.part[data-q="'+qid+'"]').forEach(p=>{
  p.onclick=()=>{
    if(!selected) return;
    const old=p.dataset.fill;
    if(old) count[old]--;
    p.style.fill=selected;
    p.dataset.fill=selected;
    count[selected]=(count[selected]||0)+1;
    build();
  };
 });

 function build(){
  const out=[], d=<?= $denominator ?>;
  <?php foreach ($colors as $name=>$hex): ?>
    if(count["<?= $hex ?>"])
      out.push("<?= $name ?>="+count["<?= $hex ?>"]+"/"+d);
  <?php endforeach; ?>
  document.getElementById("fraction-answer-"+qid).value=out.sort().join("|");
 }
})(<?= $q['id'] ?>);
</script>

<?php $char++; ?>
