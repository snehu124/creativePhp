<?php

$payload=json_decode($q['question_payload'],true);

$options=$payload['options'] ?? [];

?>

<style>

.mcq-card{
    background:#fff;
    padding:18px;
    margin:15px auto;
    border-radius:10px;
    box-shadow:0 2px 6px rgba(0,0,0,.08);
}

.option-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:15px;

margin-top:15px;

}

.option{

display:flex;

align-items:center;

gap:8px;

font-size:17px;

}

.option input{

width:18px;

height:18px;

cursor:pointer;

}

@media(max-width:768px){

.option-grid{

grid-template-columns:1fr;

}

}

</style>

<div class="mcq-card">

<h6><?= $char.'. '.htmlspecialchars($q['question_text']) ?></h6>

<?php $char++; ?>

<div class="option-grid">

<?php foreach($options as $option){ ?>

<label class="option">

<input

type="radio"

name="answer[<?= $q['id']?>]"

value="<?= htmlspecialchars($option) ?>">

<span><?= htmlspecialchars($option) ?></span>

</label>

<?php } ?>

</div>

</div>