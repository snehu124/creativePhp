<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$q = $q ?? [];

$payload = json_decode($q['question_payload'] ?? '{}', true);

$min  = (int)($payload['min'] ?? 0);
$max  = (int)($payload['max'] ?? 180);
$text = (string)($payload['text'] ?? '');

$qid  = (int)$q['id'];
$char = $char ?? '';
?>

<style>
.angle-box {
  width: 100%;
  margin: 24px 0;
  font-family: 'Segoe UI', sans-serif;
}

.angle-instruction {
  font-size: 15px;
  font-weight: 500;
  color: #333;
}

.angle-help {
  font-size: 13px;
  color: #666;
  margin-top: 4px;
}

/* FULL WIDTH CANVAS */
.angle-canvas-wrap {
  width: 100%;
  margin-top: 16px;
}

.angle-canvas {
  width: 100%;
  height: 280px;
  border: 1px solid #ccc;
  border-radius: 12px;
  background: #fff;
  touch-action: none;
}

/* footer */
.angle-footer {
  margin-top: 14px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}

.angle-deg {
  font-size: 18px;
  font-weight: 600;
}

.angle-type {
  font-size: 14px;
  color: #666;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .angle-canvas {
    height: 240px;
  }
}

@media (max-width: 480px) {
  .angle-canvas {
    height: 210px;
  }
}
</style>

<div class="angle-box">

  <!-- QUESTION TEXT -->
  <div class="angle-instruction">
    (<?= $h($char) ?>) <?= $h($text) ?>
  </div>

  <div class="angle-help">
    Draw the angle correctly using the canvas below.  
    The angle type will be detected automatically.
  </div>

  <!-- CANVAS -->
  <div class="angle-canvas-wrap">
    <canvas class="angle-canvas" data-type="range" data-qid="<?= $qid ?>"></canvas>
  </div>

  <!-- IMPORTANT: EMPTY = NOT ATTEMPTED -->
  <input type="hidden" name="angle_value[<?= $qid ?>]" class="angle-hidden" value="">
  <input type="hidden" name="answer[<?= $qid ?>]" class="angle-answer" value="">

  <!-- DISPLAY -->
  <div class="angle-footer">
    <div class="angle-deg">—</div>
    <div class="angle-type">Not attempted</div>
  </div>

</div>

<script>
(function () {

  function getType(deg){
    if (deg === 180) return ['straight', 'Straight Angle'];
    if (deg === 90)  return ['right', 'Right Angle'];
    if (deg < 90)    return ['acute', 'Acute Angle'];
    if (deg < 180)   return ['obtuse', 'Obtuse Angle'];
    return ['', '—'];
  }

  document.querySelectorAll('.angle-canvas[data-type="range"]').forEach(canvas => {

    const box    = canvas.closest('.angle-box');
    const degEl  = box.querySelector('.angle-deg');
    const typeEl = box.querySelector('.angle-type');
    const hidden = box.querySelector('.angle-hidden');
    const answer = box.querySelector('.angle-answer');

    const ctx = canvas.getContext('2d');

    let angle = null;
    let dragging = false;

    function resize() {
      const dpr = window.devicePixelRatio || 1;
      const w = canvas.clientWidth;
      const h = canvas.clientHeight;
      canvas.width  = w * dpr;
      canvas.height = h * dpr;
      ctx.setTransform(dpr,0,0,dpr,0,0);
      draw();
    }

 function draw() {
  const w = canvas.clientWidth;
  const h = canvas.clientHeight;

  const cx = w / 2;
  const cy = h / 2;

  const R = Math.min(w, h) * 0.38;

  ctx.clearRect(0, 0, w, h);

  /* ================= BASE LINE (CENTERED) ================= */
  ctx.strokeStyle = '#000';
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.moveTo(cx - R, cy);  
  ctx.lineTo(cx + R, cy);   
  ctx.stroke();

  if (angle === null) return;

  /* ================= ROTATING LINE ================= */
  ctx.strokeStyle = '#d00';
  ctx.beginPath();
  ctx.moveTo(cx, cy);
  ctx.lineTo(
    cx + R * Math.cos(-angle * Math.PI / 180),
    cy + R * Math.sin(-angle * Math.PI / 180)
  );
  ctx.stroke();

  /* ================= ARC ================= */
  ctx.strokeStyle = '#555';
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.arc(cx, cy, R * 0.4, 0, -angle * Math.PI / 180, true);
  ctx.stroke();

  const rounded = Math.round(angle);
  const [type, label] = getType(rounded);

  degEl.textContent  = rounded + '°';
  typeEl.textContent = label;
  hidden.value = rounded;
  answer.value = type;
}


    function update(e) {
      const rect = canvas.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const cx = canvas.clientWidth / 2;
      const cy = canvas.clientHeight / 2;

      let deg = Math.atan2(cy - y, x - cx) * 180 / Math.PI;
      if (deg < 0) deg += 360;
      if (deg > 180) deg = 180;

      angle = deg;
      draw();
    }

    canvas.addEventListener('mousedown', e => { dragging = true; update(e); });
    canvas.addEventListener('mousemove', e => { if (dragging) update(e); });
    document.addEventListener('mouseup', () => dragging = false);

    canvas.addEventListener('touchstart', e => { dragging = true; update(e.touches[0]); });
    canvas.addEventListener('touchmove', e => { if (dragging) update(e.touches[0]); });
    document.addEventListener('touchend', () => dragging = false);

    resize();
    window.addEventListener('resize', resize);

  });

})();
</script>
