<?php

$data = json_decode($q['question_payload'] ?? '{}', true) ?: [];

$section_id = $q['instruction_id'] ?? 0;

if(!isset($GLOBALS['section_question'][$section_id])){
    $GLOBALS['section_question'][$section_id] = 1;
}
?>

<style>

.geo-wrap{
    display:flex;
    justify-content:space-between;
    gap:40px;
    flex-wrap:wrap;
}

.geo-left{
    flex:1;
    min-width:320px;
}

.geo-right{
    width:420px;
    text-align:center;
}

.geo-right img{
    max-width:100%;
    width:100%;
}

.geo-row{
    margin-bottom:20px;
    font-size:22px;
}

.geo-input{
    width:140px;
    border:none;
    border-bottom:2px solid #000;
    background:transparent;
    text-align:center;
    font-size:18px;
    outline:none;
}

.geo-triangle{
    width:100px;
}

.geo-select{
    width:180px;
    height:40px;
    font-size:16px;
    text-align: center;
}

.geo-card{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.geo-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:25px;
}

</style>

<div class="geo-card">

<div class="geo-title">
<?= $GLOBALS['section_question'][$section_id]++ ?>)
<?= htmlspecialchars($data['title']) ?>
</div>

<div class="geo-wrap">

<div class="geo-left">

<?php foreach($data['rows'] as $row): ?>

<?php
$isAngle =
    strpos($row['label'], '∠') !== false;
?>

<div class="geo-row">

<?php if($isAngle): ?>

<?= htmlspecialchars($row['label']) ?> =

<span style="font-size:22px;font-weight:bold;">∠</span>

<input
type="text"
class="geo-input angle-input"
style="width:100px;"
name="answer[<?= $q['id'] ?>][<?= $row['label'] ?>]"
>

<?php else: ?>

<?= htmlspecialchars($row['label']) ?> =

<input
type="text"
class="geo-input"
name="answer[<?= $q['id'] ?>][<?= $row['label'] ?>]"
>

<?php endif; ?>

</div>

<?php endforeach; ?>

<br>

<div class="geo-row">

∴ △

<input
type="text"
class="geo-input geo-triangle"
name="answer[<?= $q['id'] ?>][triangle1]"
>

≅

△

<input
type="text"
class="geo-input geo-triangle"
name="answer[<?= $q['id'] ?>][triangle2]"
>

</div>

<br>

<div class="geo-row">

Rule :

<select
class="geo-select"
name="answer[<?= $q['id'] ?>][rule]"
>
<option value="">Select</option>
<option value="SSS">SSS</option>
<option value="SAS">SAS</option>
<option value="ASA">ASA</option>
<option value="AAS">AAS</option>
<option value="RHS">RHS</option>
</select>

</div>

</div>

<?php if(!empty($q['question_image'])): ?>

<div class="geo-right">

<img
src="<?= htmlspecialchars($q['question_image']) ?>"
alt=""
>

</div>

<?php endif; ?>

</div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function(){

    const form = document.querySelector('form');

    if(!form) return;

    form.addEventListener('submit', function(){

        document.querySelectorAll('.angle-input').forEach(function(el){

            let v = el.value.trim();

            if(v === '') return;

            if(v.indexOf('∠') !== 0){
                el.value = '∠' + v;
            }

        });

    });

});
</script>