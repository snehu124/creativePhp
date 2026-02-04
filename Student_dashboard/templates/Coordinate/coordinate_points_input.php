<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$q = $q ?? [];
$questionImage = trim((string)($q['question_image'] ?? ''));
$payloadRaw = (string)($q['question_payload'] ?? '[]');
$items = json_decode($payloadRaw, true);
if (!is_array($items)) $items = [];

$makeUrl = function (string $path) use ($h): string {
    if ($path === '') return '';
    if (preg_match('~^https?://~i', $path)) return $path;
    $root = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
    $root = $root === '' ? '/' : $root;
    return $root . '/' . ltrim($path, '/');
};

$imgUrl = $makeUrl($questionImage);

// Detect if coord_list → Question 3 canvas
$isQue3 = false;
foreach ($items as $item) {
    if (($item['type'] ?? '') === 'coord_list') {
        $isQue3 = true;
        break;
    }
}
?>
<style>
.coord-wrap {
    margin: 20px 0;
    padding: 0 10px;
    font-family: 'Segoe UI', sans-serif;
    max-width: none;
}

.coord-title {
    font-weight: 600;
    color: #222;
    margin: 0 0 16px 0;
    text-align: center;
    font-size: 18px;
}

.coord-img {
    width: 100%;
    max-width: 100%;
    height: auto;
    max-height: 70vh;
    display: block;
    margin: 0 0 30px 0;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    object-fit: contain;
    background: #fff;
}

.answers-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px 30px;
    max-width: 800px;
    margin: 0;
}

.answer-row {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 17px;
}

.coord-text {
    font-family: monospace;
    color: #1976d2;
}

.answer-label {
    font-weight: 600;
    min-width: 28px;
    color: #222;
}

.answer-input {
    flex: 1;
    border: none;
    border-bottom: 3px solid #2b6cb0;
    padding: 6px 0;
    font-size: 17px;
    background: transparent;
    outline: none;
    min-width: 180px;
    text-align: center;
    font-family: monospace;
}

.answer-input:focus {
    border-bottom-color: #1a73e8;
}

/* For coord_list (Question 3) */
.coord-wrap.que3 .answers-grid {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.coord-wrap.que3 .answer-row {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 12px;
}

.coord-wrap.que3 .answer-input {
    opacity: 0;
    height: 0;
    padding: 0;
    margin: 0;
    pointer-events: none;
}


/* Canvas */
.canvas-container {
    position: relative;
    width: 100%;
    max-width: 800px;
    margin: 20px 0;
    border: 1px solid #ddd;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    background: #fff;
}

#drawCanvas {
    width: 100%;
    height: 500px;
    display: block;
}

.clear-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    background: #e53e3e;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.clear-btn:hover { background: #c53030; }

@media (max-width: 600px) {
    .answers-grid { grid-template-columns: 1fr; }
}
</style>

<div class="coord-wrap <?= $isQue3 ? 'que3' : '' ?>">
    <?php if (!empty($q['question_text'])): ?>
        <div class="coord-title"><?= $h($q['question_text']) ?></div>
    <?php endif; ?>

    <?php if ($imgUrl !== '' && !$isQue3): ?>
        <img src="<?= $h($imgUrl) ?>" alt="Coordinate Grid" class="coord-img" loading="lazy">
    <?php elseif ($isQue3): ?>
    <?php if ($isQue3): ?>
<div class="letter-picker" style="margin:10px 0; display:flex; gap:10px; flex-wrap:wrap;">
  <?php foreach ($items as $item):
    if (($item['type'] ?? '') !== 'coord_list') continue;
    preg_match('/^([A-Z])\(/', $item['coord'], $m);
    $label = $m[1] ?? '';
  ?>
    <button type="button"
      class="letter-btn"
      data-letter="<?= $h($label) ?>"
      style="padding:6px 12px;border:2px solid #1976d2;border-radius:6px;
             background:#fff;color:#1976d2;font-weight:600;">
      <?= $h($label) ?>
    </button>
  <?php endforeach; ?>
