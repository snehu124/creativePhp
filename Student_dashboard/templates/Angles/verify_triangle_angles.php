<?php

$q = $q ?? [];

$id = (int)($q['id'] ?? 0);

$payload = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];

$a = $payload['a'] ?? '';
$b = $payload['b'] ?? '';
$c = $payload['c'] ?? '';

$image = trim($q['question_image'] ?? '');

?>

<style>

.verify-wrap{
    position:relative;
    margin-bottom:50px;
}

.verify-row{
    margin-top:20px;
    align-items:flex-start;
    gap:40px;
    margin-top:20px;
}

.verify-left{
    flex:1;
}

.verify-image{
    position:absolute;
    top:20px;
    right:0;
    width:260px;
}

.verify-image img{
    width:100%;
    height:auto;
    display:block;
    margin-top: -58px;
}

.angle-set{
    font-size:22px;
    font-weight:600;
}

.answer-box{
    margin-top:25px;
}

.answer-input{
    width:330px;
    height:40px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:18px;
    text-align:center;
    background:#fff;
}

.answer-input:focus{
    border-bottom:2px solid #1F669C;
}

.verify-label{
    font-size:22px;
    font-weight:600;
    margin-bottom:8px;
}

.answer-row{
    display:flex;
    align-items:center;
    gap:30px;
}

.answer-row .verify-label{
    width:160px;
    flex-shrink:0;
}


@media(max-width:768px){

    .verify-row{
        flex-direction:column;
    }

    .verify-image{
        width:180px;
    }

    .answer-input{
        width:100%;
    }
}

</style>

<div class="verify-wrap">

    <div class="angle-set">
        <?= ($index + 1) ?>)
        <?= htmlspecialchars($a) ?>°,
        <?= htmlspecialchars($b) ?>°,
        <?= htmlspecialchars($c) ?>°
       
    </div>

    <div class="verify-row">

        <div class="verify-left">

           <div class="answer-box">

            <div class="answer-row">
             <div class="verify-label">
                    Answer:
                </div>
        
                <select
                    class="answer-input"
                    name="answer[<?= $id ?>][result]"
                >
                    <option value="">Select</option>
                    <option value="Yes">Yes (Sum of angles = 180°)</option>
                    <option value="No">No (Sum of angles ≠ 180°)</option>
                </select>
        
            </div>
        
        </div>

        </div>

       <?php
        if (!isset($GLOBALS['triangleImageShown']) && !empty($image)):
            $GLOBALS['triangleImageShown'] = true;
        ?>
        <div class="verify-image">
            <img
                src="<?= htmlspecialchars($image) ?>"
                alt="Triangle"
            >
        </div>
        <?php endif; ?>

    </div>

</div>