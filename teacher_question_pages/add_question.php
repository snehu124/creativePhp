<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db_config.php';

/* ---------------------------------------
   SECURITY CHECK
----------------------------------------*/
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../teacher_login.php");
    exit();
}

/* ---------------------------------------
   Keep teacher active
----------------------------------------*/
$teacher_id = $_SESSION['teacher_id'];
$now = date('Y-m-d H:i:s');
mysqli_query($conn, "UPDATE teachers SET last_activity='$now' WHERE id='$teacher_id'");

/* ---------------------------------------
   FETCH GRADES
----------------------------------------*/
$grades = [];

$res = mysqli_query($conn,"
SELECT DISTINCT grade
FROM subjects
WHERE grade IS NOT NULL AND grade!=''
ORDER BY CAST(grade AS UNSIGNED)
");

while($row=mysqli_fetch_assoc($res)){
    $grades[]=$row['grade'];
}

/* ---------------------------------------
   FETCH QUESTION TYPES
----------------------------------------*/
$question_types=[];

$res=mysqli_query($conn,"
SHOW COLUMNS FROM quiz_questions LIKE 'question_type'
");

$row=mysqli_fetch_assoc($res);

if(preg_match("/^enum\('(.*)'\)$/",$row['Type'],$matches)){
    $question_types=explode("','",$matches[1]);
}

/* ---------------------------------------
   HANDLE FORM SUBMIT
----------------------------------------*/
$msg="";

if($_SERVER['REQUEST_METHOD']=="POST"){

$instruction_id=(int)($_POST['instruction_id']??0);
$question_text=trim($_POST['question_text']??"");
$question_type=trim($_POST['question_type']??"");
$correct_answer=trim($_POST['correct_answer']??"");
$unit=trim($_POST['unit']??"");

if(!$instruction_id){
$msg="<div class='alert alert-danger'>Select Instruction</div>";
goto end;
}

if(!$question_type){
$msg="<div class='alert alert-danger'>Select Question Type</div>";
goto end;
}

/* IMAGE UPLOAD */

$question_image="";

if(!empty($_FILES['question_image']['name'])){

$dir="../uploads/questions/";

if(!is_dir($dir)){
mkdir($dir,0777,true);
}


$ext=strtolower(pathinfo($_FILES['question_image']['name'],PATHINFO_EXTENSION));

$allowed=['jpg','jpeg','png','webp'];

if(!in_array($ext,$allowed)){
$msg="<div class='alert alert-danger'>Invalid image type</div>";
goto end;
}

$path=$dir.time()."_".basename($_FILES['question_image']['name']);

if(move_uploaded_file($_FILES['question_image']['tmp_name'],$path)){
$question_image=$path;
}else{
$msg="<div class='alert alert-danger'>Image upload failed</div>";
goto end;
}

}

/* PAYLOAD */

$extra = $_POST['extra'] ?? [];
if(!is_array($extra)){
$extra=[];
}

$payload=[];

if($question_type=="BODMAS"){

$numbers=[];

foreach($extra as $k=>$v){

if(preg_match('/^num(\d+)$/',$k,$m)){
$numbers[(int)$m[1]]=trim($v);
}

}

ksort($numbers);

foreach($numbers as $i=>$v){
if($v!==""){
$payload["num$i"]=$v;
}
}

$payload['operator']=$extra['operator']??'+';

if(count($payload)<3){
$msg="<div class='alert alert-danger'>BODMAS needs 2 numbers</div>";
goto end;
}

}else{

$payload=$extra;

}

$payload_json=json_encode($payload,JSON_UNESCAPED_UNICODE);
/* INSERT */

$stmt=$conn->prepare("
INSERT INTO quiz_questions
(instruction_id,question_text,question_type,correct_answer,question_payload,question_image,unit)
VALUES(?,?,?,?,?,?,?)
");

if(!$stmt){
$msg="<div class='alert alert-danger'>DB Error: ".$conn->error."</div>";
goto end;
}

$stmt->bind_param(
"issssss",
$instruction_id,
$question_text,
$question_type,
$correct_answer,
$payload_json,
$question_image,
$unit
);

if($stmt->execute()){

echo "<script>
alert('Question Saved');
window.location='teacher_dashboard.php?page=teacher_question_pages/manage_questions.php';
</script>";
exit();

}else{

$msg="<div class='alert alert-danger'>Insert failed: ".$stmt->error."</div>";

}
$stmt->close();
}
end:
?>

<style>

/* ========================= */
/* DESKTOP DEFAULT */
/* ========================= */

.page-container{
padding:20px;
}

.page-header{
margin-bottom:20px;
}

.page-title{
font-size:22px;
font-weight:600;
}

.card{
border-radius:14px;
}

/* textarea proper height */
textarea.form-control{
min-height:110px;
resize:vertical;
}


/* ========================= */
/* TABLET */
/* ========================= */

@media(max-width:992px){

.page-container{
padding:18px;
}

}


/* ========================= */
/* MOBILE */
/* ========================= */

@media(max-width:575px){

.page-container{
padding:14px 10px;
}

.page-title{
font-size:19px;
}


/* card padding reduce */
.card{
padding:16px !important;
border-radius:12px;
}


/* stack columns */
.row.g-3 > div{
width:100%;
max-width:100%;
flex:0 0 100%;
}


/* inputs */
.form-control,
.form-select{
font-size:15px;
padding:10px 12px;
}


/* textarea */
textarea.form-control{
min-height:100px;
padding:10px;
}


/* buttons */
.btn{
width:100%;
margin-bottom:8px;
padding:10px;
font-size:15px;
}

}


/* ========================= */
/* SMALL MOBILE */
/* ========================= */

@media(max-width:360px){

.page-container{
padding:12px 8px;
}

.page-title{
font-size:17px;
}

.card{
padding:14px !important;
}

.form-control,
.form-select{
font-size:14px;
padding:9px 10px;
}

textarea.form-control{
min-height:90px;
}

.btn{
font-size:14px;
padding:9px;
}

}


/* ========================= */
/* ULTRA SMALL 300px */
/* ========================= */

@media(max-width:300px){

.page-container{
padding:10px 6px;
}

.page-title{
font-size:16px;
line-height:1.3;
}

.card{
padding:12px !important;
border-radius:10px;
}


/* tighter spacing */
.row.g-3{
gap:8px;
}


/* inputs */
.form-control,
.form-select{
font-size:13px;
padding:8px 9px;
border-radius:6px;
}


/* textarea */
textarea.form-control{
min-height:80px;
padding:8px;
}


/* buttons */
.btn{
font-size:13px;
padding:8px;
border-radius:6px;
}


/* label */
.form-label{
font-size:13px;
margin-bottom:4px;
}

}

</style>


<div class="page-container">

<div class="page-header">
<div class="page-title">
<i class="bi bi-plus-circle text-success"></i>
Add New Question
</div>
</div>

<?= $msg ?>

<div class="card shadow-sm p-4">

<form id="addQuestionForm" method="POST" enctype="multipart/form-data">

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Grade</label>
<select name="grade" id="grade" class="form-select">
<option value="">Select Grade</option>
<?php foreach($grades as $g): ?>
<option value="<?= $g ?>">Grade <?= $g ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-md-6">
<label class="form-label">Subject</label>
<select name="subject_id" id="subject_id" class="form-select">
<option value="">Select Subject</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Chapter</label>
<select name="chapter_id" id="chapter_id" class="form-select">
<option value="">Select Chapter</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Topic</label>
<select name="topic_id" id="topic_id" class="form-select">
<option value="">Select Topic</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Instruction</label>
<select name="instruction_id" id="instruction_id" class="form-select">
<option value="">Select Instruction</option>
</select>
</div>

<div class="col-md-12">
<label class="form-label">Question Text</label>
<textarea name="question_text" class="form-control"></textarea>
</div>

<div class="col-md-6">
<label class="form-label">Question Type</label>
<select name="question_type" id="qtype" class="form-select">
<option value="">Select Type</option>
<?php foreach($question_types as $t): ?>
<option value="<?= $t ?>"><?= $t ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Correct Answer</label>
<input type="text" name="correct_answer" class="form-control" required>
</div>

<div id="dynamic-fields" class="col-12 p-3 border bg-light rounded">
<em>Select question type to load fields</em>
</div>

<div class="col-md-6">
<label class="form-label">Image</label>
<input type="file" name="question_image" class="form-control">
</div>

<div class="col-md-6">
<label class="form-label">Unit</label>
<input type="text" name="unit" class="form-control">
</div>

<div class="col-12">
<button type="submit" class="btn btn-success">
<i class="bi bi-check-circle"></i>
Save Question
</button>

<a href="./teacher_dashboard.php?page=teacher_question_pages/manage_questions.php"
class="btn btn-secondary">
Back
</a>
</div>

</div>
</form>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#grade').change(function(){

const grade=$(this).val();

$('#subject_id').html('<option>Loading...</option>');

$.get('teacher_question_pages/fetch_subjects.php',{grade:grade},function(data){

$('#subject_id').html(data);
$('#chapter_id').html('<option>Select Chapter</option>');
$('#topic_id').html('<option>Select Topic</option>');
$('#instruction_id').html('<option>Select Instruction</option>');

});

});


$('#subject_id').change(function(){

const id=$(this).val();

$('#chapter_id').html('<option>Loading...</option>');

$.get('teacher_question_pages/fetch_chapters.php',{subject_id:id},function(data){

$('#chapter_id').html(data);
$('#topic_id').html('<option>Select Topic</option>');
$('#instruction_id').html('<option>Select Instruction</option>');

});

});


$('#chapter_id').change(function(){

const id=$(this).val();

$('#topic_id').html('<option>Loading...</option>');

$.get('teacher_question_pages/fetch_topics.php',{chapter_id:id},function(data){

$('#topic_id').html(data);
$('#instruction_id').html('<option>Select Instruction</option>');

});

});


$('#topic_id').change(function(){

const id=$(this).val();

$('#instruction_id').html('<option>Loading...</option>');

$.get('teacher_question_pages/fetch_instructions.php',{topic_id:id},function(data){

$('#instruction_id').html(data);

});

});

$('#qtype').change(function(){

const type=$(this).val();

$('#dynamic-fields').html('<em>Loading fields...</em>');

$.get('teacher_question_pages/fetch_payload_fields.php',{type:type},function(data){

$('#dynamic-fields').html(data);

});

});


$("#addQuestionForm").submit(function(e){

e.preventDefault();

let formData = new FormData(this);

$.ajax({

url:"teacher_question_pages/add_question.php",
type:"POST",
data:formData,
processData:false,
contentType:false,

success:function(res){

$("#content-area").html(res);

},

error:function(){
alert("Failed to save question");
}

});

});
</script>