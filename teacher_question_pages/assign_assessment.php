<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db_config.php';


/*
|--------------------------------------------------------------------------
| AUTH CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['teacher_id']))
{
    header('Location: ../teacher_login.php');
    exit();
}


$teacher_id = (int)$_SESSION['teacher_id'];

$msg = "";


/*
|--------------------------------------------------------------------------
| FETCH GRADES
|--------------------------------------------------------------------------
*/

$grades = [];

$res = mysqli_query(
    $conn,
    "
    SELECT DISTINCT grade
    FROM subjects
    WHERE grade IS NOT NULL
    AND grade != ''
    ORDER BY CAST(grade AS UNSIGNED)
    "
);

while ($r = mysqli_fetch_assoc($res))
{
    $grades[] = $r['grade'];
}



/*
|--------------------------------------------------------------------------
| FETCH STUDENTS
|--------------------------------------------------------------------------
*/

$students = [];

$stmt = $conn->prepare(
    "
    SELECT
        id,
        TRIM(
            CONCAT(
                COALESCE(first_name,''),
                IF(first_name IS NOT NULL AND last_name IS NOT NULL,' ',''),
                COALESCE(last_name,'')
            )
        ) AS name
    FROM students
    ORDER BY first_name,last_name,id
    "
);

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc())
{
    $name = !empty($row['name'])
        ? $row['name']
        : "Student #" . $row['id'];

    $students[] =
    [
        'id'   => $row['id'],
        'name' => $name
    ];
}

$stmt->close();



/*
|--------------------------------------------------------------------------
| FORM SUBMIT
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $due_date =
        !empty($_POST['due_date'])
        ? $_POST['due_date']
        : null;

    $time_limit =
        max(
            5,
            (int)($_POST['time_limit'] ?? 30)
        );

    $allow_retake =
        isset($_POST['allow_retake'])
        ? 1
        : 0;

    $topic_id =
        !empty($_POST['topic_id'])
        ? (int)$_POST['topic_id']
        : null;

    $selected_questions =
        $_POST['questions'] ?? [];

    $student_ids =
        $_POST['student_ids'] ?? [];


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (empty($title))
    {
        $msg =
        "
        <div class='alert alert-danger'>
            Assessment title required
        </div>
        ";

        goto end_submit;
    }



    /*
    |--------------------------------------------------------------------------
    | START TRANSACTION
    |--------------------------------------------------------------------------
    */

    $conn->begin_transaction();


    try
    {

        /*
        |--------------------------------------------------------------------------
        | INSERT ASSESSMENT
        |--------------------------------------------------------------------------
        */

        $stmt = $conn->prepare(
            "
            INSERT INTO assessments
            (
                teacher_id,
                title,
                description,
                topic_id,
                due_date,
                time_limit_minutes,
                allow_retake
            )
            VALUES (?,?,?,?,?,?,?)
            "
        );

        $stmt->bind_param(
            "issisii",
            $teacher_id,
            $title,
            $description,
            $topic_id,
            $due_date,
            $time_limit,
            $allow_retake
        );

        $stmt->execute();

        $assessment_id = $conn->insert_id;

        $stmt->close();

        /*
        |--------------------------------------------------------------------------
        | INSERT QUESTIONS
        |--------------------------------------------------------------------------
        */

        if ($topic_id && empty($selected_questions))
        {

            $qsel = $conn->prepare(
                "
                SELECT id
                FROM quiz_questions
                WHERE instruction_id IN
                (
                    SELECT id
                    FROM instructions
                    WHERE topic_id = ?
                )
                "
            );

            $qsel->bind_param("i", $topic_id);

            $qsel->execute();

            $qres = $qsel->get_result();


            $qinsert = $conn->prepare(
                "
                INSERT INTO assessment_questions
                (
                    assessment_id,
                    question_id,
                    question_order
                )
                VALUES (?,?,?)
                "
            );

            $order = 1;

            while ($row = $qres->fetch_assoc())
            {
                $qid = (int)$row['id'];

                $qinsert->bind_param(
                    "iii",
                    $assessment_id,
                    $qid,
                    $order
                );

                $qinsert->execute();

                $order++;
            }

        }


        elseif (!empty($selected_questions))
        {

            $qinsert = $conn->prepare(
                "
                INSERT INTO assessment_questions
                (
                    assessment_id,
                    question_id,
                    question_order
                )
                VALUES (?,?,?)
                "
            );

            foreach ($selected_questions as $index=>$qid)
            {

                $order = $index + 1;

                $qid = (int)$qid;

                $qinsert->bind_param(
                    "iii",
                    $assessment_id,
                    $qid,
                    $order
                );

                $qinsert->execute();

            }

        }



        $total_questions = 0;

        $qcount = $conn->prepare("
        SELECT COUNT(*) 
        FROM assessment_questions 
        WHERE assessment_id = ?
        ");

        $qcount->bind_param("i", $assessment_id);
        $qcount->execute();
        $qcount->bind_result($total_questions);
        $qcount->fetch();
        $qcount->close();

        /*
        |--------------------------------------------------------------------------
        | ASSIGN STUDENTS
        |--------------------------------------------------------------------------
        */

        if (!empty($student_ids))
        {

          $assign = $conn->prepare(
            "
            INSERT INTO assessment_assignments
            (
            assessment_id,
            student_id,
            total_questions
            )
            VALUES (?,?,?)
            "
            );

            foreach ($student_ids as $sid)
            {

                $sid = (int)$sid;

              $assign->bind_param(
                "iii",
                $assessment_id,
                $sid,
                $total_questions
                );

                $assign->execute();

            }

        }



        $conn->commit();

      echo "<script>
        alert('Assessment Created Successfully');
        window.location='../teacher_dashboard.php?page=teacher_question_pages/manage_assessments.php';
        </script>";
        exit();
    }

    catch(Exception $e)
    {

        $conn->rollback();

        $msg =
        "
        <div class='alert alert-danger'>
            ".$e->getMessage()."
        </div>
        ";

    }

}

