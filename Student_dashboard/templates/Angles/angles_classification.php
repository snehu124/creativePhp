<?php
declare(strict_types=1);

/**
 * Angles Classification Template
 * FINAL – Dropdown enabled for Triangle Type
 */

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$q = isset($q) && is_array($q) ? $q : [];
$question_id   = (int)($q['id'] ?? 0);
$questionImage = trim((string)($q['question_image'] ?? ''));

// Decode correct answer (for labels only)
$correct = json_decode($q['correct_answer'] ?? '{}', true);
if (!is_array($correct)) $correct = [];

$labels = array_keys($correct['angles'] ?? []);
if (count($labels) !== 3) $labels = ['A','B','C'];

// URL helper
$makeUrl = function (string $path): string {
    if ($path === '') return '';
    if (preg_match('~^https?://~i', $path)) return $path;
    $root = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
    return ($root ?: '/') . '/' . ltrim($path, '/');
};

// Part label a,b,c,d,e
$part = $char ?? 'a';

?>

<style>
.tri-item{display:flex;gap:18px;margin:18px 0}
.part-badge{font-weight:700}
.tri-img{width:220px;height:160px;display:flex;align-items:center;justify-content:center}
.tri-img img{max-width:100%;max-height:100%}
.angle-row{display:flex;gap:10px;margin:10px 0}
.input-line{border:none;border-bottom:2px solid #2b6cb0;width:200px;background:transparent}
select.input-line{padding:4px}
.type-row{margin-top:12px}
</style>

<div class="tri-item angle-question">

  <div class="part-badge"><?= $h($part) ?>)</div>

  <div class="tri-img">
    <?php if ($questionImage): ?>
      <img src="<?= $h($makeUrl($questionImage)) ?>">
    <?php endif; ?>
  </div>

  <div>

    <!-- Angle inputs -->
    <?php foreach ($labels as $L): ?>
      <div class="angle-row">
        <strong>∠<?= $h($L) ?> =</strong>
        <input type="number"
               step="1"
               class="input-line angle-input"
               data-angle="<?= $h($L) ?>">
      </div>
    <?php endforeach; ?>

    <!-- Type dropdown -->
        <div class="type-row">
          <b><span class="type-label">Type of Triangle :</span></b>
          <select class="type-input">
            <option value="">-- Select Type --</option>
            <option value="EQUILATERAL">Equilateral</option>
            <option value="ISOSCELES">Isosceles</option>
            <option value="SCALENE">Scalene</option>
            <option value="RIGHT ANGLED">Right Angled</option>
          </select>
        </div>

    <!-- Final answer (REQUIRED by submit_quiz.php) -->
    <input type="hidden"
           name="answer[<?= $question_id ?>]"
           class="final-answer">

  </div>
</div>

<script>
document.querySelectorAll('.angle-question').forEach(box => {

  const hidden = box.querySelector('.final-answer');

  function collect() {
    let angles = {};

    box.querySelectorAll('.angle-input').forEach(i => {
      if (i.value !== '') {
        angles[i.dataset.angle] = Number(i.value);
      }
    });

    let typeSelect = box.querySelector('.type-input');
    let type = typeSelect ? typeSelect.value : '';

    if (Object.keys(angles).length || type) {
      hidden.value = JSON.stringify({ angles, type });
    } else {
      hidden.value = '';
    }
  }

  box.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input', collect);
    el.addEventListener('change', collect);
  });

});
</script>

