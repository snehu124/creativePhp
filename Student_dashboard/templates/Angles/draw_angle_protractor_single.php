<?php
declare(strict_types=1);

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$q = $q ?? [];

$payload = json_decode($q['question_payload'] ?? '{}', true);
$targetAngle = (int)($payload['angle'] ?? 0);
$qid = (int)$q['id'];

$char = $char ?? '';
?>

<style>
.angle-box {
  width: 100%;
  margin: 20px 0;
  font-family: 'Segoe UI', sans-serif;
}

.angle-head {
  font-size: 18px;
  font-weight: 600;
}

.angle-sub {
  font-size: 14px;
  color: #555;
  margin: 6px 0 14px;
}

/* canvas */
.angle-canvas-wrap {
  width: 100%;
  display: flex;
  justify-content: center;
}

.angle-canvas {
  width: 100%;
  max-width: 900px;
  height: 280px;
  border: 1px solid #ccc;
  border-radius: 12px;
  background: #fff;
  touch-action: none;
}

/* footer */
.angle-footer {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  margin-top: 14px;
}

.angle-deg {
  font-size: 18px;
  font-weight: 600;
}

.angle-name {
  font-size: 14px;
  color: #666;
}

.angle-footer select {
  padding: 8px 14px;
  font-size: 14px;
  min-width: 180px;
}
</style>

<div class="angle-box">

  <div class="angle-head">
    (<?= $h($char) ?>) Draw and classify the angle.
    <div style="font-size:13px;color:#666;margin-top:4px">
      Draw the angle correctly.  
      Angle type will be selected automatically.
    </div>
  </div>

  <div class="angle-sub">
    Target angle: <b><?= $targetAngle ?>°</b>
  </div>

  <div class="angle-canvas-wrap">
    <canvas
      class="angle-canvas" data-type="single"
      data-qid="<?= $qid ?>">
    </canvas>
  </div>

  <!-- IMPORTANT: start EMPTY (not attempted) -->
  <input type="hidden"
         name="angle_value[<?= $qid ?>]"
         class="angle-hidden"
         value="">

  <div class="angle-footer">
    <div class="angle-deg">—</div>
    <div class="angle-name">Not attempted</div>

    <select name="answer[<?= $qid ?>]" class="angle-type">
      <option value="">Angle type (auto)</option>
      <option value="acute">Acute</option>
      <option value="right">Right</option>
      <option value="obtuse">Obtuse</option>
      <option value="straight">Straight</option>
    </select>
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

   document.querySelectorAll('.angle-canvas[data-type="single"]').forEach(canvas => {

    const box = canvas.closest('.angle-box');
    const degEl = box.querySelector('.angle-deg');
    const nameEl = box.querySelector('.angle-name');
    const hidden = box.querySelector('.angle-hidden');
    const select = box.querySelector('.angle-type');

    const ctx = canvas.getContext('2d');

    let angle = null;           
    let hasDrawn = false;
    let dragging = false;

    function resize() {
      const dpr = window.devicePixelRatio || 1;
      const w = canvas.clientWidth;
      const h = canvas.clientHeight;

      canvas.width = w * dpr;
      canvas.height = h * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      draw();
    }

    function draw() {
      const w = canvas.clientWidth;
      const h = canvas.clientHeight;
      const cx = w / 2;
      const cy = h / 2;
      const R  = Math.min(w, h) * 0.35;

      ctx.clearRect(0, 0, w, h);

      // base ray
      ctx.strokeStyle = '#000';
      ctx.lineWidth = 2;
      ctx.beginPath();
      ctx.moveTo(cx - R, cy);  
      ctx.lineTo(cx + R, cy);   
      ctx.stroke();

      if (angle === null) return;

      // rotating ray
      ctx.strokeStyle = '#d00';
      ctx.beginPath();
      ctx.moveTo(cx, cy);
      ctx.lineTo(
        cx + R * Math.cos(-angle * Math.PI / 180),
        cy + R * Math.sin(-angle * Math.PI / 180)
      );
      ctx.stroke();

      // arc
      ctx.strokeStyle = '#555';
      ctx.beginPath();
      ctx.arc(cx, cy, R * 0.35, 0, -angle * Math.PI / 180, true);
      ctx.stroke();

      const rounded = Math.round(angle);
      const [type, label] = getType(rounded);

      degEl.textContent = rounded + '°';
      nameEl.textContent = label;
      hidden.value = rounded;
      select.value = type;
    }

    function update(e) {
      hasDrawn = true;

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