end_submit:
?>



<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
rel="stylesheet"
>



<style>

.form-container
{
padding:5px;
}

.checkbox-list label
{
display:block;
padding:8px;
border-radius:6px;
cursor:pointer;
}

.checkbox-list label:hover
{
background:#f1f5f9;
}

.section-title
{
font-size:22px;
font-weight:600;
margin-bottom:20px;
display:flex;
gap:10px;
align-items:center;
}

/* ============================= */
/* MOBILE RESPONSIVE FIX */
/* ============================= */

@media (max-width: 575px)
{

.form-container
{
padding:0;
}


/* Title responsive */
.section-title
{
font-size:18px;
flex-wrap:wrap;
}


/* All inputs full width */
.row.g-4 > div
{
width:100%;
flex:0 0 100%;
max-width:100%;
}


/* Fix datetime input */
input[type="datetime-local"]
{
width:100%;
}


/* Fix selects */
select.form-select
{
width:100%;
}


/* Fix number input */
input[type="number"]
{
width:100%;
}


/* Checkbox container */
.checkbox-list
{
max-height:250px;
padding:10px;
}


/* Checkbox label wrap */
.checkbox-list label
{
font-size:14px;
word-break:break-word;
}


/* Button full width */
button.btn-lg
{
width:100%;
padding:12px;
font-size:16px;
}


/* Remove side spacing */
.col-lg-8,
.col-lg-4,
.col-md-4,
.col-md-3
{
padding-left:0;
padding-right:0;
}

}


/* ================================= */
/* ULTRA SMALL MOBILE FIX (300px+) */
/* ================================= */

@media (max-width: 575px)
{

/* give inner breathing space */
.form-container
{
padding:12px;
}


/* proper spacing between rows */
.row.g-4
{
row-gap:14px !important;
}


/* fix all inputs */
.form-control,
.form-select
{
width:100%;
padding:10px 12px;
font-size:15px;
border-radius:8px;
}


/* fix textarea specifically */
textarea.form-control
{
padding:12px;
min-height:90px;
resize:vertical;
}


/* datetime input fix */
input[type="datetime-local"]
{
padding:10px 12px;
}


/* number input */
input[type="number"]
{
padding:10px 12px;
}


/* checkbox alignment */
.form-check
{
padding-left:28px;
}

.form-check-input
{
margin-left:-28px;
margin-top:4px;
}


/* select dropdown spacing */
select.form-select
{
padding:10px 12px;
}


/* student checkbox container */
.checkbox-list
{
padding:12px;
max-height:220px;
}


/* checkbox label */
.checkbox-list label
{
padding:6px 4px;
font-size:14px;
}


/* button fix */
button.btn-lg
{
width:100%;
padding:12px;
font-size:16px;
border-radius:8px;
}


/* remove column side cut */
.col-lg-8,
.col-lg-4,
.col-md-4,
.col-md-3,
.col-12
{
padding-left:4px !important;
padding-right:4px !important;
}

}


