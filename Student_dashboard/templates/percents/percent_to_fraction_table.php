<?php

$data = json_decode($q['question_payload'], true);
$correct = json_decode($q['correct_answer'] ?? '{}', true);

$percents = $data['percents'] ?? [];
$correct_frac = $correct['fraction'] ?? [];

$student = json_decode($q['student_answer'] ?? '{}', true);
$student_frac = $student['fraction'] ?? [];

?>

<style>

.percent-table-box{
background:#fff;
padding:25px;
border-radius:14px;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
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
}

.fraction-input{
width:60px;
border:none;
border-bottom:2px solid #000;
text-align:center;
font-size:18px;
background:transparent;
outline:none;
}

.correct-cell{
background:#d4edda;
}

.wrong-cell{
background:#f8d7da;
}

</style>


<div class="percent-table-box">

<table class="percent-table">

<thead>
<tr>
<th>S.No</th>
<th>Percent</th>
<th>Fraction</th>
</tr>
</thead>

<tbody>

<?php foreach($percents as $i=>$percent):

$student_n = $student_frac[$i]['n'] ?? '';
$student_d = $student_frac[$i]['d'] ?? '';

$correct_n = $correct_frac[$i]['n'] ?? '';
$correct_d = $correct_frac[$i]['d'] ?? '';

$class = '';

if(isset($is_result_page) && ($student_n !== '' || $student_d !== '')){
$class = ($student_n==$correct_n && $student_d==$correct_d) ? "correct-cell" : "wrong-cell";
}

?>

<tr>

<td><?= $i+1 ?>)</td>

<td><?= $percent ?></td>

<td class="<?= $class ?>">

<input type="text"
name="answer[<?= $q['id'] ?>][fraction][<?= $i ?>][n]"
class="fraction-input">

/

<input type="text"
name="answer[<?= $q['id'] ?>][fraction][<?= $i ?>][d]"
class="fraction-input">

<?php if(isset($is_result_page) && ($student_n!=$correct_n || $student_d!=$correct_d)): ?>
<div style="color:green;font-size:14px;margin-top:5px;">
Correct: <?= $correct_n ?>/<?= $correct_d ?>
</div>
<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>