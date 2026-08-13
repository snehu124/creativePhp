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