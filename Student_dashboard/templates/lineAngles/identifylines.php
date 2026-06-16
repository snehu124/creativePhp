<?php

$image = $q['question_image'] ?? '';

$section_id = $q['instruction_id'] ?? 0;

if (!isset($GLOBALS['section_question'][$section_id])) {
    $GLOBALS['section_question'][$section_id] = 1;
}

?>

<style>

.lines-box{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.lines-main{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:30px;
    flex-wrap:wrap;
}

.lines-left{
    flex:1;
}

.lines-right{
    width:220px;
    flex-shrink:0;
}

.lines-right img{
    width:100%;
    height:auto;
}

.lines-row{
    display:flex;
    align-items:center;
    gap:15px;
    font-size:22px;
}

.lines-select{
    width:260px;
    height:45px;
    font-size:18px;
}

</style>

<div class="lines-box">

    <div class="lines-main">

        <div class="lines-left">

            <div class="lines-row">

                <strong>
                    <?= $GLOBALS['section_question'][$section_id]++ ?>)
                </strong>

                <span>Answer:</span>

                <select
                    class="lines-select"
                    name="answer[<?= $q['id'] ?>]"
                >
                    <option value="">Select</option>

                    <option value="Intersecting Lines">
                        Intersecting Lines
                    </option>

                    <option value="Parallel Lines">
                        Parallel Lines
                    </option>

                    <option value="Perpendicular Lines">
                        Perpendicular Lines
                    </option>

                </select>

            </div>

        </div>

        <?php if(!empty($image)) { ?>
        <div class="lines-right">
            <img src="<?= $image ?>" alt="">
        </div>
        <?php } ?>

    </div>

</div>