<?php

$q = $q ?? [];

$id = (int)($q['id'] ?? 0);

$payload = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];

$left   = $payload['left'] ?? '';
$middle = $payload['middle'] ?? '';
$right  = $payload['right'] ?? '';
$target = $payload['target'] ?? '';

?>

<style>

.nl-question{
    margin-bottom:70px;
}

.nl-no{
    font-size:22px;
    font-weight:600;
    margin-bottom:20px;
}

.nl-roots{
    font-size:22px;
    margin-top: -40px;
    margin-left: 47px;

}

.nl-roots span{
    margin-right:24px;
}

/* square root with top line */
.root-wrap{
    display:inline-flex;
    align-items:flex-start;
}

.root-sign{
    font-size:26px;
    line-height:1.25;
    margin-right:-4px !important;
    margin-top:6px;
    display:inline-block;
    transform-origin:bottom;
    transform:scaleY(1.55);
}

.root-top{
    border-top:2px solid #000;
    padding:0 6px;
    line-height:1.1;
    font-size:22px;
}


.nl-svg{
    width:700px;
    max-width:100%;
    display:block;
    margin:15px 0 40px;
    font-size:22px;
    font-weight:600;
}

.nl-answer{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    padding-left:40px;
    font-size:22px;
}

.blank{
    width:110px;
    border:none;
    border-bottom:2px solid #000;
    background:transparent;
    text-align:center;
    font-size:22px;
    outline:none;
}

</style>

<div class="nl-question">

    <div class="nl-no">
        <?= ($index + 1) ?>)
    </div>

<div class="nl-roots">

    <?php if($left !== ''): ?>
    <span class="root-wrap">
        <span class="root-sign">√</span>
        <span class="root-top"><?= $left ?></span>
    </span>
    <?php endif; ?>

    <?php if($middle !== ''): ?>
    <span class="root-wrap">
        <span class="root-sign">√</span>
        <span class="root-top"><?= $middle ?></span>
    </span>
    <?php endif; ?>

    <?php if($right !== ''): ?>
    <span class="root-wrap">
        <span class="root-sign">√</span>
        <span class="root-top"><?= $right ?></span>
    </span>
    <?php endif; ?>

</div>

    <svg class="nl-svg" viewBox="0 0 760 120">

    <line x1="80" y1="60"
          x2="680" y2="60"
          stroke="#000"
          stroke-width="3"/>

    <line x1="140" y1="40"
          x2="140" y2="80"
          stroke="#000"
          stroke-width="3"/>

    <line x1="380" y1="40"
          x2="380" y2="80"
          stroke="#000"
          stroke-width="3"/>

    <line x1="620" y1="40"
          x2="620" y2="80"
          stroke="#000"
          stroke-width="3"/>

    <!-- left arrow -->
    <line x1="80" y1="60" x2="92" y2="50" stroke="#000" stroke-width="3"/>
    <line x1="80" y1="60" x2="92" y2="70" stroke="#000" stroke-width="3"/>

    <!-- right arrow -->
    <line x1="680" y1="60" x2="668" y2="50" stroke="#000" stroke-width="3"/>
    <line x1="680" y1="60" x2="668" y2="70" stroke="#000" stroke-width="3"/>

</svg>

   <div class="nl-answer">

    <span class="root-wrap">
        <span class="root-sign">√</span>
        <span class="root-top"><?= $target ?></span>
    </span>

    <span>lies between</span>

    <input
        type="text"
        class="blank"
        name="answer[<?= $id ?>][left]"
    >

    <span>and</span>

    <input
        type="text"
        class="blank"
        name="answer[<?= $id ?>][right]"
    >

 <span>.</span>
 
</div>

</div>