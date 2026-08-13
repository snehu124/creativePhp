<?php
declare(strict_types=1);
$q = $q ?? [];
$id = (int)($q['id'] ?? 0);
$payload = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];
$left  = $payload['left'] ?? '';
$right = $payload['right'] ?? '';
$h = fn($s) => htmlspecialchars(
    (string)$s,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
?>
<style>
.compare-power-card{
    background:#fff;
    padding:14px 20px !important;
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
    overflow-x:auto;
    margin-top: 20px;
}
.compare-power-card:hover{
    box-shadow:0 5px 15px rgba(0,0,0,.12);
}
.compare-power-row{
    display:flex;
    align-items:center;
    white-space:nowrap;
}
/* Question No */
.q-no{
    width:36px;
    flex:0 0 auto;
    font-size:20px;
    font-weight:700;
}
/* LEFT NUMBER */
.compare-left{
    flex:0 0 auto;
    min-width:70px;
    margin-right:10px;
    font-size:20px;
    font-weight:600;
    text-align:right;
    white-space:nowrap;
}
/* CENTER BOX */
.compare-middle{
    width:56px;
    flex:0 0 auto;
    display:flex;
    justify-content:center;
    align-items:center;
}
/* INPUT */
.compare-power-input{
    width:36px;
    height:30px;
    border:2px solid #9c27ff;
    border-radius:4px;
    background:#fff;
    text-align:center;
    font-size:22px;
    font-weight:700;
    outline:none;
    padding:0;
    box-sizing:border-box;
}
/* RIGHT NUMBER */
.compare-right{
    flex:0 0 auto;
    margin-left:10px;
    font-size:20px;
    font-weight:600;
    text-align:left;
    white-space:nowrap;
}
/* ================= MOBILE ================= */
@media(max-width:768px){
    .compare-power-card{
        padding:10px 12px;
    }
    .q-no{
        width:28px;
        font-size:16px;
    }
    .compare-left{
        min-width:50px;
        font-size:16px;
    }
    .compare-middle{
        width:42px;
    }
    .compare-power-input{
        width:28px;
        height:28px;
        font-size:18px;
    }
    .compare-right{
        font-size:16px;
    }
}
@media(max-width:480px){
    .q-no{
        width:22px;
        font-size:14px;
    }
    .compare-left{
        min-width:36px;
        font-size:14px;
    }
    .compare-middle{
        width:32px;
    }
    .compare-power-input{
        width:24px;
        height:24px;
        font-size:15px;
    }
    .compare-right{
        font-size:14px;
    }
}
</style>
<div class="compare-power-card">
    <div class="compare-power-row">
        <div class="q-no">
            <?= ($index + 1) ?>)
        </div>
        <div class="compare-left">
            <?= $h($left) ?>
        </div>
        <div class="compare-middle">
            <input
                type="text"
                maxlength="1"
                class="compare-power-input"
                name="answer[<?= $id ?>]"
                autocomplete="off">
        </div>
        <div class="compare-right">
            <?= $h($right) ?>
        </div>
    </div>
</div>