</div>
<?php endif; ?>

        <div class="canvas-container">
            <canvas id="drawCanvas"></canvas>
            <button type="button" class="clear-btn" onclick="clearCanvas()">Clear</button>
        </div>
        <script>


        document.addEventListener('DOMContentLoaded', () => {
            let ACTIVE_LETTER = null;

        document.querySelectorAll('.letter-btn').forEach(btn => {
          btn.addEventListener('click', () => {
        
            document.querySelectorAll('.letter-btn').forEach(b => {
              b.style.background = '#fff';
              b.style.color = '#1976d2';
            });
        
            btn.style.background = '#1976d2';
            btn.style.color = '#fff';
        
            ACTIVE_LETTER = btn.dataset.letter;
            console.log('Selected letter:', ACTIVE_LETTER);
          });
        });

            const ANSWER_MAP = <?= json_encode(json_decode($q['correct_answer'] ?? '{}', true)); ?>;
            const canvas = document.getElementById('drawCanvas');
            const ctx = canvas.getContext('2d');
            let drawing = false;

         const container = canvas.parentElement;
        const dpr = window.devicePixelRatio || 1;
        
        // ✅ CSS size (ONLY ONCE)
        const cssWidth = container.clientWidth;
        const cssHeight = 700;
        
        // ✅ Apply CSS size
        canvas.style.width = cssWidth + 'px';
        canvas.style.height = cssHeight + 'px';
        
        // ✅ Internal pixel size
        canvas.width = cssWidth * dpr;
        canvas.height = cssHeight * dpr;
        
        // ✅ Reset + scale (safe)
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);


            const gridSize = 50;
            const margin = 60;
            const topMargin = 90;
            const rightMargin = 70;

           const drawArea = {
              left: margin,
              top: topMargin,
              right: cssWidth - rightMargin,
              bottom: cssHeight - margin,
            };


            // Grid lines
            ctx.strokeStyle = '#ddd';
            ctx.lineWidth = 1;
            for (let x = drawArea.left; x <= drawArea.right; x += gridSize) {
                ctx.beginPath();
                ctx.moveTo(x, drawArea.top);
                ctx.lineTo(x, drawArea.bottom);
                ctx.stroke();
            }
            for (let y = drawArea.top; y <= drawArea.bottom; y += gridSize) {
                ctx.beginPath();
                ctx.moveTo(drawArea.left, y);
                ctx.lineTo(drawArea.right, y);
                ctx.stroke();
            }

            // Axes
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;

            // X-axis
            ctx.beginPath();
            ctx.moveTo(drawArea.left, drawArea.bottom);
            ctx.lineTo(drawArea.right, drawArea.bottom);
            ctx.lineTo(drawArea.right - 10, drawArea.bottom - 10);
            ctx.moveTo(drawArea.right, drawArea.bottom);
            ctx.lineTo(drawArea.right - 10, drawArea.bottom + 10);
            ctx.stroke();

            // Y-axis
            // Y-axis (extend arrow to reach the full 10 grid)
            ctx.beginPath();
            ctx.moveTo(drawArea.left, drawArea.bottom);
            ctx.lineTo(drawArea.left, drawArea.top - 20); // extend 20px higher for arrow tip
            ctx.lineTo(drawArea.left - 8, drawArea.top);  // left wing
            ctx.moveTo(drawArea.left, drawArea.top - 20);
            ctx.lineTo(drawArea.left + 8, drawArea.top);  // right wing
            ctx.stroke();


            // Labels
            ctx.font = '14px monospace';
            ctx.fillStyle = '#000';

            // X-axis 0–10
            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';
            for (let i = 0; i <= 10; i++) {
                const x = drawArea.left + i * gridSize;
                ctx.fillText(i, x, drawArea.bottom + 8);
            }
            ctx.fillText('x-axis', drawArea.right - 20, drawArea.bottom + 25);
            // Y-axis 0–10
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';
            for (let i = 0; i <= 10; i++) {
                const y = drawArea.bottom - i * gridSize;
                ctx.fillText(i, drawArea.left - 8, y);
            }

            ctx.save();
            ctx.translate(15, 80);
            ctx.rotate(-Math.PI / 2);
            ctx.fillText('y-axis', 0, 0);
            ctx.restore();

            // Drawing
            canvas.addEventListener('mousedown', () => drawing = true);
            canvas.addEventListener('mouseup', () => drawing = false);
    let FREE_MODE = true; // 🔥 true = cursor exact | false = grid snap

 canvas.addEventListener('click', (e) => {
       if (!ACTIVE_LETTER) {
    alert('Please select a letter first');
    return;
  }
  const rect = canvas.getBoundingClientRect();
  const xPix = e.clientX - rect.left;
  const yPix = e.clientY - rect.top;

if (
  xPix < drawArea.left ||
  xPix > drawArea.right ||
  yPix < drawArea.top ||
  yPix > drawArea.bottom
) return;

  const gridX = Math.round((xPix - drawArea.left) / gridSize);
  const gridY = Math.round((drawArea.bottom - yPix) / gridSize);

  if (gridX < 0 || gridX > 10 || gridY < 0 || gridY > 10) return;

  const drawX = drawArea.left + gridX * gridSize;
  const drawY = drawArea.bottom - gridY * gridSize;

// outer circle
ctx.strokeStyle = '#d00';
ctx.lineWidth = 2;
ctx.beginPath();
ctx.arc(drawX, drawY, 6, 0, Math.PI * 2);
ctx.stroke();

// inner dot
ctx.fillStyle = '#d00';
ctx.beginPath();
ctx.arc(drawX, drawY, 2.5, 0, Math.PI * 2);
ctx.fill();


  const coord = `(${gridX},${gridY})`;

document.querySelectorAll('.coord-text').forEach(el => {
  const full = el.textContent.replace(/\s/g,'');
  const letter = full.charAt(0);
  const point  = full.replace(letter,'');

  // old behaviour (auto match)
  if (!ACTIVE_LETTER && point === coord) {
    const row = el.closest('.answer-row');
    const input = row.querySelector('.answer-input');
    if (input) input.value = letter;
  }

  // new behaviour (manual letter selection)
  if (ACTIVE_LETTER && letter === ACTIVE_LETTER) {
    const row = el.closest('.answer-row');
    const input = row.querySelector('.answer-input');
    if (input) input.value = ACTIVE_LETTER;
  }
});
});

            window.clearCanvas = function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                const event = new Event('DOMContentLoaded');
                document.dispatchEvent(event);
            };
        });
        </script>
    <?php else: ?>
        <div style="height:400px; border:2px dashed #eee; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#ccc;">
            [No Image]
        </div>
    <?php endif; ?>

    <div class="answers-grid">
        <?php 
        $counter = 1;
        foreach ($items as $item):
            $part = $item['part'] ?? '';
            $label = $item['label'] ?? '';
            $coord = $item['coord'] ?? '';
            $type = $item['type'] ?? 'coord_to_name';
            if (!$part) continue;

            $displayLabel = $label;
            if ($type === 'coord_to_name' && $label === '') {
                $displayLabel = $counter++;
            }
        ?>
            <div class="answer-row">
                <div class="answer-label"><?= $h($displayLabel) ?></div>
                <?php if ($type === 'coord_to_name' || $type === 'coord_list'): ?>
                    <div class="coord-text"><?= $h($coord) ?></div>
                <?php endif; ?>
               <input type="text"
                   name="answer[<?= (int)$q['id'] ?>][<?= preg_replace('/[^a-zA-Z0-9_]/', '', $part) ?>]"
                   class="answer-input"
                   placeholder="<?= ($type === 'name_to_coord') ? '(x, y)' : '' ?>"
                   maxlength="<?= ($type === 'name_to_coord') ? 10 : 1 ?>">
            </div>
        <?php endforeach; ?>
    </div>
</div>
