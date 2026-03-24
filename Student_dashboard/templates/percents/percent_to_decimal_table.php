<?php

$data = json_decode($q['question_payload'], true);
$correct = json_decode($q['correct_answer'] ?? '{}', true);

$percents = $data['percents'] ?? [];
$correct_decimal = $correct['decimal'] ?? [];

$student = json_decode($q['student_answer'] ?? '{}', true);
$student_decimal = $student['decimal'] ?? [];

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
}

.percent-input{
width:120px;
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
<th>Decimal</th>
</tr>
</thead>

<tbody>

<?php foreach($percents as $i=>$percent):

$student_val = $student_decimal[$i] ?? '';
$correct_val = $correct_decimal[$i] ?? '';

$class = '';

if(isset($is_result_page) && $student_val !== ''){
$class = ($student_val == $correct_val) ? "correct-cell" : "wrong-cell";
}

?>

<tr>

<td><?= $i+1 ?>)</td>

<td><?= $percent ?></td>

<td class="<?= $class ?>">

<input type="text"
name="answer[<?= $q['id'] ?>][decimal][]"
value="<?= htmlspecialchars($student_val) ?>"
class="percent-input">

<?php if(isset($is_result_page) && $student_val != $correct_val): ?>
<div style="color:green;font-size:14px;">
Correct: <?= $correct_val ?>
</div>
<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>