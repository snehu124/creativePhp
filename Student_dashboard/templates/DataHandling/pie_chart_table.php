<?php
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');

$payload = json_decode($q['question_payload'] ?? '', true) ?: [];

$items = $payload['items'] ?? [];
$real_question_id = $q['id'] ?? 0;

// ✅ image only once
if (!isset($GLOBALS['pie_table_img'])) {
    $GLOBALS['pie_table_img'] = false;
}
?>

<style>
.pie-table-card{
    margin: 15px auto;
    padding: 20px;
    border-radius: 12px;
    background: #fff;
    max-width: 900px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.pie-img{
    text-align:center;
    margin-bottom:20px;
}
.pie-img img{
    max-width:600px;
    width:100%;
}

.table-wrap{
    overflow-x:auto;
}

.table-wrap table{
    width:100%;
    border-collapse:collapse;
}

.table-wrap th, .table-wrap td{
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

.table-wrap input{
    width:80px;
    border:none;
    border-bottom:2px solid #333;
    text-align:center;
    outline:none;
}
</style>

<!-- ✅ IMAGE -->
<?php if(!$GLOBALS['pie_table_img'] && !empty($q['question_image'])): ?>
    <div class="pie-img">
        <img src="<?= $h($q['question_image']) ?>">
    </div>
    <?php $GLOBALS['pie_table_img'] = true; ?>
<?php endif; ?>

<div class="pie-table-card">

    <h6><?= $char ?>. <?= $h($q['question_text']) ?></h6>
    <?php $char++; ?>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Category</th>
                <th>No. of students</th>
                <th>Size of an angle</th>
            </tr>

            <?php foreach($items as $i => $row): ?>
            <tr>
                <td><?= $h($row['label']) ?></td>
                <td><?= $h($row['value']) ?></td>

                <td>
                    <input type="text"
                        name="answer[<?= $real_question_id ?>][angles][<?= $i ?>]">
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>