<?php
declare(strict_types=1);
$q = $q ?? [];
$data = json_decode($q['question_payload'] ?? '{}', true) ?: [];
$showAsQuestion = !empty($data['show_bank_as_question']);
$mode = (isset($data['bank']) && !$showAsQuestion) ? 'bank' : 'order';
$studentDigits = json_decode($q['student_answer'] ?? '[]', true);
if(!is_array($studentDigits)){
    $studentDigits = [];
}
?>
<style>
.scramble-box{
    background:#fff;
    padding:28px;
    border-radius:16px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    margin-bottom:25px;
}
.scramble-bank{
    display:flex;
    align-items:center;
    gap:12px;
    margin:15px 0 30px;
    flex-wrap:wrap;
}
.scramble-digit{
    width:52px;
    height:52px;
    border-radius:50%;
    background:#8d5d50;
    color:#fff;
    font-size:26px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
}
.scramble-numbers{
    font-size:22px;
    font-weight:700;
    color:#111;
    margin:15px 0 30px;
}
.scramble-row{
    margin-top:22px;
}
.scramble-question{
    font-size:22px;
    font-weight:700;
    line-height:1.5;
    margin-bottom:18px;
}
.answer-box{
    display:flex;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}
.answer-digit{
    width:42px;
    height:40px;
    border:none;
    border-bottom:4px solid #ff3434;
    text-align:center;
    font-size:26px;
    outline:none;
    background:transparent;
}
@media(max-width:768px){
.scramble-digit{
width:46px;
height:46px;
font-size:24px;
}
.answer-digit{
width:36px;
font-size:22px;
}
.scramble-question{
font-size:19px;
}
}
</style>
<div class="scramble-box">
<?php if($mode==='bank'): ?>
    <?php
    $bank = str_split($data['bank'] ?? '');
    $question = $data['question'] ?? '';
    $digitCount = (int)($data['digits'] ?? 6);
    ?>
    <div class="scramble-bank">
        <?php foreach($bank as $digit): ?>
            <div class="scramble-digit">
                <?= htmlspecialchars($digit) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="scramble-row">
        <div class="scramble-question">
            <?= ($index + 1) ?>)
            <?= htmlspecialchars($question) ?>
        </div>
        <div class="answer-box">
            <?php for($i=0;$i<$digitCount;$i++): ?>
               <input
                type="text"
                maxlength="1"
                class="answer-digit"
                data-qid="<?= $q['id'] ?>"
                data-slot="<?= $i ?>"
                name="answer[<?= $q['id'] ?>][<?= $i ?>]"
                value="<?= htmlspecialchars((string)($studentDigits[$i] ?? '')) ?>">
            <?php endfor; ?>
        </div>
    </div>
<?php else: ?>
    <?php
    $numbersText = $data['bank'] ?? '';
    $correctRaw = trim($q['correct_answer'] ?? '');

    $decoded = json_decode($correctRaw, true);
    if (is_array($decoded)) {
        $correctParts = array_filter(array_map('trim', $decoded));
    } else {
        $correctParts = array_filter(array_map('trim', preg_split('/,\s+(?=\d)/', $correctRaw)));
    }
    $numberCount = count($correctParts);
    if($numberCount < 1){ $numberCount = 1; }
    ?>
    <div class="scramble-numbers">
        <?= ($index + 1) ?>)
        <?= htmlspecialchars($numbersText) ?>
    </div>
    <div class="scramble-row">
        <div class="answer-box">
            <?php for($i=0;$i<$numberCount;$i++): ?>
               <input
                type="text"
                class="answer-digit"
                style="width:130px;"
                data-qid="<?= $q['id'] ?>"
                data-slot="<?= $i ?>"
                name="answer[<?= $q['id'] ?>][<?= $i ?>]"
                value="<?= htmlspecialchars((string)($studentDigits[$i] ?? '')) ?>">
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>
</div>