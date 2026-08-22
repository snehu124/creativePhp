<?php

$data=json_decode($q['question_payload'],true);

$mode=$data['mode'];

?>

<style>

* {
    box-sizing: border-box;
}

.pc-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 25px 30px;
    margin-bottom: 25px;
    width: 100%;
}

.pc-title {
    font-size: 19px;
    font-weight: 700;
    color: #000;
    line-height: 1.6;
    margin-bottom: 18px;
}

.pc-row {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 18px;
    color: #000;
    margin-bottom: 16px;
}

.pc-row span {
    flex-shrink: 0;
}

.pc-input,
.pc-small,
.pc-long,
.pc-select {
    border: none;
    border-bottom: 2px solid #000;
    background: transparent;
    outline: none;
    font-size: 17px;
    color: #000;
    padding: 2px 4px;
}

.pc-input {
    flex: 1;
    min-width: 200px;
}

.pc-small {
    width: 130px;
    text-align: center;
}

.pc-long {
    width: 100%;
    margin-top: 8px;
}

.pc-select {
    width: 160px;
    cursor: pointer;
    background: #fff;
}

/* =====================================================
   PRIME / COMPOSITE SORT
===================================================== */

.prime-composite-wrapper {
    margin-top: 25px;
}

.sort-columns {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 25px;
}

.sort-column {
    width: 260px;
    min-height: 330px;
    border: 2px solid #222;
    border-radius: 15px;
    background: #fff;
    padding: 0;
}

.sort-column-title {
    text-align: center;
    font-weight: 700;
    font-size: 17px;
    padding: 12px 8px;
    border-bottom: 2px solid #222;
    background: #fff;
    border-radius: 13px 13px 0 0;
}

.sort-drop-zone {
    min-height: 275px;
    padding: 15px;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
    justify-content: center;
    gap: 10px;
    transition: .2s;
}

.sort-drop-zone.drag-over {
    background: #f3f6ff;
}

.sort-number-pool {
    border: 2px solid #222;
    padding: 15px;
    border-radius: 12px;
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 10px;
    background: #fff;
    max-width: 700px;
    margin: auto;
}

.sort-number {
    width: 42px;
    height: 38px;
    border: 1px solid #222;
    border-radius: 8px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    font-weight: 700;
    cursor: grab;
    user-select: none;
    transition: .2s;
}

.sort-number:hover {
    transform: scale(1.05);
}

.sort-number.dragging {
    opacity: .45;
}

.sort-number.source-used {
    opacity: .25;
    pointer-events: none;
}

.sort-number.correct-sort {
    border-color: #22c55e;
}

.sort-number.wrong-sort {
    border-color: #ef4444;
}

