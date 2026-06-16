<?php

$data = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];

$rows  = $data['rows'] ?? [];
$title = $data['title'] ?? '';

$section_id = isset($q['instruction_id'])
    ? $q['instruction_id']
    : 0;

if(!isset($GLOBALS['section_question'][$section_id])){
    $GLOBALS['section_question'][$section_id] = 1;
}
$layout = $data['layout'] ?? 'default';
?>

<style>

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
    margin-bottom:10px;
}

.geo-wrap{
    display:flex;
    justify-content:space-between;
    gap:30px;
    flex-wrap:wrap;
}

.geo-left{
    flex:1;
    min-width:300px;
}

.geo-right{
    width:400px;
    text-align:center;
}

.geo-right img{
    max-width:100%;
    width:100%;
    margin-top:-30px;
}

.geo-row{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:8px;
}

.geo-label{
    display:inline-block;
    min-width:90px;
    font-size:20px;
}

.geo-input{
    width:90px;
    border:none;
    border-bottom:2px solid #000;
    background:transparent;
    text-align:center;
    font-size:18px;
    outline:none;
}

.geo-select{
    min-width:270px;
    height:40px;
    font-size:16px;
}

</style>

<div class="geo-card">

<div class="geo-title">

<?= $GLOBALS['section_question'][$section_id]++ ?>)

<?= htmlspecialchars($title) ?>

</div>

<div class="geo-wrap">

<div class="geo-left">

<?php if($layout == 'corresponding_parts'): ?>

<div style="font-size:20px;font-weight:bold;margin-bottom:20px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-top: -41px;margin-left: 30px;">
    <span><u>Sides:</u></span>
    <span><?= htmlspecialchars($data['sides_title'] ?? '') ?></span>
</div>

<?php foreach($data['sides'] ?? [] as $row): ?>

<div class="geo-row">

<?php if(isset($row['prefix'])): ?>

    <?= htmlspecialchars($row['prefix']) ?>

    <input
    type="text"
    class="geo-input"
    name="answer[<?= $q['id'] ?>][<?= $row['answer_key'] ?>]"
    >

    <?= htmlspecialchars($row['suffix'] ?? '') ?>

<?php elseif(isset($row['suffix'])): ?>

    <input
    type="text"
    class="geo-input"
    name="answer[<?= $q['id'] ?>][<?= $row['answer_key'] ?>]"
    >

    <?= htmlspecialchars($row['suffix']) ?>

<?php else: ?>

    <input
    type="text"
    class="geo-input"
    name="answer[<?= $q['id'] ?>][<?= $row['answer_key'] ?>]"
    >

<?php endif; ?>

</div>

<?php endforeach; ?>


    <br>

    <div class="geo-row">

        ∴ △<?= htmlspecialchars($data['triangle1'] ?? '') ?>

        <select
        class="geo-select"
        style="width:80px;min-width:80px;text-align: center;"
        name="answer[<?= $q['id'] ?>][congruent]"
        >
        <option value="">Select</option>
        <option value="≅">≅</option>
        <option value="≡">≡</option>
        </select>

        △<?= htmlspecialchars($data['triangle2'] ?? '') ?>

    </div>

    <br>

<div style="font-size:20px;font-weight:bold;margin:30px 0 20px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    <span><u>Angles:</u></span>
    <span><?= htmlspecialchars($data['angles_title'] ?? '') ?></span>
</div>

<?php foreach($data['angles'] ?? [] as $row): ?>

<div class="geo-row">

<?php if(isset($row['prefix'])): ?>

    <?= htmlspecialchars($row['prefix']) ?>

    <input
    type="text"
    class="geo-input angle-input"
    name="answer[<?= $q['id'] ?>][<?= $row['answer_key'] ?>]"
    >

    <?= htmlspecialchars($row['suffix'] ?? '') ?>

<?php elseif(isset($row['suffix'])): ?>

    <input
    type="text"
    class="geo-input angle-input"
    name="answer[<?= $q['id'] ?>][<?= $row['answer_key'] ?>]"
    >

    <?= htmlspecialchars($row['suffix']) ?>

<?php else: ?>

    <input
    type="text"
    class="geo-input angle-input"
    name="answer[<?= $q['id'] ?>][<?= $row['answer_key'] ?>]"
    >

<?php endif; ?>

</div>

<?php endforeach; ?>

<?php else: ?>

<?php foreach($rows as $row): ?>

<div class="geo-row">

<span class="geo-label">

<?php

$displayLabel = trim($row['label']);

$displayLabel = str_replace(
    ['<','&lt;'],
    '∠',
    $displayLabel
);

if(
    preg_match('/^\d+$/',$displayLabel)
){
    $displayLabel = '∠' . $displayLabel;
}

?>

<?= htmlspecialchars($displayLabel) ?>

:

</span>

<?php

$inputs = (int)($row['inputs'] ?? 1);

if(isset($row['options'])):

?>

<select
    class="geo-select"
    name="answer[<?= $q['id'] ?>][<?= $row['label'] ?>]"
>
    <option value="">Select</option>

    <?php foreach($row['options'] as $option): ?>

    <?php
    $value = $option;
    
    if(strpos($option,'°') !== false){
        preg_match('/(\d+)/',$option,$m);
        $value = $m[1];
    }
    ?>
    
    <option value="<?= htmlspecialchars($value) ?>">
        <?= htmlspecialchars($option) ?>
    </option>

    <?php endforeach; ?>

</select>

<?php

elseif($inputs == 1):
?>

<?php
$isAngle = strpos($row['label'], '∠') !== false
        || strpos($row['label'], '<') !== false;
?>

<?php if($isAngle): ?>

<span style="font-size:20px;font-weight:bold;">∠</span>

<input
    type="text"
    class="geo-input angle-input"
    data-angle="1"
    name="answer[<?= $q['id'] ?>][<?= $row['label'] ?>]"
    style="width:60px;"
>

<?php else: ?>

<input
    type="text"
    class="geo-input"
    name="answer[<?= $q['id'] ?>][<?= $row['label'] ?>]"
>

<?php endif; ?>

<?php

else:

for($i=0;$i<$inputs;$i++):

$suffix = chr(97 + $i);

$isAngle = strpos($row['label'], '∠') !== false
        || strpos($row['label'], '<') !== false;
?>

<?php if($isAngle): ?>
<span style="font-size:20px;font-weight:bold;">∠</span>
<?php endif; ?>

<input
    type="text"
    class="geo-input angle-input"
    name="answer[<?= $q['id'] ?>][<?= $row['label'] . $suffix ?>]"
    style="width:60px;"
>

<?php

if($i < ($inputs - 1)){
    echo ' + ';
}

endfor;

endif;


?>

</div>

<?php endforeach; ?>
<?php endif; ?>
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

            v = v.replace('∠','');
            v = v.replace('<','');

            el.value = '∠' + v;

        });

    });

});

</script>