<?php
$payload    = json_decode($q['question_payload'], true) ?? [];
$is_diagram = ($q['question_type'] === 'fraction_order_diagram');

$image_path = !empty($q['question_image']) ? htmlspecialchars($q['question_image']) : '';
$char       = chr(97 + ($index ?? 0));
$qid        = (int)$q['id'];
?>

<style>
.qcard{
    background:#fff;
    padding:28px;
    margin:24px 0;
    border-radius:16px;
    box-shadow:0 2px 12px rgba(0,0,0,.08);
    font-family:Arial,Helvetica,sans-serif;
    width:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
    position:relative;
}
.label{
    position:absolute;
    left:28px;
    top:28px;
    font-weight:bold;
    font-size:20px;
}
.diagram-img{
    max-width:400px;
    margin:40px 0 24px;
}
.fraction-blank{
    display:flex;
    flex-direction:column;
}
.fraction-blank input{
    width:58px;
    height:44px;
    border:3px solid #e8063c;
    border-radius:8px;
    text-align:center;
    font-size:22px;
    /*font-weight:bold;*/
    margin:3px 0;
}
.blank-sign{
    width:76px;
    height:76px;
    border:3px solid #e8063c;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 20px;
}
.blank-sign input{
    font-size:28px;
    font-weight:bold;
    border:none;
    background:transparent;
    text-align:center;
    outline:none;        
    box-shadow:none;   
}
</style>

<div class="qcard" data-qid="<?= $qid ?>">

<?php if ($is_diagram): ?>

    <div class="label"><?= $char ?>)</div>

    <?php if ($image_path): ?>
        <img src="<?= $image_path ?>" class="diagram-img">
    <?php endif; ?>

    <div style="display:flex;align-items:center;gap:22px;">

        <div class="fraction-blank">
            <input type="text" class="ln" maxlength="2">
            <input type="text" class="ld" maxlength="2">
        </div>

        <div class="blank-sign">
            <input type="text" class="sign" maxlength="1">
        </div>

        <div class="fraction-blank">
            <input type="text" class="rn" maxlength="2">
            <input type="text" class="rd" maxlength="2">
        </div>

    </div>

<?php endif; ?>

</div>

<!-- FINAL JSON ANSWER -->
<input type="hidden" name="answer[<?= $qid ?>]" id="final_answer_<?= $qid ?>">
<input type="hidden" name="question_id[]" value="<?= $qid ?>">

<script>
document.addEventListener("input", function () {

    document.querySelectorAll(".qcard").forEach(card => {

        const qid = card.dataset.qid;

        const ln   = card.querySelector(".ln")?.value.trim();
        const ld   = card.querySelector(".ld")?.value.trim();
        const rn   = card.querySelector(".rn")?.value.trim();
        const rd   = card.querySelector(".rd")?.value.trim();
        const sign = card.querySelector(".sign")?.value.trim();

        if (ln && ld && rn && rd && sign) {
            const obj = {
                left:  ln + "/" + ld,
                sign:  sign,
                right: rn + "/" + rd
            };
            document.getElementById("final_answer_" + qid).value =
                JSON.stringify(obj);
        }
    });

});
</script>
