<style>
.histogram-card{
    margin: 10px 0;
    padding: 15px;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    width: 100%;
}

/* Image */
.histogram-img{
    text-align:center;
    margin-bottom:15px;
}
.histogram-img img{
    max-width:100%;
    height:auto;
    border-radius:10px;
}

/* Table */
.table-box{
    overflow-x:auto;
}

.table-box table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
    min-width:500px;
}

.table-box th, .table-box td{
    border:1px solid #ccc;
    padding:8px;
    text-align:center;
    font-size:14px;
}

.table-box input{
    width:60px;
    border:none;
    border-bottom:2px solid #ccc;
    text-align:center;
    outline:none;
    font-size:14px;
}

/* Max interval */
.max-box{
    margin-top:38px;
}
.max-box select{
    padding:6px;
    width:100%;
    max-width:250px;
    margin-top: 16px;
}

/* 📱 MOBILE FIX */
@media (max-width:768px){

    .histogram-card{
        padding:12px;
    }

    .table-box table{
        min-width:600px; 
    }

    .table-box input{
        width:50px;
        font-size:13px;
    }

    .max-box select{
        width:100%;
    }

    h6{
        font-size:15px;
        line-height:1.4;
    }
}
</style>

<?php
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$questionImage = trim((string)($q['question_image'] ?? ''));

$makeUrl = fn($path) => $path && !preg_match('~^https?://~i', $path)
    ? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/') . '/' . ltrim($path, '/')
    : $path;

$imgUrl = $makeUrl($questionImage);

$payload = json_decode($q['question_payload'], true) ?: [];

$intervals = $payload['intervals'] ?? [];
$sub_questions = $payload['sub_questions'] ?? [];

$real_question_id = $q['id'] ?? 0;
?>

<div class="histogram-card">

    <!-- IMAGE -->
    <?php if ($questionImage): ?>
        <div class="histogram-img">
            <img src="<?= $h($imgUrl) ?>" alt="Histogram" loading="lazy">
        </div>
    <?php endif; ?>

    <!-- ✅ SUB QUESTIONS (->
    <?php if(!empty($sub_questions)): ?>
        <div style="margin:15px 0;">
            <?php foreach($sub_questions as $index => $sq): ?>
                <p style="margin:5px 0; font-weight:500;">
                    <?= ($index + 1) ?>. <?= htmlspecialchars($sq) ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <tr>
                <th>Interval</th>
                <th>Frequency</th>
                <th>Cumulative</th>
            </tr>

            <?php foreach($intervals as $i => $interval): ?>
            <tr>
                <td><?= $interval ?></td>

                <td>
                    <input type="text"
                        name="answer[<?= $real_question_id ?>][freq][<?= $i ?>]">
                </td>

                <td>
                    <input type="text"
                        name="answer[<?= $real_question_id ?>][cum][<?= $i ?>]">
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

    <!-- MAX INTERVAL -->
    <div class="max-box">
        <label><b>Which interval has maximum frequency?</b></label><br>

        <select name="answer[<?= $real_question_id ?>][max_interval]">
            <option value="">Select</option>
            <?php foreach($intervals as $interval): ?>
                <option value="<?= $interval ?>"><?= $interval ?></option>
            <?php endforeach; ?>
        </select>
    </div>

</div>