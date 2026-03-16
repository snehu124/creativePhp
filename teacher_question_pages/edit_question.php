<?php
session_start();
include '../db_config.php';

if (!isset($_SESSION['teacher_id'])) {
    exit('<div class="alert alert-danger">Session expired</div>');
}

/* keep teacher active */
$teacher_id = $_SESSION['teacher_id'];
$now = date('Y-m-d H:i:s');
mysqli_query($conn,"UPDATE teachers SET last_activity='$now' WHERE id='$teacher_id'");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows==0){
    exit('<div class="alert alert-danger">Question not found</div>');
}

$data=$result->fetch_assoc();

$payload=json_decode($data['question_payload'],true) ?? [];

$msg="";


/*
|--------------------------------------------------------------------------
| UPDATE QUESTION
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD']=="POST"){

$question_text=$_POST['question_text'] ?? '';
$correct_answer=$_POST['correct_answer'] ?? '';
$unit=$_POST['unit'] ?? '';

$image_path=$data['question_image'];


/* IMAGE UPLOAD */

if(!empty($_FILES['question_image']['name'])){

$uploadDir="../uploads/questions/";

if(!is_dir($uploadDir)){
mkdir($uploadDir,0777,true);
}

$fileName=time().'_'.$_FILES['question_image']['name'];

$targetFile=$uploadDir.$fileName;

if(move_uploaded_file($_FILES['question_image']['tmp_name'],$targetFile)){

$image_path="uploads/questions/".$fileName;

}

}


/* UPDATE QUERY */

$stmt=$conn->prepare("
UPDATE quiz_questions
SET question_text=?, correct_answer=?, unit=?, question_image=?
WHERE id=?
");

$stmt->bind_param(
"ssssi",
$question_text,
$correct_answer,
$unit,
$image_path,
$id
);

if($stmt->execute()){

$msg='<div class="alert alert-success">Question updated successfully</div>';

$data['question_text']=$question_text;
$data['correct_answer']=$correct_answer;
$data['unit']=$unit;
$data['question_image']=$image_path;

}
else{

$msg='<div class="alert alert-danger">Update failed</div>';

}

}

?>


<style>

/* ========================= */
/* BASE */
/* ========================= */

.page-container{
padding:15px;
width:100%;
max-width:100%;
}

/* REMOVE INNER CARD EFFECT */
.dashboard-card{
background:white;
padding:20px;
border-radius:12px;
box-shadow:none; /* remove double card shadow */
width:100%;
max-width:100%;
margin:0;
}

/* Title */
.card-title{
font-size:20px;
font-weight:600;
margin-bottom:20px;
word-break:break-word;
}

/* Inputs */
.form-control{
width:100%;
max-width:100%;
box-sizing:border-box;
}

/* Textarea */
textarea.form-control{
min-height:100px;
resize:vertical;
}

/* Image */
.question-img{
max-width:100%;
height:auto;
margin-top:10px;
border-radius:8px;
}

/* Buttons */
.btn{
margin-top:5px;
}


/* ========================= */
/* TABLET */
/* ========================= */

@media(max-width:768px){

.dashboard-card{
padding:18px;
}

.card-title{
font-size:18px;
}

}


/* ========================= */
/* MOBILE */
/* ========================= */

@media(max-width:575px){

.page-container{
padding:12px 8px;
}

/* stack columns */
.row.g-4 > div{
width:100%;
max-width:100%;
flex:0 0 100%;
}

/* inputs */
.form-control{
font-size:15px;
padding:10px;
}

/* buttons full width */
.btn{
width:100%;
}

.dashboard-card{
padding:16px;
}

}


/* ========================= */
/* SMALL MOBILE */
/* ========================= */

@media(max-width:360px){

.page-container{
padding:10px 6px;
}

.dashboard-card{
padding:14px;
}

.card-title{
font-size:17px;
}

.form-control{
font-size:14px;
padding:9px;
}

}


/* ========================= */
/* ULTRA SMALL */
/* ========================= */

@media(max-width:300px){

.page-container{
padding:8px 5px;
}

.dashboard-card{
padding:12px;
border-radius:8px;
}

.card-title{
font-size:15px;
line-height:1.3;
}

/* inputs */
.form-control{
font-size:13px;
padding:8px;
}

/* textarea */
textarea.form-control{
min-height:80px;
}

/* buttons */
.btn{
font-size:13px;
padding:8px;
width:100%;
}

/* image */
.question-img{
max-height:150px;
}

}

</style>



<div class="page-container">

<div class="dashboard-card">

<div class="card-title">

<i class="bi bi-pencil-square text-primary"></i>
Edit Question #<?= $id ?>

</div>


<?= $msg ?>


<form method="POST" enctype="multipart/form-data">

<div class="row g-4">


<div class="col-12">

<label class="form-label">Question Text</label>

<textarea name="question_text"
class="form-control"
rows="3"
required><?= htmlspecialchars($data['question_text']) ?></textarea>

</div>



<div class="col-md-6">

<label class="form-label">Question Type</label>

<input type="text"
class="form-control"
value="<?= htmlspecialchars($data['question_type']) ?>"
readonly>

</div>



<div class="col-md-6">

<label class="form-label">Correct Answer</label>

<input type="text"
name="correct_answer"
class="form-control"
required
value="<?= htmlspecialchars($data['correct_answer']) ?>">

</div>



<div class="col-md-6">

<label class="form-label">Unit</label>

<input type="text"
name="unit"
class="form-control"
value="<?= htmlspecialchars($data['unit']) ?>">

</div>



<div class="col-md-6">

<label class="form-label">Upload New Image</label>

<input type="file"
name="question_image"
class="form-control">

<?php if(!empty($data['question_image'])): ?>

<img src="<?= htmlspecialchars($data['question_image']) ?>"
class="question-img">

<?php endif; ?>

</div>



<div class="col-12">

<label class="form-label">Payload JSON</label>

<textarea class="form-control"
rows="6"
readonly><?= json_encode($payload,JSON_PRETTY_PRINT) ?></textarea>

</div>



<div class="col-12">

<button type="submit" class="btn btn-primary">

<i class="bi bi-check-circle"></i>
Update Question

</button>


<button type="button"
onclick="goBackPage()"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>
Back

</button>

</div>


</div>

</form>

</div>

</div>


<script>

function goBackPage(){

if(window.history.length > 1){

window.history.back();

}
else{

loadPage('teacher_question_pages/manage_questions.php');

}

}

</script>