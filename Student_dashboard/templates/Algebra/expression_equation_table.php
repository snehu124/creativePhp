<?php

$data = json_decode($q['question_payload'] ?? '{}', true);
$correct = json_decode($q['correct_answer'] ?? '{}', true);

$rows = $data['rows'] ?? [];

?>

<style>

.expression-table-box{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 4px 10px rgba(0,0,0,.10);
    margin-bottom:25px;
}

.expression-table{
    width:100%;
    border-collapse:collapse;
}

.expression-table th,
.expression-table td{
    border:2px solid #ff4d4d;
    padding:12px;
    vertical-align:middle;
}

.expression-table th{
    background: #f7f7f7;
    font-weight: 600;
    text-align: center;
}

.statement-col{
    width:40%;
}

.exp-input{
    width:100%;
    border:none;
    border-bottom:2px solid #ff4d4d;
    background:transparent;
    outline:none;
    padding:5px;
    text-align:center;
}

.eq-input{
    width:100%;
    border:none;
    border-bottom:2px solid #ff4d4d;
    background:transparent;
    outline:none;
    padding:5px;
    text-align:center;
}

@media(max-width:768px){

    .expression-table th,
    .expression-table td{
        font-size:14px;
        padding:8px;
    }

}

</style>

<div class="expression-table-box">

<table class="expression-table">

<thead>
<tr>
    <th>STATEMENT</th>
    <th>EXPRESSION</th>
    <th>EQUATION</th>
</tr>
</thead>

<tbody>

<?php foreach($rows as $i=>$row): ?>

<tr>

<td class="statement-col">
    <?= ($i+1) ?>) <?= htmlspecialchars($row) ?>
</td>

<td>
<input
type="text"
class="exp-input"
name="answer[<?= $q['id'] ?>][expression][<?= $i ?>]">
</td>

<td>
<input
type="text"
class="eq-input"
name="answer[<?= $q['id'] ?>][equation][<?= $i ?>]">
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>