@media(max-width:768px) {

    .sort-columns {
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .sort-column {
        width: 100%;
        max-width: 350px;
    }

    .sort-drop-zone {
        min-height: 220px;
    }

    .sort-number-pool {
        grid-template-columns: repeat(5, 1fr);
    }

    .sort-number {
        width: 40px;
        height: 36px;
        font-size: 16px;
    }

}

@media (max-width: 768px) {

    .pc-card {
        padding: 18px 20px;
        border-radius: 12px;
    }

    .pc-title {
        font-size: 17px;
    }

    .pc-row {
        font-size: 16px;
        flex-direction: column;
        align-items: flex-start;
    }

    .pc-input,
    .pc-small,
    .pc-select {
        width: 100%;
        min-width: unset;
    }
}

@media (max-width: 480px) {

    .pc-card {
        padding: 15px;
    }

    .pc-title {
        font-size: 16px;
    }

    .pc-row {
        font-size: 15px;
    }
}

</style>

<?php if($mode=="sum_even_odd"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
What is the sum of any two

(a) Odd numbers?

(b) Even numbers?

</div>

<?php $opts = $data['options'] ?? ['Even','Odd']; ?>

<div class="pc-row">
<span>(a)</span>
<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="pc-row">
<span>(b)</span>
<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>
</div>

</div>

<?php endif; ?>
<?php if($mode=="true_false"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
State whether the following statements are True or False

</div>

<?php foreach($data['questions'] as $k=>$text): ?>

<div class="pc-row">
<span>
(<?= chr(97+$k) ?>) <?= $text ?>
</span>

<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<option value="True">True</option>
<option value="False">False</option>
</select>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="prime_pairs"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

The numbers 13 and 31 are prime numbers.

Both these numbers have same digit 1 and 3.

Find such pairs of prime numbers upto 100.

</div>

<input
type="text"
class="pc-long"
name="answer[<?= $q['id']?>]">

</div>

<?php endif; ?>
<?php if($mode=="prime_composite_less20"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Write down separately the prime and composite numbers less than 20.

</div>

<div class="pc-row">
<span>Prime</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

<div class="pc-row">
<span>Composite</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

</div>

<?php endif; ?>
<?php if($mode=="greatest_prime"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

What is the greatest prime number between 1 and 10?

</div>

<?php $opts = $data['options'] ?? []; ?>

<?php if(!empty($opts)): ?>
<select name="answer[<?= $q['id']?>]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>
<?php else: ?>
<input type="text" class="pc-long" name="answer[<?= $q['id']?>]">
<?php endif; ?>

</div>

<?php endif; ?>
<?php if($mode=="sum_two_odd_primes"): ?>

<div class="pc-card">

<div class="pc-title">
<?= ($index+1) ?>.
Express the following as the sum of two odd primes.
</div>

<?php foreach($data['numbers'] as $num): ?>
<div class="pc-row">
<span><?= $num ?></span>
<input type="text" class="pc-long" name="answer[<?= $q['id']?>][]">
</div>
<?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="twin_primes"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Give three pairs of prime numbers whose difference is 2.

</div>

<?php for($i=0;$i<3;$i++): ?>
<div class="pc-row">
<input type="text" class="pc-long" name="answer[<?= $q['id']?>][]">
</div>
<?php endfor; ?>

</div>

<?php endif; ?>
<?php if($mode=="identify_prime"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Which of the following numbers are prime?

</div>

<?php $opts = $data['options'] ?? ['Prime','Not Prime']; ?>

<?php foreach($data['numbers'] as $k=>$num): ?>

<div class="pc-row">
<span><?= chr(97+$k) ?>) <?= $num ?></span>

<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="seven_composite"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Write seven consecutive composite numbers less than 100.

</div>

<input type="text" class="pc-long" name="answer[<?= $q['id']?>]">

</div>

<?php endif; ?>
<?php if($mode=="three_odd_primes"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Express each of the following numbers as the sum of three odd primes.

</div>

<?php foreach($data['numbers'] as $num): ?>
<div class="pc-row">
<span><?= $num ?></span>
<input type="text" class="pc-long" name="answer[<?= $q['id']?>][]">
</div>
<?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="pairs_sum_divisible_5"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Write five pairs of prime numbers less than 20 whose sum is divisible by 5.

</div>

<?php for($i=0;$i<5;$i++): ?>
<div class="pc-row">
<input type="text" class="pc-long" name="answer[<?= $q['id']?>][]">
</div>
<?php endfor; ?>

</div>

<?php endif; ?>
<?php if($mode=="fraction_type_select"): ?>

<style>

/* =====================================================
   FRACTION TYPE SELECT
===================================================== */

.fraction-type-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);

    padding: 24px 32px;

    margin-bottom: 24px;
    margin-top: 20px;
    width: 100%;
}


/* =====================================================
   QUESTION ROW
===================================================== */

.fraction-type-item {

    display: grid;

    grid-template-columns: 45px 110px 1fr;

    align-items: center;

    min-height: 75px;

    width: 100%;

}


/* =====================================================
   QUESTION NUMBER
===================================================== */

.fraction-question-number {

    font-size: 20px;

    font-weight: 700;

    color: #111;

}


/* =====================================================
   FRACTION
===================================================== */

.fraction-display {

    display: flex;

    align-items: center;

    justify-content: center;

    min-width: 80px;

}


/* Mixed number whole */

.fraction-whole {

    font-size: 21px;

    margin-right: 7px;

    line-height: 1;

}


/* Fraction part */

.fraction-part {

    display: inline-flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    line-height: 1;

    min-width: 38px;

}


/* Numerator */

.fraction-numerator {

    font-size: 20px;

    line-height: 1;

    padding: 0 8px 5px;

    border-bottom: 2px solid #000;

}


/* Denominator */

.fraction-denominator {

    font-size: 20px;

    line-height: 1;

    padding: 5px 8px 0;

}


/* =====================================================
   OPTIONS
===================================================== */

.fraction-options {

    display: flex;

    align-items: center;

    justify-content: flex-start;

    gap: 30px;

    margin-left: 15px;

}


/* Option */

.fraction-option {

    position: relative;

    cursor: pointer;

    margin: 0;

}


/* Hide radio */

.fraction-option input {

    position: absolute;

    opacity: 0;

    pointer-events: none;

}


/* Peach button */

.fraction-option-box {

    display: flex;

    align-items: center;

    justify-content: center;

    min-width: 125px;

    min-height: 48px;

    padding: 8px 15px;

    background: #e7bea8;

    border-radius: 9px;

    color: #111;

    font-family: Georgia, "Times New Roman", serif;

    font-size: 15px;

    font-weight: 600;

    text-align: center;

    line-height: 1.15;

    transition: all .2s ease;

}


/* Hover */

.fraction-option:hover .fraction-option-box {

    transform: translateY(-2px);

}


/* Selected */

.fraction-option input:checked + .fraction-option-box {

    background: #d89e83;

    box-shadow: 0 0 0 3px rgba(120,75,55,.25);

    transform: scale(1.03);

}


/* =====================================================
   MOBILE
===================================================== */

@media(max-width: 768px) {

    .fraction-type-card {

        padding: 20px;

    }


    .fraction-type-item {

        grid-template-columns: 30px 75px 1fr;

        min-height: 70px;

    }


    .fraction-question-number {

        font-size: 17px;

    }


    .fraction-whole,

    .fraction-numerator,

    .fraction-denominator {

        font-size: 18px;

    }


    .fraction-options {

        gap: 8px;

        margin-left: 5px;

    }


    .fraction-option-box {

        min-width: 80px;

        min-height: 42px;

        padding: 6px 7px;

        font-size: 11px;

    }

}


@media(max-width: 480px) {

    .fraction-type-card {

        padding: 15px;

    }


    .fraction-type-item {

        grid-template-columns: 25px 60px 1fr;

    }


    .fraction-options {

        gap: 5px;

    }


    .fraction-option-box {

        min-width: 65px;

        min-height: 38px;

        padding: 5px;

        font-size: 10px;

    }

}

</style>


<div class="fraction-type-card">

    <div class="fraction-type-item">


        <!-- ==========================================
             QUESTION NUMBER
        =========================================== -->

        <div class="fraction-question-number">

            <?= ($index + 1) ?>.

        </div>


        <!-- ==========================================
             FRACTION
        =========================================== -->

        <div class="fraction-display">

            <?php if(isset($data['whole']) && $data['whole'] !== ''): ?>

                <span class="fraction-whole">

                    <?= htmlspecialchars($data['whole']) ?>

                </span>

            <?php endif; ?>


            <span class="fraction-part">

                <span class="fraction-numerator">

                    <?= htmlspecialchars($data['numerator']) ?>

                </span>

                <span class="fraction-denominator">

                    <?= htmlspecialchars($data['denominator']) ?>

                </span>

            </span>

        </div>


        <!-- ==========================================
             OPTIONS
        =========================================== -->

        <div class="fraction-options">

            <?php foreach(($data['options'] ?? [
                'PROPER',
                'IMPROPER',
                'MIXED NUMBER'
            ]) as $option): ?>

                <label class="fraction-option">

                    <input
                        type="radio"
                        name="answer[<?= $q['id'] ?>]"
                        value="<?= htmlspecialchars($option) ?>"
                    >

                    <span class="fraction-option-box">

                        <?= htmlspecialchars($option) ?>

                    </span>

                </label>

            <?php endforeach; ?>

        </div>


    </div>

</div>


<?php endif; ?>
<?php if($mode=="fill_blank"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Fill in the blanks.

</div>

<?php foreach($data['questions'] as $k=>$question): ?>

<?php
    // backward compatible: agar purana simple string format hai
    if(is_array($question)){
        $qtext   = $question['text'] ?? '';
        $blanks  = $question['blanks'] ?? 1;
        $opts    = $question['options'] ?? [];
    } else {
        $qtext   = $question;
        $blanks  = 1;
        $opts    = $data['options'][$k] ?? null;
    }
?>

<div class="pc-row">

<span><?= chr(97+$k) ?>) <?= $qtext ?></span>

<?php for($b=0; $b<$blanks; $b++): ?>

    <?php if(!empty($opts)): ?>
        <select name="answer[<?= $q['id']?>][<?= $k ?>][]" class="pc-select">
        <option value="">Select</option>
        <?php foreach($opts as $o): ?>
            <option value="<?= $o ?>"><?= $o ?></option>
        <?php endforeach; ?>
        </select>
    <?php else: ?>
        <input type="text" class="pc-input" name="answer[<?= $q['id']?>][<?= $k ?>][]">
    <?php endif; ?>

<?php endfor; ?>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="find_multiples_upto"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.

Find all the multiples of <?= $data['number'] ?> upto <?= $data['limit'] ?>.

</div>

<input
type="text"
class="pc-long"
name="answer[<?= $q['id']?>]">

</div>

<?php endif; ?>
<?php if($mode=="smallest_greatest_digit_divisible_3"): ?>

<div class="pc-card">

    <?php foreach($data['questions'] as $k=>$question): ?>

        <div class="pc-row">

            <span>
                (<?= chr(97+$k) ?>)
            </span>

            <span><?= $question['prefix'] ?></span>

            <span>____</span>

            <span><?= $question['suffix'] ?></span>

        </div>

        <div class="pc-row">

            <span style="margin-left:28px;">
                Smallest digit:
            </span>

            <input
                type="text"
                maxlength="1"
                class="pc-small"
                name="answer[<?= $q['id'] ?>][<?= $k ?>][]"
            >

            <span>
                Greatest digit:
            </span>

            <input
                type="text"
                maxlength="1"
                class="pc-small"
                name="answer[<?= $q['id'] ?>][<?= $k ?>][]"
            >

        </div>

    <?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="time_table"): ?>

<style>

/* =====================================================
   TIME TABLE
===================================================== */

.time-table-card{
    background:#fff;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    padding:25px 30px;
    margin-bottom:25px;
    width:100%;
}

.time-table-title{
    font-size:19px;
    font-weight:700;
    margin-bottom:20px;
    color:#000;
}


/* =====================================================
   TABLE
===================================================== */

.time-table-wrapper{
    width:100%;
    overflow-x:auto;
}

.time-table{
    border-collapse:separate;
    border-spacing:8px;
    width:100%;
    min-width:650px;
}

.time-table th,
.time-table td{
    text-align:center;
    vertical-align:middle;
    height:48px;
    font-size:18px;
}


/* LEFT LABEL */

.time-table-label{
    width:125px;
    min-width:125px;
    background:#f8c9c9;
    font-weight:700;
}


/* NORMAL CELL */

.time-table-cell{
    background:#f8eeee;
    min-width:52px;
    height:48px;
}


/* FRACTION DISPLAY */

.time-table-fraction{
    display:inline-flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    font-size:17px;
    font-weight:600;
    line-height:1;
}

.time-table-num{
    border-bottom:2px solid #000;
    padding:0 5px 3px;
}

.time-table-den{
    padding:3px 5px 0;
}


/* ANSWER INPUT */

.time-table-input{
    width:100%;
    height:100%;

    border:none;
    outline:none;

    background:transparent;

    text-align:center;
    font-size:17px;
    font-weight:600;

    padding:5px;
}


/* =====================================================
   MOBILE
===================================================== */

@media(max-width:768px){

    .time-table-card{
        padding:18px;
    }

    .time-table{
        min-width:650px;
    }

    .time-table th,
    .time-table td{
        font-size:16px;
    }

}

</style>


<div class="time-table-card">

    <!-- =================================================
         TITLE
    ================================================== -->

    <div class="time-table-title">

        <?= ($index + 1) ?>.
        Complete the table.

    </div>


    <div class="time-table-wrapper">

        <table class="time-table">

            <!-- =================================================
                 MINUTES ROW
            ================================================== -->

            <tr>

                <th class="time-table-label">
                    MINUTES
                </th>


                <?php foreach(($data['minutes'] ?? []) as $i => $minute): ?>

                    <td class="time-table-cell">

                        <?php if($minute === '' || $minute === null): ?>

                            <!-- Answer for missing minutes -->

                            <input
                                type="text"
                                class="time-table-input"
                                name="answer[<?= $q['id'] ?>][<?= $i ?>]"
                                autocomplete="off"
                            >

                        <?php else: ?>

                            <?= htmlspecialchars($minute) ?>

                        <?php endif; ?>

                    </td>

                <?php endforeach; ?>

            </tr>


            <!-- =================================================
                 HOUR ROW
            ================================================== -->

            <tr>

                <th class="time-table-label">
                    HOUR
                </th>


                <?php foreach(($data['hours'] ?? []) as $i => $hour): ?>

                    <td class="time-table-cell">

                        <?php if($hour === '' || $hour === null): ?>

                            <!-- Answer for missing hour fraction -->

                            <input
                                type="text"
                                class="time-table-input"
                                name="answer[<?= $q['id'] ?>][<?= $i ?>]"
                                autocomplete="off"
                            >

                        <?php else: ?>

                            <?php

                                $parts =
                                    explode('/', (string)$hour, 2);

                                if(count($parts) === 2):

                            ?>

                                <span class="time-table-fraction">

                                    <span class="time-table-num">
                                        <?= htmlspecialchars($parts[0]) ?>
                                    </span>

                                    <span class="time-table-den">
                                        <?= htmlspecialchars($parts[1]) ?>
                                    </span>

                                </span>

                            <?php else: ?>

                                <?= htmlspecialchars($hour) ?>

                            <?php endif; ?>

                        <?php endif; ?>

                    </td>

                <?php endforeach; ?>

            </tr>

        </table>

    </div>

</div>

<?php endif; ?>
<?php if($mode=="equivalent_fractions"): ?>

<style>

/* =====================================================
   EQUIVALENT FRACTIONS
===================================================== */

.eq-frac-card{
    background:#fff;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);

    padding:25px 30px;

    margin-bottom:25px;

    width:100%;
}

.eq-frac-title{
    font-size:19px;
    font-weight:700;

    color:#000;

    line-height:1.5;

    margin-bottom:28px;
}


/* =====================================================
   2 COLUMN GRID
===================================================== */

.eq-frac-grid{

    display:grid;

    grid-template-columns:repeat(2, 1fr);

    column-gap:80px;

    row-gap:35px;

    width:100%;
}


/* =====================================================
   FRACTION CHAIN
===================================================== */

.eq-frac-chain{

    display:flex;

    align-items:center;

    justify-content:flex-start;

    gap:16px;

    font-size:20px;

    font-weight:600;

    white-space:nowrap;
}


/* =====================================================
   EQUAL SIGN
===================================================== */

.eq-frac-equal{

    font-size:22px;

    font-weight:600;

    line-height:1;
}


/* =====================================================
   FRACTION
===================================================== */

.eq-frac{

    display:inline-flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    min-width:48px;

    line-height:1;

    font-size:20px;

    font-weight:600;
}


/* =====================================================
   NUMERATOR
===================================================== */

.eq-frac-num{

    min-width:42px;

    min-height:30px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-bottom:2px solid #000;

    padding:0 5px 5px;
}


/* =====================================================
   DENOMINATOR
===================================================== */

.eq-frac-den{

    min-width:42px;

    min-height:30px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:5px 5px 0;
}


/* =====================================================
   NUMERATOR INPUT
===================================================== */

.eq-frac-input{

    width:42px;

    height:28px;

    border:none;

    outline:none;

    background:transparent;

    text-align:center;

    font-size:19px;

    font-weight:600;

    padding:0;
}


/* =====================================================
   MOBILE
===================================================== */

@media(max-width:900px){

    .eq-frac-grid{

        grid-template-columns:1fr;

        row-gap:30px;

    }

    .eq-frac-chain{

        justify-content:center;

    }

}


@media(max-width:600px){

    .eq-frac-card{

        padding:18px 15px;

    }

    .eq-frac-title{

        font-size:17px;

    }

    .eq-frac-chain{

        gap:10px;

        font-size:18px;

    }

    .eq-frac{

        font-size:18px;

        min-width:42px;

    }

    .eq-frac-input{

        width:38px;

        font-size:17px;

    }

}

</style>


<div class="eq-frac-card">

    <!-- =================================================
         TITLE
    ================================================== -->

    <div class="eq-frac-title">

        <?= ($index + 1) ?>.
        <?= htmlspecialchars(
            $data['title']
            ?? 'Complete the following so each chain of fractions are equal.'
        ) ?>

    </div>


    <!-- =================================================
         FRACTION GRID
    ================================================== -->

    <div class="eq-frac-grid">

        <?php foreach(($data['items'] ?? []) as $rowIndex => $row): ?>

            <div class="eq-frac-chain">

                <?php foreach($row as $position => $fraction): ?>

                    <?php

                        $numerator =
                            (string)($fraction['numerator'] ?? '');

                        $denominator =
                            (string)($fraction['denominator'] ?? '');

                    ?>


                    <!-- =================================
                         FRACTION
                    ================================== -->

                    <span class="eq-frac">

                        <!-- NUMERATOR -->

                        <span class="eq-frac-num">

                            <?php if($numerator === ''): ?>

                                <?php
                                    /*
                                     * Stable unique answer key.
                                     *
                                     * Example:
                                     * row_0_blank_1
                                     * row_0_blank_2
                                     * row_2_blank_1
                                     */
                                    $answerKey =
                                        'row_' . $rowIndex .
                                        '_blank_' . $position;
                                ?>

                                <input
                                    type="text"
                                    class="eq-frac-input"

                                    name="answer[<?= $q['id'] ?>][<?= $answerKey ?>]"

                                    autocomplete="off"

                                    inputmode="numeric"

                                    data-answer-key="<?= htmlspecialchars($answerKey) ?>"
                                >

                            <?php else: ?>

                                <?= htmlspecialchars($numerator) ?>

                            <?php endif; ?>

                        </span>


                        <!-- DENOMINATOR -->

                        <span class="eq-frac-den">

                            <?= htmlspecialchars($denominator) ?>

                        </span>

                    </span>


                    <!-- =================================
                         EQUAL SIGN
                    ================================== -->

                    <?php if($position < count($row) - 1): ?>

                        <span class="eq-frac-equal">
                            =
                        </span>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php endif; ?>
<?php if($mode=="time_fractions"): ?>

<style>

/* =====================================================
   TIME AS FRACTIONS
===================================================== */

.time-fraction-card{
    background:#fff;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    padding:25px 30px;
    margin-bottom:30px;
    width:100%;
    margin-top: 30px;
}

.time-fraction-title{
    font-size:19px;
    font-weight:700;
    color:#000;
    margin-bottom:25px;
    line-height:1.5;
}


/* =====================================================
   PROPER FRACTION
===================================================== */

.time-frac{
    display:inline-flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    vertical-align:middle;

    min-width:28px;

    font-size:19px;
    font-weight:600;
    line-height:1;
}

.time-frac-num{
    border-bottom:2px solid #000;
    padding:0 6px 4px;
}

.time-frac-den{
    padding:4px 6px 0;
}


/* =====================================================
   SECTION A
===================================================== */

.time-a-list{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:28px 45px;
}

.time-a-item{
    display:flex;
    align-items:center;
    gap:9px;
    font-size:19px;
    white-space:nowrap;
}

.time-fraction-input{
    width:85px;
    height:34px;

    border:none;
    border-bottom:2px solid #000;

    background:transparent;
    outline:none;

    text-align:center;
    font-size:18px;
}


/* =====================================================
   SECTION B
===================================================== */

.time-b-list{
    display:flex;
    flex-direction:column;
    gap:24px;
}

.time-b-item{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:8px;

    font-size:18px;
    line-height:2;
}

.time-b-input{
    width:55px;
    height:32px;

    border:none;
    border-bottom:2px solid #000;

    background:transparent;
    outline:none;

    text-align:center;
    font-size:18px;
}


/* Fraction blank after "because" */

.time-b-fraction-input{
    width:190px;
    height:38px;

    border:1px solid #b97d68;
    border-radius:8px;

    background:#fff;

    outline:none;

    text-align:center;
    font-size:18px;

    box-shadow:
        0 3px 0 #e6b5a5;
}


/* =====================================================
   MOBILE
===================================================== */

@media(max-width:900px){

    .time-a-list{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:600px){

    .time-fraction-card{
        padding:18px;
    }

    .time-a-list{
        grid-template-columns:1fr;
        gap:20px;
    }

    .time-a-item{
        font-size:17px;
    }

    .time-b-item{
        font-size:16px;
    }

    .time-b-fraction-input{
        width:150px;
    }

}

</style>


<div class="time-fraction-card">

    <!-- =================================================
         TITLE
    ================================================== -->

    <div class="time-fraction-title">

        <?= ($index + 1) ?>.
        <?= htmlspecialchars($data['title'] ?? '') ?>

    </div>


    <!-- =================================================
         SECTION A
    ================================================== -->

    <?php if(($data['section'] ?? '') === 'A'): ?>

        <div class="time-a-list">

            <?php foreach(($data['items'] ?? []) as $item): ?>

                <?php

                    $fraction =
                        (string)($item['fraction'] ?? '');

                    $fractionParts =
                        explode('/', $fraction, 2);

                    $numerator =
                        $fractionParts[0] ?? '';

                    $denominator =
                        $fractionParts[1] ?? '';

                ?>

                <div class="time-a-item">

                    <!-- FRACTION -->

                    <span class="time-frac">

                        <span class="time-frac-num">
                            <?= htmlspecialchars($numerator) ?>
                        </span>

                        <span class="time-frac-den">
                            <?= htmlspecialchars($denominator) ?>
                        </span>

                    </span>


                    <span>
                        of 60 =
                    </span>


                    <!-- ANSWER -->

                    <input
                        type="text"
                        class="time-fraction-input"
                        name="answer[<?= $q['id'] ?>][]"
                        autocomplete="off"
                    >

                </div>

            <?php endforeach; ?>

        </div>


    <!-- =================================================
         SECTION B
    ================================================== -->

    <?php elseif(($data['section'] ?? '') === 'B'): ?>

        <div class="time-b-list">

            <?php foreach(($data['items'] ?? []) as $item): ?>

                <?php

                    $fraction =
                        (string)($item['fraction'] ?? '');

                    $fractionParts =
                        explode('/', $fraction, 2);

                    $numerator =
                        $fractionParts[0] ?? '';

                    $denominator =
                        $fractionParts[1] ?? '';

                    $result =
                        (string)($item['result'] ?? '');

                ?>

                <div class="time-b-item">

                    <!-- FIRST FRACTION -->

                    <span class="time-frac">

                        <span class="time-frac-num">
                            <?= htmlspecialchars($numerator) ?>
                        </span>

                        <span class="time-frac-den">
                            <?= htmlspecialchars($denominator) ?>
                        </span>

                    </span>


                    <span>
                        of an hour is
                    </span>


                    <!-- MINUTES BLANK -->

                    <input
                        type="text"
                        class="time-b-input"
                        name="answer[<?= $q['id'] ?>][]"
                        autocomplete="off"
                    >


                    <span>
                        minutes because
                    </span>


                    <!-- FRACTION ANSWER BLANK -->

                    <input
                        type="text"
                        class="time-b-fraction-input"
                        name="answer[<?= $q['id'] ?>][]"
                        autocomplete="off"
                    >


                        <?php if(isset($item['tail'])): ?>
                        <span><?= htmlspecialchars($item['tail']) ?></span>
                    <?php elseif($result !== ''): ?>
                        <span>of 60 is <?= htmlspecialchars($result) ?>.</span>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php endif; ?>
<?php if($mode=="short_answer"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
<?= $data['question'] ?>

</div>

<input
type="text"
class="pc-long"
name="answer[<?= $q['id']?>]">

</div>

<?php endif; ?>
<?php if($mode=="number_prime_factors"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
<?= $data['question'] ?>

</div>

<div class="pc-row">
<span><?= ucfirst($data['type']) ?> <?= $data['digits'] ?>-digit number:</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

<div class="pc-row">
<span>Prime factors:</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

</div>

<?php endif; ?>
<?php if($mode=="prime_factors_relation"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
Find all the prime factors of <?= $data['number'] ?> and arrange them in ascending order.
Now state the relation, if any, between two consecutive prime factors.

</div>

<div class="pc-row">
<span>Prime factors:</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

<div class="pc-row">
<span>Relation:</span>
<input type="text" class="pc-long" name="answer[<?= $q['id']?>][]">
</div>

</div>

<?php endif; ?>
<?php if($mode=="verify_statement"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
<?= $data['statement'] ?>

</div>

<textarea
class="pc-long"
rows="3"
name="answer[<?= $q['id']?>]"
style="border:2px solid #000; border-radius:6px; padding:8px; resize:vertical;"
></textarea>

</div>

<?php endif; ?>
<?php if($mode=="identify_prime_factorisation"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
In which of the following expressions, prime factorisation has been done?

</div>

<?php $opts = $data['options'] ?? ['Yes','No']; ?>

<?php foreach($data['expressions'] as $k=>$exp): ?>

<div class="pc-row">
<span><?= $exp['label'] ?>) <?= $exp['text'] ?></span>

<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>
<?php if($mode=="divisibility_check"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
Determine if <?= $data['number'] ?> is divisible by <?= $data['divisor'] ?>.
<?php if(!empty($data['hint'])): ?>
<br><span style="color:#0d6efd; font-weight:400; font-size:15px;">[Hint: <?= $data['hint'] ?>]</span>
<?php endif; ?>

</div>

<?php $opts = $data['options'] ?? ['Yes','No']; ?>

<div class="pc-row">
<span>Answer:</span>
<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="pc-row">
<span>Reason:</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

</div>

<?php endif; ?>
<?php if($mode=="verify_lcm_statement"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
18 is divisible by both 2 and 3. It is also divisible by 2 x 3 = 6.
Similarly, a number is divisible by both 4 and 6.
Can we say that the number must also be divisible by 4 x 6 = 24? If not, give an example to justify your answer.

</div>

<?php $opts = $data['options'] ?? ['Yes','No']; ?>

<div class="pc-row">
<span>Answer:</span>
<select name="answer[<?= $q['id']?>][]" class="pc-select">
<option value="">Select</option>
<?php foreach($opts as $o): ?>
<option value="<?= $o ?>"><?= $o ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="pc-row">
<span>Example:</span>
<input type="text" class="pc-input" name="answer[<?= $q['id']?>][]">
</div>

</div>

<?php endif; ?>
<?php if($mode=="smallest_four_prime_factors"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
I am the smallest number, having four different prime factors. Can you find me?

</div>

<input
type="text"
class="pc-long"
name="answer[<?= $q['id']?>]">

</div>

<?php endif; ?>
<?php if($mode=="select_numbers"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
<?= $data['question'] ?>

</div>

<div class="pc-row">
<?php foreach($data['numbers'] as $num): ?>
<label style="display:flex; align-items:center; gap:6px; font-size:17px;">
<input type="checkbox" name="answer[<?= $q['id']?>][]" value="<?= $num ?>">
<?= $num ?>
</label>
<?php endforeach; ?>
</div>

</div>

<?php endif; ?>
<?php if($mode=="missing_multiples"): ?>

<div class="pc-card">

<div class="pc-title">

<?= ($index+1) ?>.
Fill in the missing multiples:

</div>

<div class="pc-row">
<?php foreach($data['sequence'] as $val): ?>
    <?php if($val === ""): ?>
        <input type="text" class="pc-small" style="width:70px;" name="answer[<?= $q['id']?>][]">
    <?php else: ?>
        <span><?= $val ?></span>
    <?php endif; ?>
<?php endforeach; ?>
</div>

</div>

<?php endif; ?>
<?php if($mode=="missing_number"): ?>

<div class="pc-card">

    <div class="pc-row">

        <!-- QUESTION NUMBER -->
        <span class="missing-number-label">
            <?= ($index + 1) ?>.
        </span>

        <?php if(!empty($data['result_first'])): ?>

            <span><?= htmlspecialchars($data['result']) ?></span>
            <span>=</span>

        <?php endif; ?>

        <?php foreach($data['terms'] as $i => $term): ?>

            <?php if($term === ""): ?>

                <input
                    type="text"
                    class="pc-small"
                    style="width:130px;"
                    name="answer[<?= $q['id'] ?>]"
                    autocomplete="off"
                >

            <?php else: ?>

                <span><?= htmlspecialchars($term) ?></span>

            <?php endif; ?>

            <?php if($i < count($data['terms']) - 1): ?>
                <span>+</span>
            <?php endif; ?>

        <?php endforeach; ?>

        <?php if(empty($data['result_first'])): ?>

            <span>=</span>
            <span><?= htmlspecialchars($data['result']) ?></span>

        <?php endif; ?>

    </div>

</div>

<?php endif; ?>
<?php if($mode=="shade_fraction"): ?>
<style>
.shade-card{background:#fff;border-radius:14px;box-shadow:0 4px 12px rgba(0,0,0,.08);padding:25px 30px;margin:20px 0;}
.shade-title{font-size:19px;font-weight:700;margin-bottom:20px;color:#000;}
.shade-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:26px 40px;}
.shade-item{display:flex;align-items:center;gap:16px;}
.shade-circle{width:104px;height:104px;flex-shrink:0;}
.shade-circle .wedge{fill:#fff;stroke:#222;stroke-width:1.5;cursor:pointer;transition:fill .15s;}
.shade-circle .wedge.on{fill:#7c9cff;}
.shade-frac{display:inline-flex;flex-direction:column;align-items:center;font-size:22px;font-weight:600;}
.shade-frac .top{border-bottom:2px solid #000;padding:0 8px 3px;}
.shade-frac .bot{padding:3px 8px 0;}
@media(max-width:600px){.shade-grid{grid-template-columns:1fr;}}
</style>

<div class="shade-card">
  <div class="shade-title"><?= ($index+1) ?>. <?= htmlspecialchars($data['title'] ?? 'Shade the fraction.') ?></div>
  <div class="shade-grid">
    <?php foreach(($data['items'] ?? []) as $it):
        $f = explode('/', (string)($it['fraction'] ?? ''), 2);
        $num = (int)($f[0] ?? 0); $den = (int)($f[1] ?? 1);
    ?>
      <div class="shade-item">
        <svg class="shade-circle" viewBox="0 0 100 100" data-parts="<?= $den ?>"></svg>
        <span class="shade-frac">
          <span class="top"><?= $num ?></span>
          <span class="bot"><?= $den ?></span>
        </span>
        <input type="hidden" name="answer[<?= $q['id'] ?>][]" value="" class="shade-hidden">
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
(function(){
  function polar(cx,cy,r,a){return [cx+r*Math.cos(a),cy+r*Math.sin(a)];}
  document.querySelectorAll('.shade-circle').forEach(function(svg){
    if(svg.dataset.done) return; svg.dataset.done="1";
    var ns="http://www.w3.org/2000/svg",cx=50,cy=50,r=46;
    var parts=parseInt(svg.dataset.parts,10)||1;
    var hidden=svg.parentNode.querySelector('.shade-hidden');
    var wedges=[];
    if(parts===1){
      var c=document.createElementNS(ns,"circle");
      c.setAttribute("cx",cx);c.setAttribute("cy",cy);c.setAttribute("r",r);
      c.setAttribute("class","wedge");svg.appendChild(c);wedges.push(c);
    } else {
      for(var i=0;i<parts;i++){
        var a1=(i/parts)*2*Math.PI-Math.PI/2, a2=((i+1)/parts)*2*Math.PI-Math.PI/2;
        var p1=polar(cx,cy,r,a1),p2=polar(cx,cy,r,a2), large=(a2-a1)>Math.PI?1:0;
        var d="M"+cx+","+cy+" L"+p1[0].toFixed(2)+","+p1[1].toFixed(2)+
              " A"+r+","+r+" 0 "+large+" 1 "+p2[0].toFixed(2)+","+p2[1].toFixed(2)+" Z";
        var path=document.createElementNS(ns,"path");
        path.setAttribute("d",d);path.setAttribute("class","wedge");
        svg.appendChild(path);wedges.push(path);
      }
    }
    function update(){
      if(!hidden) return;
      var onCount = svg.querySelectorAll('.wedge.on').length;
      hidden.value = onCount > 0 ? String(onCount) : "";
    }
    wedges.forEach(function(w){ w.addEventListener('click',function(){ this.classList.toggle('on'); update(); }); });
  });
})();
</script>
<?php endif; ?>
<?php if($mode=="compare_fractions"): ?>
<style>
.cmp-card{background:#fff;border-radius:14px;box-shadow:0 4px 12px rgba(0,0,0,.08);padding:25px 30px;margin:20px 0;}
.cmp-title{font-size:19px;font-weight:700;margin-bottom:20px;color:#000;}
.cmp-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:26px 30px;}
.cmp-item{display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;}
.cmp-pie{width:66px;height:66px;flex-shrink:0;}
.cmp-pie .wedge{fill:#fff;stroke:#222;stroke-width:1.3;}
.cmp-pie .wedge.on{fill:#c9d4ff;}
.cmp-frac{display:inline-flex;flex-direction:column;align-items:center;font-size:20px;font-weight:600;}
.cmp-frac .top{border-bottom:2px solid #000;padding:0 7px 3px;}
.cmp-frac .bot{padding:3px 7px 0;}
.cmp-select{width:60px;height:40px;text-align:center;font-size:20px;border:1px solid #7c9cff;border-radius:8px;background:#eef2ff;cursor:pointer;}
@media(max-width:600px){.cmp-grid{grid-template-columns:1fr;}}
</style>

<div class="cmp-card">
  <div class="cmp-title"><?= ($index+1) ?>. <?= htmlspecialchars($data['title'] ?? 'Compare the fractions using the symbols: <, > or =') ?></div>
  <div class="cmp-grid">
    <?php foreach(($data['items'] ?? []) as $it):
        $L=explode('/',(string)($it['left']  ?? ''),2); $Ln=(int)($L[0]??0); $Ld=(int)($L[1]??1);
        $R=explode('/',(string)($it['right'] ?? ''),2); $Rn=(int)($R[0]??0); $Rd=(int)($R[1]??1);
    ?>
      <div class="cmp-item">
        <svg class="cmp-pie" viewBox="0 0 100 100" data-parts="<?= $Ld ?>" data-shade="<?= $Ln ?>"></svg>
        <span class="cmp-frac"><span class="top"><?= $Ln ?></span><span class="bot"><?= $Ld ?></span></span>

        <select name="answer[<?= $q['id'] ?>][]" class="cmp-select">
          <option value=""></option>
          <option value="&lt;">&lt;</option>
          <option value="&gt;">&gt;</option>
          <option value="=">=</option>
        </select>

        <span class="cmp-frac"><span class="top"><?= $Rn ?></span><span class="bot"><?= $Rd ?></span></span>
        <svg class="cmp-pie" viewBox="0 0 100 100" data-parts="<?= $Rd ?>" data-shade="<?= $Rn ?>"></svg>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
(function(){
  function polar(cx,cy,r,a){return [cx+r*Math.cos(a),cy+r*Math.sin(a)];}
  document.querySelectorAll('.cmp-pie').forEach(function(svg){
    if(svg.dataset.done) return; svg.dataset.done="1";
    var ns="http://www.w3.org/2000/svg",cx=50,cy=50,r=46;
    var parts=parseInt(svg.dataset.parts,10)||1, shade=parseInt(svg.dataset.shade,10)||0;
    if(parts===1){
      var c=document.createElementNS(ns,"circle");
      c.setAttribute("cx",cx);c.setAttribute("cy",cy);c.setAttribute("r",r);
      c.setAttribute("class","wedge"+(shade>0?" on":""));svg.appendChild(c);return;
    }
    for(var i=0;i<parts;i++){
      var a1=(i/parts)*2*Math.PI-Math.PI/2, a2=((i+1)/parts)*2*Math.PI-Math.PI/2;
      var p1=polar(cx,cy,r,a1),p2=polar(cx,cy,r,a2), large=(a2-a1)>Math.PI?1:0;
      var d="M"+cx+","+cy+" L"+p1[0].toFixed(2)+","+p1[1].toFixed(2)+
            " A"+r+","+r+" 0 "+large+" 1 "+p2[0].toFixed(2)+","+p2[1].toFixed(2)+" Z";
      var path=document.createElementNS(ns,"path");
      path.setAttribute("d",d);path.setAttribute("class","wedge"+(i<shade?" on":""));
      svg.appendChild(path);
    }
  });
})();
</script>
<?php endif; ?>
<?php if($mode=="prime_composite_sort"): ?>

<?php
$sortNumbers = $data['numbers'] ?? [];
?>

<div class="pc-card">

    <div class="pc-title">

        <?= ($index + 1) ?>.

        <?= htmlspecialchars(
            $q['question_text']
            ?? 'Drag and drop the numbers into the correct columns to identify prime and composite numbers.'
        ) ?>

    </div>


    <div class="prime-composite-wrapper"
         data-qid="<?= $q['id'] ?>">

        <!-- =================================================
             PRIME / COMPOSITE COLUMNS
        ================================================== -->

        <div class="sort-columns">

            <!-- PRIME -->
            <div class="sort-column">

                <div class="sort-column-title">
                    PRIME NUMBER
                </div>

                <div
                    class="sort-drop-zone"
                    data-sort-type="prime"
                ></div>

            </div>


            <!-- COMPOSITE -->
            <div class="sort-column">

                <div class="sort-column-title">
                    COMPOSITE NUMBER
                </div>

                <div
                    class="sort-drop-zone"
                    data-sort-type="composite"
                ></div>

            </div>

        </div>


        <!-- =================================================
             NUMBER POOL
        ================================================== -->

        <div class="sort-number-pool">

            <?php foreach($sortNumbers as $number): ?>

                <div
                    class="sort-number"
                    draggable="true"
                    data-number="<?= htmlspecialchars($number) ?>"
                >
                    <?= htmlspecialchars($number) ?>
                </div>

            <?php endforeach; ?>

        </div>


        <!-- =================================================
             HIDDEN ANSWER
        ================================================== -->

        <input
            type="hidden"
            name="answer[<?= $q['id'] ?>]"
            id="primeCompositeAnswer_<?= $q['id'] ?>"
            value=""
        >

    </div>

</div>

<?php endif; ?>
<script>

/* =====================================================
   PRIME / COMPOSITE SORT
===================================================== */

document.querySelectorAll('.prime-composite-wrapper').forEach(function(wrapper) {

    const qid = wrapper.dataset.qid;

    const hiddenInput =
        wrapper.querySelector('#primeCompositeAnswer_' + qid);

    const pool =
        wrapper.querySelector('.sort-number-pool');

    const dropZones =
        wrapper.querySelectorAll('.sort-drop-zone');


    /* =====================================================
       DRAG EVENTS
    ===================================================== */

    function addDragEvents(item) {

        item.addEventListener('dragstart', function(e) {

            e.dataTransfer.setData(
                'text/plain',
                this.dataset.number
            );

            e.dataTransfer.effectAllowed = 'move';

            this.classList.add('dragging');

        });


        item.addEventListener('dragend', function() {

            this.classList.remove('dragging');

        });

    }


    /* Original pool numbers */

    wrapper.querySelectorAll('.sort-number').forEach(function(item) {

        addDragEvents(item);

    });


    /* =====================================================
       DROP ZONES
    ===================================================== */

    dropZones.forEach(function(zone) {


        zone.addEventListener('dragover', function(e) {

            e.preventDefault();

            e.dataTransfer.dropEffect = 'move';

            this.classList.add('drag-over');

        });


        zone.addEventListener('dragleave', function() {

            this.classList.remove('drag-over');

        });


        zone.addEventListener('drop', function(e) {

            e.preventDefault();

            this.classList.remove('drag-over');


            const number =
                e.dataTransfer.getData('text/plain');

            if(!number) return;


            /*
             * Check if number is already
             * inside Prime or Composite.
             */

            const existing =
                wrapper.querySelector(
                    '.sort-drop-zone .sort-number[data-number="' +
                    number +
                    '"]'
                );


            /*
             * If already placed,
             * move it to the new column.
             */

            if(existing) {

                this.appendChild(existing);

                updateAnswer();

                return;

            }


            /*
             * Find original number from pool.
             */

            const original =
                pool.querySelector(
                    '.sort-number[data-number="' +
                    number +
                    '"]'
                );


            if(!original) return;


            /*
             * Clone number into selected column.
             */

            const item =
                original.cloneNode(true);

            item.classList.remove('source-used');

            item.setAttribute('draggable', 'true');

            addDragEvents(item);


            /*
             * Add to selected column.
             */

            this.appendChild(item);


            /*
             * Mark original pool number as used.
             */

            original.classList.add('source-used');


            /*
             * Update answer.
             */

            updateAnswer();

        });

    });


    /* =====================================================
       UPDATE HIDDEN ANSWER
    ===================================================== */

    function updateAnswer() {

        const result = {
            prime: [],
            composite: []
        };


        /*
         * PRIME NUMBERS
         */

        wrapper
            .querySelectorAll(
                '.sort-drop-zone[data-sort-type="prime"] .sort-number'
            )
            .forEach(function(item) {

                result.prime.push(
                    item.dataset.number
                );

            });


        /*
         * COMPOSITE NUMBERS
         */

        wrapper
            .querySelectorAll(
                '.sort-drop-zone[data-sort-type="composite"] .sort-number'
            )
            .forEach(function(item) {

                result.composite.push(
                    item.dataset.number
                );

            });


        /*
         * Save JSON
         */

        hiddenInput.value =
            JSON.stringify(result);

    }

});

</script>