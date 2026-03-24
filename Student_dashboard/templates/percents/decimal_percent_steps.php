<?php

$data = json_decode($q['question_payload'], true);
$correct = json_decode($q['correct_answer'] ?? '{}', true);

$decimals = $data['decimals'] ?? [];

$correct_step1 = $correct['step1'] ?? [];
$correct_step2 = $correct['step2'] ?? [];

?>

<style>

.percent-table-box{
background:#fff;
padding:25px;
border-radius:14px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
margin-bottom:25px;
}

.percent-table{
width:100%;
border-collapse:collapse;
}

.percent-table th,
.percent-table td{
border:2px solid #ff4d4d;
padding:15px;
text-align:center;
font-size:18px;
}

.percent-table th{
background:#f7f7f7;
font-weight:600;
}

.percent-input{
width:120px;
border:none;
border-bottom:2px solid #000;
text-align:center;
font-size:18px;
outline:none;
background:transparent;
}

.correct-cell{
background:#d4edda;
}

.wrong-cell{
background:#f8d7da;
}

@media(max-width:600px){

.percent-table th,
.percent-table td{
font-size:14px;
padding:10px;
}

.percent-input{
width:80px;
}

}

</style>

<div class="percent-table-box">

<table class="percent-table">

<thead>
<tr>
<th>S.No</th>
<th>Decimal Number</th>
<th>Step 1</th>
<th>Step 2 (%)</th>
</tr>
</thead>

<tbody>

<?php foreach($decimals as $i=>$decimal): 

$student = json_decode($q['student_answer'] ?? '{}', true);

$student_step1 = $student['step1'][$i] ?? '';
$student_step2 = $student['step2'][$i] ?? '';

$correct1 = $correct_step1[$i] ?? '';
$correct2 = $correct_step2[$i] ?? '';

$cls1 = ($student_step1 !== '' && $student_step1 == $correct1) ? "correct-cell" : ($student_step1 !== '' ? "wrong-cell" : "");
$cls2 = ($student_step2 !== '' && $student_step2 == $correct2) ? "correct-cell" : ($student_step2 !== '' ? "wrong-cell" : "");

?>

<tr>

<td><?= $i+1 ?>)</td>

<td><?= htmlspecialchars($decimal) ?></td>

<td class="<?= $cls1 ?>">

<input type="text"
name="answer[<?= $q['id'] ?>][step1][]"
value="<?= htmlspecialchars($student_step1) ?>"
class="percent-input">

<?php if(isset($is_result_page) && $student_step1 != $correct1): ?>
<div class="text-success small mt-1">Correct: <?= $correct1 ?></div>
<?php endif; ?>

</td>

<td class="<?= $cls2 ?>">

<input type="text"
name="answer[<?= $q['id'] ?>][step2][]"
value="<?= htmlspecialchars($student_step2) ?>"
class="percent-input">

<?php if(isset($is_result_page) && $student_step2 != $correct2): ?>
<div class="text-success small mt-1">Correct: <?= $correct2 ?></div>
<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>