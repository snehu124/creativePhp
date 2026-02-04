<?php
// $q comes from the quiz loop
$payload = json_decode($q['question_payload'], true);
$numerator = (int)$payload['numerator'];   // improper numerator
$denominator = (int)$payload['denominator'];

$whole = intdiv($numerator, $denominator);
$remainder = $numerator % $denominator;
$expected = $numerator . '/' . $denominator;
?>
<style>
.qcard{
    background:#fff;padding:12px 18px;margin:8px 0;
    border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.08);
    transition:all .2s;
}
.qcard:hover{box-shadow:0 4px 12px rgba(0,0,0,.12);transform:translateY(-1px);}
.qcard h6{font-size:16px;font-weight:600;color:#333;margin:0;}
.vfrac{
    display:inline-flex;flex-direction:column;align-items:center;justify-content:center;
    font-family:'Cambria Math','Times New Roman',serif;line-height:1.1;margin:0 6px;
}
.vfrac .num{padding-bottom:2px;border-bottom:2px solid #000;font-weight:600;font-size:18px;}
.vfrac .den{padding-top:2px;font-size:18px;}

/* TYPEABLE UNDERLINE */
.underline-input{
    display:inline-block;
    width:100px;
    border:none;
    border-bottom:2px solid #000;
    background:transparent;
    font-size:18px;
    font-family:'Cambria Math','Times New Roman',serif;
    text-align:center;
    outline:none;
    padding:0 2px;
    margin-left:8px;
    vertical-align:middle;
}
.underline-input:focus{
    border-bottom-color:#007bff;
}
@media (max-width:768px){
    .qcard{padding:10px 12px;margin:6px 0;}
    .underline-input{width:80px;font-size:16px;}
}
</style>

<!-- ONE QUESTION (col-lg-4) -->
<div class="col-lg-4 col-md-4 col-sm-12">
    <div class="qcard">
        <div class="row align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-start">
                <h6 class="mb-0">
                    <strong><?= $char++; ?>)</strong>
                    <span style="margin-left:6px;font-weight:600;"><?= $whole ?></span>
                    <span class="vfrac">
                        <span class="num"><?= $remainder ?></span>
                        <span class="den"><?= $denominator ?></span>
                    </span>
                    <span style="margin-left:6px;">=</span>
                    <input type="text" 
                           name="answer[<?= $q['id'] ?>]" 
                           class="underline-input" 
                           maxlength="6" 
                           autocomplete="off"
                           placeholder=""
                           value="">
                </h6>
            </div>
        </div>
    </div>
</div>

<!-- Hidden expected answer -->
<input type="hidden" name="expected[<?= $q['id'] ?>]" value="<?= htmlspecialchars($expected) ?>">
<input type="hidden" name="question_id[]" value="<?= $q['id'] ?>">