<?php

$data = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];

$section_id = $q['instruction_id'] ?? 0;

if (!isset($GLOBALS['section_question'][$section_id])) {
    $GLOBALS['section_question'][$section_id] = 1;
}

$title = $data['title'] ?? 'Identify congruent triangles';
?>

<style>

.cong-card{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.cong-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:15px;
}

.cong-wrap{
    display:flex;
    justify-content:space-between;
    gap:30px;
    flex-wrap:wrap;
}

.cong-left{
    flex:1;
    min-width:300px;
}

.cong-right{
    width:420px;
    text-align:center;
}

.cong-right img{
    max-width:100%;
    width:100%;
}

.cong-row{
    margin-bottom:25px;
    font-size:22px;
    font-weight: 600;
    align-items: center;
    margin-top: 50px;
}

.cong-input{
    width:140px;
    border:none;
    border-bottom:2px solid #000;
    text-align:center;
    font-size:20px;
    outline:none;
}

.cong-select{
    width:180px;
    height:40px;
    font-size:16px;
    text-align: center;
}

</style>

<div class="cong-card">

    <div class="cong-title">
        <?= $GLOBALS['section_question'][$section_id]++ ?>)
        <?= htmlspecialchars($title) ?>
    </div>

    <div class="cong-wrap">

        <div class="cong-left">

            <div class="cong-row">

                ∴ △

                <input
                    type="text"
                    class="cong-input"
                    name="answer[<?= $q['id'] ?>][triangle1]"
                >

                ≅

                △

                <input
                    type="text"
                    class="cong-input"
                    name="answer[<?= $q['id'] ?>][triangle2]"
                >

            </div>

            <div class="cong-row">

                Rule :

                <select
                    class="cong-select"
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

        <?php if (!empty($q['question_image'])): ?>

        <div class="cong-right">

            <img
                src="<?= htmlspecialchars($q['question_image']) ?>"
                alt=""
            >

        </div>

        <?php endif; ?>

    </div>

</div>