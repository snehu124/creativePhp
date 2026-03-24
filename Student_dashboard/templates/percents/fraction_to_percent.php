<?php

$data = json_decode($q['question_payload'], true);

$n = $data['numerator'] ?? '';
$d = $data['denominator'] ?? '';

$section_id = $q['instruction_id'] ?? 0;

if (!isset($GLOBALS['section_question'][$section_id])) {
    $GLOBALS['section_question'][$section_id] = 1;
}

?>

<style>

.fraction-percent-box{
background:#fff;
padding:25px;
border-radius:14px;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
margin-bottom:25px;
}

/* Main row */
.fraction-row{
display:flex;
align-items:center;
gap:15px;
flex-wrap:wrap;
}

/* question number */
.question-number{
font-size:20px;
font-weight:600;
margin-right:10px;
}

/* Fraction */
.fraction-display{
display:flex;
flex-direction:column;
align-items:center;
font-size:26px;
font-weight:600;
line-height:1.1;
}

.fraction-line{
width:30px;
border-top:2px solid #000;
margin:3px 0;
}

/* equals sign */
.equal-sign{
font-size:26px;
font-weight:bold;
}

/* input */
.percent-input{
width:130px;
border:none;
border-bottom:2px solid #000;
text-align:center;
font-size:20px;
outline:none;
background:transparent;
padding:4px;
}

/* percent */
.percent-symbol{
font-size:20px;
font-weight:600;
}

/* responsive */

@media (max-width:768px){

.fraction-display{
font-size:22px;
}

.equal-sign{
font-size:22px;
}

.percent-input{
width:100px;
font-size:18px;
}

}

@media (max-width:480px){

.fraction-percent-box{
padding:18px;
}

.fraction-display{
font-size:20px;
}

.percent-input{
width:80px;
font-size:16px;
}

}

</style>


<div class="fraction-percent-box">

<div class="fraction-row">

<div class="question-number">
<?= $GLOBALS['section_question'][$section_id]++ ?>)
</div>

<div class="fraction-display">
<div><?= $n ?></div>
<div class="fraction-line"></div>
<div><?= $d ?></div>
</div>

<div class="equal-sign">=</div>

<input type="text"
name="answer[<?= $q['id'] ?>]"
class="percent-input">

<div class="percent-symbol">%</div>

</div>

</div>