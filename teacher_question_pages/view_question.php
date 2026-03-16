<?php
include '../db_config.php';
session_start();

if (!isset($_SESSION['teacher_id'])) {
    exit('Session expired');
}

$id = (int)($_GET['id'] ?? 0);

$q = mysqli_query($conn, "SELECT * FROM quiz_questions WHERE id = $id");

if (!$q || mysqli_num_rows($q) == 0) {
    exit('❌ Question not found.');
}

$data = mysqli_fetch_assoc($q);
$payload = json_decode($data['question_payload'], true);
?>

<style>

/* ========================= */
/* GLOBAL FIX */
/* ========================= */

*{
box-sizing:border-box;
}

.page-container{
padding:20px;
width:100%;
max-width:100%;
overflow:hidden;
}

.page-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
gap:10px;
flex-wrap:wrap;
}

.page-title{
font-size:20px;
font-weight:600;
word-break:break-word;
}

.card-box{
background:#fff;
padding:20px;
border-radius:10px;
border:1px solid #ddd;
width:100%;
max-width:100%;
overflow:hidden;
}

/* Question */
.question-box{
background:#f5f5f5;
padding:12px;
border-radius:6px;
word-break:break-word;
font-size:15px;
}

/* Info */
.info-box{
border:1px solid #eee;
padding:12px;
border-radius:6px;
background:#fafafa;
width:100%;
}

.label{
font-size:12px;
color:#777;
}

.value{
font-weight:500;
word-break:break-word;
}

/* JSON */
.json-box{
background:#000;
color:#00ff9c;
padding:12px;
border-radius:6px;
font-size:13px;
overflow:auto;
max-height:300px;
white-space:pre-wrap;
word-break:break-word;
}

/* Image */
.question-img{
max-width:100%;
height:auto;
border-radius:6px;
margin-top:10px;
}

/* Button */
.btn{
white-space:nowrap;
}


/* ========================= */
/* MOBILE FIX */
/* ========================= */

@media(max-width:768px){

.page-header{
flex-direction:column;
align-items:stretch;
}

.btn{
width:100%;
}

}


/* ========================= */
/* FORCE STACK INFO BOXES */
/* ========================= */

@media(max-width:575px){

.info-row{
display:block !important;
}

.info-row > div{
width:100% !important;
max-width:100% !important;
flex:none !important;
margin-bottom:10px;
}

.page-container{
padding:15px 10px;
}

.card-box{
padding:15px;
}

}


/* ========================= */
/* 360px FIX */
/* ========================= */

@media(max-width:360px){

.page-container{
padding:12px 8px;
}

.card-box{
padding:12px;
}

.page-title{
font-size:17px;
}

.question-box{
font-size:14px;
}

.json-box{
font-size:11px;
}

}


/* ========================= */
/* 300px FINAL FIX */
/* ========================= */

@media(max-width:300px){

.page-container{
padding:10px 6px;
}

.card-box{
padding:10px;
border-radius:8px;
}

.page-title{
font-size:15px;
}

.question-box{
font-size:13px;
padding:10px;
}

.info-box{
padding:10px;
}

.value{
font-size:13px;
}

.label{
font-size:11px;
}

.json-box{
font-size:10px;
padding:8px;
max-height:200px;
}

.btn{
font-size:13px;
padding:8px;
width:100%;
}

}

</style>

<div class="page-container">

  <!-- Header -->
  <div class="page-header">
    <div class="page-title">
      View Question #<?= $data['id'] ?>
    </div>

    <!-- UPDATED BACK BUTTON -->
    <button onclick="goBack()" class="btn btn-secondary">
      Back
    </button>
  </div>

  <!-- Card -->
  <div class="card-box">

    <!-- Question -->
    <div class="mb-3">
      <div class="label">Question</div>
      <div class="question-box mt-1">
        <?= nl2br(htmlspecialchars($data['question_text'])) ?>
      </div>
    </div>

    <!-- Info -->
    <div class="row g-2 info-row">

      <div class="col-md-4">
        <div class="info-box">
          <div class="label">Type</div>
          <div class="value"><?= htmlspecialchars($data['question_type']) ?></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box">
          <div class="label">Correct Answer</div>
          <div class="value text-success">
            <?= htmlspecialchars($data['correct_answer']) ?>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box">
          <div class="label">Unit</div>
          <div class="value"><?= htmlspecialchars($data['unit'] ?: '-') ?></div>
        </div>
      </div>

    </div>

    <!-- Image -->
    <?php if (!empty($data['question_image'])): ?>
    <div class="mt-3">
      <div class="label">Image</div>
      <img src="https://creativetheka.in/Student_dashboard/<?= htmlspecialchars($data['question_image']) ?>" 
           class="img-fluid question-img">
    </div>
    <?php endif; ?>

    <!-- Payload -->
    <div class="mt-3">
      <div class="label">Payload</div>
      <pre class="json-box mt-1">
<?= json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
      </pre>
    </div>

  </div>

</div>

<script>
function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        // fallback agar direct open kiya ho
        loadPage('teacher_question_pages/manage_questions.php');
    }
}
</script>