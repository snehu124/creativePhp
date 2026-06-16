<?php
declare(strict_types=1);

$q = $q ?? [];

$payload = json_decode(
    $q['question_payload'] ?? '{}',
    true
);

$line   = $payload['line'] ?? '';
$length = (int)($payload['length'] ?? 0);

$qid = (int)$q['id'];

$char = $char ?? '';

?>


<style>

.pb-box{
    width:100%;
    margin:20px 0;
    font-family:'Segoe UI',sans-serif;
}

.pb-title{
    font-size:20px;
    font-weight:600;
    margin-bottom:15px;
}

.pb-sub{
    font-size:18px;
    margin-bottom:15px;
}

.pb-canvas{
    width:100%;
    max-width:900px;
    height:260px;
    border:1px solid #ccc;
    border-radius:12px;
    background:#fff;
}

.pb-footer{
    margin-top:20px;
    display:flex;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.pb-input{
    width:120px;
    border:none;
    border-bottom:2px solid #000;
    text-align:center;
    font-size:18px;
    outline:none;
    background:transparent;
}

</style>

<div class="pb-box">

    <div class="pb-title">
        (<?= htmlspecialchars($char) ?>)
        Draw the Perpendicular Bisector
    </div>

    <div class="pb-sub">
        Line Segment
        <strong><?= htmlspecialchars($line) ?></strong>
        =
        <strong><?= $length ?> cm</strong>
    </div>

    <canvas
    class="pb-canvas"
    data-length="<?= $length ?>"
    data-qid="<?= $qid ?>"
    data-line="<?= htmlspecialchars($line) ?>"
    ></canvas>

    <div class="pb-footer">

        <label>
            Midpoint =
        </label>

        <input
            type="text"
            name="answer[<?= $qid ?>]"
            class="pb-input"
            placeholder="cm"
        >
        <input
    type="hidden"
    class="correct-midpoint"
    value="<?= $length / 2 ?>"
>

    </div>

</div>
<script>

document.querySelectorAll('.pb-box').forEach(box => {

    const input = box.querySelector('.pb-input');
    const canvas = box.querySelector('.pb-canvas');

    const correct = parseFloat(
        box.querySelector('.correct-midpoint').value
    );

    const ctx = canvas.getContext('2d');

    function drawBase(){

        canvas.width = canvas.offsetWidth;
        canvas.height = 260;

        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );

        const startX = 180;
        const endX   = canvas.width - 180;
        const midX   = (startX + endX) / 2;

        ctx.lineWidth = 3;
        ctx.strokeStyle = "#000";

        // line segment
        ctx.beginPath();
        ctx.moveTo(startX,130);
        ctx.lineTo(endX,130);
        ctx.stroke();

        ctx.font = "22px Arial";
        ctx.fillStyle = "#000";

        const line = canvas.dataset.line || "AB";

        const p1 = line.charAt(0);
        const p2 = line.charAt(1);

        ctx.fillText(
            p1,
            startX - 25,
            136
        );

        ctx.fillText(
            p2,
            endX + 10,
            136
        );

        return {
            startX,
            endX,
            midX
        };
    }

    drawBase();

    input.addEventListener('input', function(){

        const pos = drawBase();

        const value = parseFloat(
            this.value
        );

        if(value === correct){

            // perpendicular bisector

            ctx.strokeStyle = "#d40000";
            ctx.lineWidth = 3;

            ctx.beginPath();
            ctx.moveTo(
                pos.midX,
                40
            );

            ctx.lineTo(
                pos.midX,
                220
            );

            ctx.stroke();

            // midpoint dot

            ctx.fillStyle = "#0066ff";

            ctx.beginPath();
            ctx.arc(
                pos.midX,
                130,
                5,
                0,
                Math.PI * 2
            );

            ctx.fill();

            // labels

            ctx.fillStyle = "#000";
            ctx.font = "22px Arial";

            ctx.fillText(
                "P",
                pos.midX + 10,
                40
            );

            ctx.fillText(
                "Q",
                pos.midX + 10,
                235
            );
        }

    });

});
</script>