<?php
// ---------- SEQUENCE HANDLING (persists across includes in this request) ----------
if (!isset($GLOBALS['LD_SEQ'])) {
  $GLOBALS['LD_SEQ'] = 0; // start at a)
}

// ---------- INPUT DATA ----------
$dataRaw = isset($q['question_payload']) ? (string)$q['question_payload'] : '{}';
$data    = json_decode($dataRaw, true);
if (!is_array($data)) { $data = []; }

// Optional: reset sequence if this record says so (use in the FIRST row of the page)
if (!empty($data['reset_seq'])) {
  $GLOBALS['LD_SEQ'] = 0;
}

// Build items: support single or multiple questions in payload
$items = [];
if (!empty($data['questions']) && is_array($data['questions'])) {
  foreach ($data['questions'] as $it) {
    $d = isset($it['divisor'])  ? (string)$it['divisor']  : '';
    $n = isset($it['dividend']) ? (string)$it['dividend'] : '';
    if ($d !== '' && $n !== '') { $items[] = ['divisor'=>$d,'dividend'=>$n]; }
  }
} else {
  $d = isset($data['divisor'])  ? (string)$data['divisor']  : '';
  $n = isset($data['dividend']) ? (string)$data['dividend'] : '';
  if ($d !== '' && $n !== '') { $items[] = ['divisor'=>$d,'dividend'=>$n]; }
}

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>

<style>
/* clean, compact row */
.ld-row{display:flex;align-items:center;gap:10px;margin:10px 0;color:#222;
  font:16px/1.5 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
.ld-part{width:22px;flex:0 0 22px;font-weight:600;text-transform:lowercase}
.long-division{display:inline-flex;align-items:flex-end;font-size:26px;line-height:1;
  font-family:monospace,sans-serif}
.divisor{padding-right:6px}
.bracket{border-top:2px solid #000;border-left:2px solid #000;padding:3px 8px 0 8px;
  min-width:66px;display:inline-block}
.dividend{display:inline-block}
.ld-eq{font-size:18px;position:relative;top:-1px}
.ld-answer{display:flex;align-items:flex-end;gap:8px;margin-left:6px}
.ld-answer input{width:120px;border:none;border-bottom:2px solid #000;background:transparent;
  font:18px/1.2 inherit;padding:2px 4px;outline:none}
</style>

<?php
// If no valid item, nothing to render
if (!$items) { return; }

// If this payload contains multiple items, we advance the global counter once at the end.
// Each item’s label = current global + offset within this payload.
$base = $GLOBALS['LD_SEQ'];

foreach ($items as $i => $it):
  $label = chr(97 + $base + $i); // a, b, c...
?>
  <div class="ld-row">
    <div class="ld-part"><?= $h($label) ?>)</div>
    <div class="long-division">
      <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
        <mtable>
          <mtr>
            <mtd class="divisor"><mn><?= $h($it['divisor']) ?></mn></mtd>
            <mtd class="bracket dividend"><mn><?= $h($it['dividend']) ?></mn></mtd>
          </mtr>
        </mtable>
      </math>
    </div>
    <div class="ld-answer">
      <span class="ld-eq">=</span>
      <input type="text" name="ans[<?= $h($label) ?>]" placeholder="answer">
    </div>
  </div>
<?php endforeach;

// advance global sequence by how many we just printed
$GLOBALS['LD_SEQ'] += count($items);
?>
