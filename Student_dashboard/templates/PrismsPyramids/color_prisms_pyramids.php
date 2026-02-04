<?php
declare(strict_types=1);

// ---------- SAFE GUARDS ----------
$q = $q ?? [];
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// ---------- AUTO INDEX ----------
if (!isset($GLOBALS['__q_auto_index'])) $GLOBALS['__q_auto_index'] = 0;
$idx = isset($q['serial']) && (int)$q['serial'] > 0 ? (int)$q['serial'] : ++$GLOBALS['__q_auto_index'];
$question_label = ($idx >= 1 && $idx <= 26) ? chr(ord('a') + ($idx - 1)) : (string)$idx;

// ---------- 12 SHAPES ----------
$items = range(1,12);
?>

<style>
    .quiz-wrap {
        display: flex;
        gap: 35px;
        margin: 25px 0;
        flex-wrap: wrap;
    }

    .svg-container {
        flex: 1;
        min-width: 500px;
        background: #fff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .18);
    }

    .shapes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        justify-items: center;
    }

    .shape {
        cursor: pointer;
        stroke: #000;
        stroke-width: 1.8;
        fill: #f8f9fa;
        transition: .25s;
    }

    /* सभी faces पर color effect */
    .shape polygon,
    .shape ellipse {
        transition: fill 0.25s, stroke 0.25s;
    }

    .shape.blue,
    .shape.blue polygon,
    .shape.blue ellipse {
        fill: rgba(13, 110, 253, .25) !important;
        stroke: #0d6efd !important;
    }

    .shape.red,
    .shape.red polygon,
    .shape.red ellipse {
        fill: rgba(220, 53, 69, .25) !important;
        stroke: #dc3545 !important;
    }

    .picker-box {
        width: 260px;
        padding: 22px;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .18);
        background: white;
    }

    .pick-btn {
        width: 100%;
        border: none;
        border-radius: 12px;
        padding: 18px;
        margin: 10px 0;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
    }

    .pick-btn.blue  { background:#0d6efd; color:white; }
    .pick-btn.red   { background:#dc3545; color:white; }
    .pick-btn.active{ transform:scale(1.05); }

    .help-text { font-size:13px; color:#555; margin-top:8px; }

    svg { width:100%; height:auto; }
</style>

<div class="quiz-wrap">

    <div class="svg-container">
        <div class="shapes-grid">

            <!-- 1. Triangular Pyramid -->
            <svg viewBox="0 0 120 120" class="shape" data-id="1">
                <polygon points="60,20 25,95 95,95" fill="#f8f9fa"/>
                <line x1="60" y1="20" x2="25" y2="95"/>
                <line x1="60" y1="20" x2="95" y2="95"/>
                <line x1="25" y1="95" x2="95" y2="95"/>
                <line x1="60" y1="20" x2="60" y2="70" stroke-dasharray="4,3"/>
                <line x1="60" y1="70" x2="25" y2="95" stroke-dasharray="4,3"/>
                <line x1="60" y1="70" x2="95" y2="95" stroke-dasharray="4,3"/>
            </svg>

            <!-- 2. Pentagonal Pyramid -->
            <svg viewBox="0 0 120 120" class="shape" data-id="2">
                <polygon points="60,15 25,65 40,95 80,95 95,65" fill="#f8f9fa"/>
                <line x1="60" y1="15" x2="25" y2="65"/>
                <line x1="60" y1="15" x2="95" y2="65"/>
                <line x1="60" y1="15" x2="40" y2="95" stroke-dasharray="4,3"/>
                <line x1="60" y1="15" x2="80" y2="95" stroke-dasharray="4,3"/>
                <line x1="25" y1="65" x2="40" y2="95"/>
                <line x1="95" y1="65" x2="80" y2="95"/>
                <line x1="40" y1="95" x2="80" y2="95"/>
                <line x1="60" y1="15" x2="60" y2="75" stroke-dasharray="4,3"/>
            </svg>

            <!-- 3. Cube (हर face fill होगा) -->
            <svg viewBox="0 0 140 140" class="shape" data-id="3">
                <polygon points="50,20 100,40 50,60 0,40" fill="#f8f9fa"/>
                <polygon points="0,40 50,60 50,115 0,95" fill="#f8f9fa"/>
                <polygon points="100,40 50,60 50,115 100,95" fill="#f8f9fa"/>
                <line x1="50" y1="20" x2="100" y2="40" stroke="#000" stroke-width="2"/>
                <line x1="50" y1="20" x2="0"   y2="40" stroke="#000" stroke-width="2"/>
                <line x1="0"  y1="40" x2="0"   y2="95" stroke="#000" stroke-width="2"/>
                <line x1="50" y1="60" x2="50"  y2="115" stroke="#000" stroke-width="2"/>
                <line x1="100"y1="40" x2="100" y2="95" stroke="#000" stroke-width="2"/>
                <line x1="0"  y1="95" x2="50"  y2="115" stroke="#000" stroke-width="2"/>
                <line x1="100"y1="95" x2="50"  y2="115" stroke="#000" stroke-width="2"/>
            </svg>

            <!-- 4. Trapezoidal Prism (हर face fill होगा) -->
            <svg viewBox="0 0 140 120" class="shape" data-id="4">
                <polygon points="45,30 95,30 105,50 35,50" fill="#f8f9fa" stroke="#000" stroke-width="3"/>
                <polygon points="35,50 105,50 95,95 45,95" fill="#f8f9fa" stroke="#000" stroke-width="3"/>
                <polygon points="95,30 105,50 95,95 85,85" fill="#f8f9fa" stroke="#000" stroke-width="3"/>
            </svg>

            <!-- 5. Cone -->
            <svg viewBox="0 0 120 120" class="shape" data-id="5">
                <ellipse cx="60" cy="90" rx="40" ry="12" fill="#f8f9fa"/>
                <line x1="60" y1="25" x2="20" y2="90"/>
                <line x1="60" y1="25" x2="100" y2="90"/>
                <ellipse cx="60" cy="90" rx="40" ry="12" fill="none" stroke-dasharray="4,3"/>
            </svg>

            <!-- 6. Hexagonal Prism -->
            <svg viewBox="0 0 120 120" class="shape" data-id="6">
                <polygon points="40,30 60,30 70,40 60,50 40,50 30,40" fill="#f8f9fa"/>
                <polygon points="40,70 60,70 70,80 60,90 40,90 30,80" fill="#f8f9fa"/>
                <line x1="40" y1="30" x2="40" y2="70"/>
                <line x1="60" y1="30" x2="60" y2="70"/>
                <line x1="70" y1="40" x2="70" y2="80"/>
                <line x1="30" y1="40" x2="30" y2="80"/>
                <line x1="40" y1="30" x2="60" y2="30"/>
                <line x1="40" y1="70" x2="60" y2="70"/>
            </svg>

            <!-- 7. Pentagonal Pyramid -->
            <svg viewBox="0 0 120 120" class="shape" data-id="7">
                <polygon points="60,20 30,60 45,90 75,90 90,60" fill="#f8f9fa"/>
                <line x1="60" y1="20" x2="30" y2="60"/>
                <line x1="60" y1="20" x2="90" y2="60"/>
                <line x1="60" y1="20" x2="45" y2="90" stroke-dasharray="4,3"/>
                <line x1="60" y1="20" x2="75" y2="90" stroke-dasharray="4,3"/>
                <line x1="30" y1="60" x2="45" y2="90"/>
                <line x1="90" y1="60" x2="75" y2="90"/>
                <line x1="45" y1="90" x2="75" y2="90"/>
            </svg>

            <!-- 8. Square Pyramid -->
            <svg viewBox="0 0 120 120" class="shape" data-id="8">
                <polygon points="40,50 80,50 80,90 40,90" fill="#f8f9fa"/>
                <line x1="60" y1="20" x2="40" y2="50"/>
                <line x1="60" y1="20" x2="80" y2="50"/>
                <line x1="60" y1="20" x2="40" y2="90" stroke-dasharray="4,3"/>
                <line x1="60" y1="20" x2="80" y2="90" stroke-dasharray="4,3"/>
                <line x1="40" y1="50" x2="80" y2="50"/>
                <line x1="40" y1="90" x2="80" y2="90"/>
                <line x1="40" y1="50" x2="40" y2="90"/>
                <line x1="80" y1="50" x2="80" y2="90"/>
            </svg>

            <!-- 9. Triangular Pyramid (side view) -->
            <svg viewBox="0 0 120 120" class="shape" data-id="9">
                <polygon points="60,30 30,90 90,90" fill="#f8f9fa"/>
                <line x1="60" y1="30" x2="30" y2="90"/>
                <line x1="60" y1="30" x2="90" y2="90"/>
                <line x1="30" y1="90" x2="90" y2="90"/>
                <line x1="60" y1="30" x2="60" y2="70" stroke-dasharray="4,3"/>
            </svg>

            <!-- 10. Cylinder -->
            <svg viewBox="0 0 120 120" class="shape" data-id="10">
                <ellipse cx="60" cy="30" rx="35" ry="10" fill="#f8f9fa"/>
                <ellipse cx="60" cy="90" rx="35" ry="10" fill="#f8f9fa"/>
                <line x1="25" y1="30" x2="25" y2="90"/>
                <line x1="95" y1="30" x2="95" y2="90"/>
                <ellipse cx="60" cy="90" rx="35" ry="10" fill="none" stroke-dasharray="4,3"/>
            </svg>

            <!-- 11. Pentagonal Prism -->
            <svg viewBox="0 0 120 120" class="shape" data-id="11">
                <polygon points="40,30 60,30 75,45 60,60 40,60 25,45" fill="#f8f9fa"/>
                <polygon points="40,70 60,70 75,85 60,100 40,100 25,85" fill="#f8f9fa"/>
                <line x1="40" y1="30" x2="40" y2="70"/>
                <line x1="60" y1="30" x2="60" y2="70"/>
                <line x1="75" y1="45" x2="75" y2="85"/>
                <line x1="25" y1="45" x2="25" y2="85"/>
            </svg>

            <!-- 12. Frustum (Cone cut) -->
            <svg viewBox="0 0 120 120" class="shape" data-id="12">
                <ellipse cx="60" cy="35" rx="25" ry="8" fill="#f8f9fa"/>
                <ellipse cx="60" cy="90" rx="40" ry="12" fill="#f8f9fa"/>
                <line x1="35" y1="35" x2="20" y2="90"/>
                <line x1="85" y1="35" x2="100" y2="90"/>
                <ellipse cx="60" cy="90" rx="40" ry="12" fill="none" stroke-dasharray="4,3"/>
            </svg>

        </div>

       <?php foreach ($items as $id): ?>
        <input
            type="hidden"
            id="ans_<?= (int)$q['id'] ?>_<?= (int)$id ?>"
            name="answer[<?= (int)$q['id'] ?>][<?= (int)$id ?>]"
            value=""
        >
    <?php endforeach; ?>

    </div>

    <div class="picker-box">
        <button type="button" class="pick-btn blue" data-color="blue">Blue (Prism)</button>
        <button type="button" class="pick-btn red" data-color="red">Red (Pyramid)</button>
        <p class="help-text">Click color → Click shape</p>
    </div>

</div>

<script>
    let chosenColor = null;

    // Color button click
    document.querySelectorAll(".pick-btn").forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll(".pick-btn").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            chosenColor = btn.dataset.color;
        };
    });

    // Shape click
    document.querySelectorAll(".shape").forEach(s => {
        s.onclick = () => {
            if (!chosenColor) {
                alert("Pick color first!");
                return;
            }

            // Remove old color from SVG and all its polygons/ellipses
            s.classList.remove("red", "blue");
            s.querySelectorAll("polygon, ellipse").forEach(el => {
                el.classList.remove("red", "blue");
            });

            // Apply new color to SVG and all faces
            s.classList.add(chosenColor);
            s.querySelectorAll("polygon, ellipse").forEach(el => {
                el.classList.add(chosenColor);
            });

            // Save answer in hidden input
            const id = s.dataset.id;
            if (id) {
               document.getElementById("ans_<?= (int)$q['id'] ?>_" + id).value = chosenColor;
            }
        };
    });
</script>