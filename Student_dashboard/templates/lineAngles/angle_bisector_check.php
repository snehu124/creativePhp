<?php

$data = json_decode(
    $q['question_payload'] ?? '{}',
    true
);

$image = $q['question_image'] ?? '';
$statement = $data['statement'] ?? '';

$section_id = $q['instruction_id'] ?? 0;

if (!isset($GLOBALS['section_question'][$section_id])) {
    $GLOBALS['section_question'][$section_id] = 1;
}

?>

<style>

.bisector-box{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.bisector-main{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:25px;
    flex-wrap:wrap;
}

.bisector-left{
    flex:1;
    min-width:250px;
}

.bisector-right{
    width:220px;
    flex-shrink:0;
}

.bisector-right img{
    width:100%;
    height:auto;
}

.bisector-title{
    font-size:22px;
    margin-bottom:20px;
}

.bisector-row{
    display:flex;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.bisector-select{
    width:180px;
    height:42px;
    font-size:18px;
}

</style>

<div class="bisector-box">

    <div class="bisector-main">

        <div class="bisector-left">

            <div class="bisector-title">

                <strong>
                    <?= $GLOBALS['section_question'][$section_id]++ ?>)
                </strong>

                <?= htmlspecialchars($statement) ?>

            </div>

            <div class="bisector-row">

                <strong>Answer:</strong>

                <select
                    class="bisector-select"
                    name="answer[<?= $q['id'] ?>]"
                >
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>

            </div>

        </div>

        <?php if(!empty($image)): ?>
        <div class="bisector-right">
            <img
                src="<?= htmlspecialchars($image) ?>"
                alt=""
            >
        </div>
        <?php endif; ?>

    </div>

</div>