/* ================================= */
/* EXTREME SMALL DEVICES (300px) */
/* ================================= */

@media (max-width: 360px)
{

.form-container
{
padding:10px;
}

.section-title
{
font-size:16px;
}

.form-control,
.form-select
{
font-size:14px;
padding:9px 10px;
}

textarea.form-control
{
min-height:80px;
}

button.btn-lg
{
font-size:15px;
padding:10px;
}

}

</style>



<div class="form-container">


<div class="section-title">

<i class="bi bi-clipboard-plus text-primary"></i>

Assign Assessment

</div>


<?= $msg ?>


<form method="POST" action="teacher_question_pages/assign_assessment.php">


<div class="row g-4">


<div class="col-lg-8">

<input
type="text"
name="title"
class="form-control form-control-lg"
placeholder="Assessment Title"
required>

</div>



<div class="col-lg-4">

<input
type="datetime-local"
name="due_date"
class="form-control form-control-lg">

</div>



<div class="col-12">

<textarea
name="description"
class="form-control"
rows="3"
placeholder="Description">
</textarea>

</div>



<div class="col-md-4">

<input
type="number"
name="time_limit"
class="form-control"
value="30">

</div>



<div class="col-md-4">

<div class="form-check mt-2">

<input
type="checkbox"
name="allow_retake"
class="form-check-input"
checked>

<label class="form-check-label">
Allow Retake
</label>

</div>

</div>



<hr>



<div class="col-md-3">

<select id="grade" class="form-select">

<option value="">
-- Grade --
</option>

<?php foreach($grades as $g): ?>

<option value="<?= $g ?>">

Grade <?= $g ?>

</option>

<?php endforeach; ?>

</select>

</div>



<div class="col-md-3">

<select id="subject_id" class="form-select">

<option>
-- Subject --
</option>

</select>

</div>



<div class="col-md-3">

<select id="chapter_id" class="form-select">

<option>
-- Chapter --
</option>

</select>

</div>



<div class="col-md-3">

<select name="topic_id" id="topic_id" class="form-select">

<option>
-- Topic --
</option>

</select>

</div>

<div class="col-12 mt-4">

<h5>Select Questions</h5>

<div id="question-list" class="border p-3 rounded" style="max-height:300px;overflow:auto;">

Select topic to load questions

</div>

</div>

<div class="col-12">

<h5>Assign Students</h5>

<div class="checkbox-list border rounded p-3" style="max-height:300px;overflow:auto;">

<?php foreach($students as $s): ?>

<label>

<input type="checkbox" name="student_ids[]" value="<?= $s['id'] ?>">

<?= htmlspecialchars($s['name']) ?>

</label>

<?php endforeach; ?>

</div>

</div>



<div class="col-12 text-center mt-4">

<button type="submit" class="btn btn-primary btn-lg px-5">

Assign Assessment

</button>

</div>


</div>


</form>


</div>
<script>

$(document).ready(function(){


// Grade -> Subjects
$("#grade").change(function(){

let grade=$(this).val();

$.get("teacher_question_pages/fetch_subjects.php",
{grade:grade},
function(data){

$("#subject_id").html('<option value="">All Subjects</option>'+data);

$("#chapter_id").html('<option value="">All Chapters</option>');

$("#topic_id").html('<option value="">All Topics</option>');

});

});



// Subject -> Chapters
$("#subject_id").change(function(){

let sid=$(this).val();

$.get("teacher_question_pages/fetch_chapters.php",
{subject_id:sid},
function(data){

$("#chapter_id").html('<option value="">All Chapters</option>'+data);

$("#topic_id").html('<option value="">All Topics</option>');

});

});



// Chapter -> Topics
$("#chapter_id").change(function(){

let cid=$(this).val();

$.get("teacher_question_pages/fetch_topics.php",
{chapter_id:cid},
function(data){

$("#topic_id").html('<option value="">All Topics</option>'+data);

});

});



});

// Topic -> Questions
$("#topic_id").change(function(){

let tid=$(this).val();

if(!tid){
$("#question-list").html("No topic selected");
return;
}

$("#question-list").html("Loading questions...");

$.get(
"teacher_question_pages/fetch_questions_for_assessment.php",
{topic_id:tid},
function(data){

$("#question-list").html(data);

});

});

</script>