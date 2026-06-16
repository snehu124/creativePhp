<?php
$q = $q ?? [];

$payload = json_decode(
    $q['question_payload'] ?? '{}',
    true
) ?: [];

$qid = (int)$q['id'];

$angleName =
$payload['name'] ?? '';

$angle =
(int)($payload['angle'] ?? 0);

$correctData = json_decode(
    $q['correct_answer'] ?? '{}',
    true
) ?: [];

$correctDrawnAngle =
(int)($correctData['drawn_angle'] ?? 0);

$correctBisector =
(int)($correctData['bisect'] ?? 0);

$char = $char ?? '';
?>

<style>

.bisector-box{
    margin:25px 0;
}

.bisector-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:15px;
}

.bisector-canvas{
    width:100%;
    max-width:800px;
    height:300px;
    border:1px solid #ccc;
    border-radius:12px;
    background:#fff;
}

.bisector-footer{
    margin-top:20px;
}

.bisector-input{
    width:120px;
    border:none;
    border-bottom:2px solid #000;
    text-align:center;
    font-size:18px;
    outline:none;
    background:transparent;
}

.angle-info{
    margin-top:15px;
    font-size:18px;
    font-weight:600;
}
</style>

<div class="bisector-box">

<div class="bisector-title">
    <?= $char . '. ' ?>
    ∠<?= htmlspecialchars($angleName) ?>
    = <?= $angle ?>°
</div>

<?php $char++; ?>
    <canvas
        class="bisector-canvas"
        data-angle="<?= $angle ?>"
        data-name="<?= htmlspecialchars($angleName) ?>"
    ></canvas>

    <input
        type="hidden"
        name="drawn_angle[<?= $qid ?>]"
        class="drawn-angle"
    >

    <div class="angle-info">
        Drawn Angle:
        <span class="angle-value">—</span>
    </div>

    <div class="bisector-footer">

        Bisected Angle =

        <input
            type="text"
            class="bisector-input"
        >
        <input
        type="hidden"
        class="final-answer"
        name="answer[<?= $qid ?>]"
    >

        <input
            type="hidden"
            class="correct-bisector"
            value="<?= $correctBisector ?>"
        >
    </div>

</div>

<script>

document
.querySelectorAll('.bisector-canvas')
.forEach(canvas => {

    const box =
    canvas.closest('.bisector-box');

    const hidden =
    box.querySelector('.drawn-angle');
    
    const answerInput =
    box.querySelector('.bisector-input');
    
    const finalAnswer =
    box.querySelector('.final-answer');
    const correctBisector =
    parseFloat(
        box.querySelector('.correct-bisector').value
    );

    const angleText =
    box.querySelector('.angle-value');

    const ctx =
    canvas.getContext('2d');
    const angleName =
    canvas.dataset.name || '';
    canvas.width = 800;
    canvas.height = 300;

    let angle = null;
    let dragging = false;
    let showBisector = false;

    function draw(){

        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );

        const cx = 250;
        const cy = 220;
        const r  = 120;

        ctx.lineWidth = 3;
        ctx.strokeStyle = '#000';

        // Base ray

        ctx.beginPath();
        ctx.moveTo(cx,cy);
        ctx.lineTo(cx + r,cy);
        ctx.stroke();

        if(angle === null){

    if(angleName.length === 3){

        ctx.font = "22px Arial";
        ctx.fillStyle = "#000";

       ctx.fillText(
        angleName[1],
        cx - 20,
        cy + 8
    );
    
    ctx.fillText(
        angleName[2],
        cx + r + 10,
        cy + 8
    );
    }

    return;
}

        // Second ray

        ctx.strokeStyle='red';

        ctx.beginPath();

        ctx.moveTo(cx,cy);

        ctx.lineTo(
            cx + r * Math.cos(
                -angle * Math.PI / 180
            ),
            cy + r * Math.sin(
                -angle * Math.PI / 180
            )
        );

        ctx.stroke();
        

        angleText.textContent =
        Math.round(angle) + '°';

        hidden.value =
        Math.round(angle);
        finalAnswer.value = JSON.stringify({
        drawn_angle: Math.round(angle),
        bisect: parseFloat(answerInput.value) || 0
    });
        if(angleName.length === 3){

    const first  = angleName[0];
    const middle = angleName[1];
    const last   = angleName[2];

    ctx.font = "22px Arial";
    ctx.fillStyle = "#000";

    
    ctx.fillText(
        middle,
        cx - 20,
        cy + 8
    );
    
    ctx.fillText(
        last,
        cx + r + 10,
        cy + 8
    );

    // slanted ray end
    if(angle !== null){

        const redX =
        cx + r * Math.cos(
            -angle * Math.PI / 180
        );

        const redY =
        cy + r * Math.sin(
            -angle * Math.PI / 180
        );

        ctx.fillText(
            first,
            redX + 10,
            redY
        );
    }
}
        if(showBisector){

    const half = angle / 2;

    ctx.strokeStyle = 'blue';
    ctx.lineWidth = 3;

    ctx.beginPath();

    ctx.moveTo(cx,cy);

    ctx.lineTo(
        cx + (r - 20) * Math.cos(
            -half * Math.PI / 180
        ),
        cy + (r - 20) * Math.sin(
            -half * Math.PI / 180
        )
    );

    ctx.stroke();
}
    }

    function update(e){

        const rect =
        canvas.getBoundingClientRect();

        const x =
        e.clientX - rect.left;

        const y =
        e.clientY - rect.top;

        const cx = 250;
        const cy = 220;

        let deg =
        Math.atan2(
            cy - y,
            x - cx
        ) * 180 / Math.PI;

        if(deg < 0){
            deg += 360;
        }

        if(deg > 180){
            deg = 180;
        }

        angle = deg;

        draw();
        
        
    }
    
    answerInput.addEventListener(
'input',
function(){

    const value =
    parseFloat(this.value);

    if(
        isNaN(value) ||
        angle === null
    ){
        showBisector = false;
        draw();
        return;
    }

    if(value === correctBisector){
        showBisector = true;
    }else{
        showBisector = false;
    }

    draw();
    finalAnswer.value = JSON.stringify({
    drawn_angle: Math.round(angle),
    bisect: value
});

});

    canvas.addEventListener(
        'mousedown',
        e=>{
            dragging=true;
            update(e);
        }
    );

    canvas.addEventListener(
        'mousemove',
        e=>{
            if(dragging){
                update(e);
            }
        }
    );

    document.addEventListener(
        'mouseup',
        ()=>{
            dragging=false;
        }
    );

    draw();

});


</script>