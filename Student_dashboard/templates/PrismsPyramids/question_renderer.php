<?php
declare(strict_types=1);
$q = $q ?? [];
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$type = $q['question_type'] ?? '';
$inst_id = (int)($q['instruction_id'] ?? 0);
$id = (int)($q['id'] ?? 0);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$domain = $_SERVER['HTTP_HOST'] ?? '';
$base_path = '/Student_dashboard/';
$makeImg = fn($img) => $img ? rtrim($protocol.'://'.$domain.$base_path, '/') . '/' . ltrim($img, '/') : '';
$GLOBALS['__match_net_index'] = $GLOBALS['__match_net_index'] ?? 0;
?>
<style>
.solid-index{
    position:absolute;
    left:12px;
    top:12px;
    font-weight:700;
    font-size:18px;
}
.match-solid{position:relative}

/* shared */
.shape-container{display:flex;flex-direction:row;align-items:center;gap:12px}
.shape-img-wrapper{width:45%;display:flex;justify-content:center}
.answer-box{width:55%}
/* table */
.table-row{display:flex;align-items:center;margin-bottom:25px;border:1px solid #ddd;padding:10px;border-radius:6px}
.table-row img{width:120px;height:auto;margin-right:20px}
.table-input-box{flex:1}
.table-field{display:flex;align-items:center;margin-bottom:8px}
.table-field span{width:80px;font-weight:600}
.table-field input{width:80px;margin-left:10px}
/* matching */
.match-board{position:relative}
.match-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:25px;padding:12px;border:1px solid #ddd;border-radius:6px;position:relative}
.match-solid,.match-net{width:48%;text-align:center;cursor:crosshair}
.match-solid img,.match-net img{max-width:150px;height:auto}
.net-label{font-weight:600;display:block;margin-bottom:5px;font-size:18px}

/* ---- NEW: Clear Lines button (left side) ---- */
.clear-lines-btn{
  position:absolute; right:8px;
  left:auto; top:50%; transform:translateY(-50%);
  background:#e74c3c; color:#fff; border:none; border-radius:4px;
  padding:4px 8px; font-size:12px; cursor:pointer; z-index:10;
}
.clear-lines-btn:hover{background:#c0392b}

/* global SVG canvas for lines */
#matchCanvasGlobal{
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:100%;
  pointer-events:none;
  z-index:9999;
}

/* drag preview */
.line-preview{stroke:#2f80ed;stroke-width:3;fill:none;stroke-linecap:round;stroke-dasharray:6 6}
.line-final{stroke:#2f80ed;stroke-width:3;fill:none;stroke-linecap:round}
.drag-active .match-solid, .drag-active .match-net{cursor:crosshair}
</style>
<?php if ($type === 'question_renderer'): ?>
  <div class="col-md-4 mb-3">
    <div class="shape-container">
      <div class="shape-img-wrapper">
        <img src="<?= $h($makeImg($q['question_image'] ?? '')) ?>" alt="Shape" class="shape-img">
      </div>
      <div class="answer-box">
        <input type="text" class="form-control"
               name="answer[<?= $id ?>]"
               placeholder="Prism or Pyramid">
        <!--<input type="hidden"-->
        <!--       name="answer[<?= $id ?>]"-->
        <!--       value="<?= $h($q['correct_answer'] ?? '') ?>">-->
      </div>
    </div>
  </div>
<?php elseif ($type === 'complete_table'): ?>
  <div class="col-md-12">
    <div class="table-row">
      <?php if (!empty($q['question_image'])): ?>
        <img src="<?= $h($makeImg($q['question_image'])) ?>" alt="Solid">
      <?php endif; ?>
      <div class="table-input-box">
        <?php
        $payload = json_decode($q['question_payload'] ?? '{}', true) ?: [];
        foreach (['Faces','Edges','Vertices'] as $field):
          $key = strtolower($field);
          $correct = $payload[$key] ?? '';
        ?>
          <div class="table-field">
            <span><?= $field ?> =</span>
            <input type="text" class="form-control"
                   name="answer[<?= $id ?>][<?= $key ?>]" style="width:80px;">
            <!--<input type="hidden"-->
            <!--       name="answer[<?= $id ?>][<?= $key ?>]"-->
            <!--       value="<?= $h($correct) ?>">-->
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php elseif ($type === 'match_nets'): ?>
  <?php
    $payload = json_decode($q['question_payload'] ?? '{}', true) ?: [];
    $netImg = $makeImg($payload['net_image'] ?? '');
    $label = $payload['label'] ?? '';
    // stable IDs used by JS for hit-testing and saving pairs
    $solidId = "solid_{$inst_id}_{$id}";
    $netId = "net_{$inst_id}_{$id}";
    // unique ID for this row’s clear button
    $clearBtnId = "clearBtn_{$inst_id}_{$id}";
  ?>
  <!-- a single global canvas for the whole page (created once) -->
  <script>
    (function ensureGlobalCanvas(){
      if (!document.getElementById('matchCanvasGlobal')) {
        const svg = document.createElementNS('http://www.w3.org/2000/svg','svg');
        svg.setAttribute('id','matchCanvasGlobal');
        document.body.appendChild(svg);
      }
    })();
  </script>
  <div class="col-md-12 match-board">
    <div class="match-row" data-row-id="row_<?= $inst_id ?>_<?= $id ?>">
      <!-- Clear Lines button (left side) -->
      <button type="button" class="clear-lines-btn" style="top:10%" id="<?= $h($clearBtnId) ?>">Clear</button>

   <div class="match-solid"
     id="<?= $h($solidId) ?>"
     data-label="<?= $h($q['correct_answer']) ?>">

    <span class="solid-index">
        <?= ++$GLOBALS['__match_net_index'] ?>)
    </span>

    <img src="<?= $h($makeImg($q['question_image'] ?? '')) ?>" alt="Solid">
</div>

     <div class="match-net"
     id="<?= $h($netId) ?>"
     data-label="<?= $h($payload['label'] ?? '') ?>">

    <?php if ($netImg): ?>
        <img src="<?= $h($netImg) ?>" alt="Net">
    <?php endif; ?>
</div>

    </div>
  </div>
  <!-- matches collected for form submit -->
  <div id="matchHiddenContainer_<?= $id ?>" style="display:none;"></div>

  <script>
  (function(){
    const svg = document.getElementById('matchCanvasGlobal');
    const svgNS = 'http://www.w3.org/2000/svg';
    // Keep canvas sized to full page so lines can span any rows
    function sizeCanvas(){
      const w = Math.max(document.documentElement.scrollWidth, document.documentElement.clientWidth);
      const h = Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight);
      svg.setAttribute('width', w);
      svg.setAttribute('height', h);
      svg.style.width = w+'px';
      svg.style.height = h+'px';
      svg.style.left = '0px';
      svg.style.top = '0px';
    }
    sizeCanvas();
    // Utility: center of an element in page coords
    function center(el){
      const r = el.getBoundingClientRect();
      return { x: r.left + r.width/2 + window.scrollX, y: r.top + r.height/2 + window.scrollY };
    }
    // Draw or update a straight line
    function setLine(line, a, b, preview=false){
      line.setAttribute('x1', a.x); line.setAttribute('y1', a.y);
      line.setAttribute('x2', b.x); line.setAttribute('y2', b.y);
      line.setAttribute('class', preview ? 'line-preview' : 'line-final');
    }

    // State
    const solids = Array.from(document.querySelectorAll('.match-solid'));
    const nets = Array.from(document.querySelectorAll('.match-net'));
    const connections = []; // {fromEl,toEl,lineEl,fromId,toId,rowId}
    let drag = null; // {fromEl, lineEl}
    // Hidden values for submit: match_links[]=solidId->netId
    const hiddenBox = document.getElementById('matchHiddenContainer');
function addHidden(toLabel){
  const box = document.getElementById('matchHiddenContainer_<?= $id ?>');
  box.innerHTML = '';

  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'answer[<?= $id ?>]';

  // ✅ ONLY net label (a/b/c/d)
  input.value = toLabel;

  box.appendChild(input);
}


    function removeHidden(fromId,toId){
      const val = `${fromId}->${toId}`;
      const node = Array.from(hiddenBox.querySelectorAll("input[name='match_links[]']")).find(i=>i.value===val);
      if (node) node.remove();
    }
    // Begin drag from any left item
    function onSolidDown(ev){
      const fromEl = ev.currentTarget;
      const line = document.createElementNS(svgNS,'line');
      svg.appendChild(line);
      setLine(line, center(fromEl), {x: ev.pageX, y: ev.pageY}, true);
      drag = { fromEl, lineEl: line };
      document.body.classList.add('drag-active');
    }
    // Drag preview
    function onMove(ev){
      if(!drag) return;
      setLine(drag.lineEl, center(drag.fromEl), {x: ev.pageX, y: ev.pageY}, true);
    }
    // Finish on a right item; otherwise cancel
    function onUp(ev){
      if(!drag) return;
      const target = document.elementFromPoint(ev.clientX, ev.clientY);
      const toEl = target && (target.closest && target.closest('.match-net'));
      const rowEl = drag.fromEl.closest('.match-row');
      if (toEl && rowEl){
        // Commit line
        setLine(drag.lineEl, center(drag.fromEl), center(toEl), false);
        const fromId = drag.fromEl.id || ('solid_'+Math.random().toString(36).slice(2));
        const toId = toEl.id || ('net_' +Math.random().toString(36).slice(2));
        if(!drag.fromEl.id) drag.fromEl.id = fromId;
        if(!toEl.id) toEl.id = toId;
        const rowId = rowEl.dataset.rowId;
        connections.push({ fromEl:drag.fromEl, toEl, lineEl:drag.lineEl, fromId, toId, rowId });

       const fromLabel = drag.fromEl.dataset.label;
       const toLabel   = toEl.dataset.label;
       addHidden(fromLabel, toLabel);


        // right-click to delete a line
        drag.lineEl.addEventListener('contextmenu', (e)=>{
          e.preventDefault();
          const idx = connections.findIndex(c=>c.lineEl===e.target);
          if(idx>-1){
            const c = connections[idx];
            c.lineEl.remove();
            removeHidden(c.fromId,c.toId);
            connections.splice(idx,1);
          }
        }, { once:false });
      } else {
        // Cancel
        drag.lineEl.remove();
      }
      drag = null;
      document.body.classList.remove('drag-active');
    }
    solids.forEach(s => s.addEventListener('mousedown', onSolidDown));
    window.addEventListener('mousemove', onMove);
    window.addEventListener('mouseup', onUp);


    // ---- NEW: Clear button per diagram ----
    document.querySelectorAll('.clear-lines-btn').forEach(btn => {
      btn.addEventListener('click', function(){
        const rowId = this.closest('.match-row').dataset.rowId;
        const toRemove = connections.filter(c => c.rowId === rowId);
        toRemove.forEach(c => {
          c.lineEl.remove();
          removeHidden(c.fromId, c.toId);
        });
        // keep only connections from other rows
        connections.splice(0, connections.length, ...connections.filter(c => c.rowId !== rowId));
      });
    });

    // Redraw all lines if layout changes
    function redrawAll(){
      sizeCanvas();
      connections.forEach(c=>{
        setLine(c.lineEl, center(c.fromEl), center(c.toEl), false);
      });
    }
    window.addEventListener('scroll', redrawAll, {passive:true});
    window.addEventListener('resize', redrawAll);
    window.addEventListener('load', redrawAll);
  })();
  </script>
<?php endif; ?>