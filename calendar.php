<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}
$teacher_id = $_SESSION['teacher_id'];
?>

<style>

/* ========================= */
/* CONTAINER */
/* ========================= */

.calendar-container{
padding:15px;
max-width:100%;
}

.calendar-card{
background:white;
padding:20px;
border-radius:14px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}


/* ========================= */
/* FULLCALENDAR BASE FIX */
/* ========================= */

#calendar{
width:100%;
max-width:100%;
}

/* toolbar wrap fix */
.fc-header-toolbar{
flex-wrap:wrap !important;
gap:8px;
}

/* toolbar title */
.fc-toolbar-title{
font-size:22px;
font-weight:600;
}


/* buttons */
.fc-button{
padding:6px 10px !important;
font-size:14px !important;
}


/* table font */
.fc{
font-size:14px;
}


/* ========================= */
/* TABLET */
/* ========================= */

@media(max-width:768px){

.calendar-container{
padding:12px;
}

.calendar-card{
padding:16px;
}

.fc-toolbar-title{
font-size:18px;
}

.fc{
font-size:13px;
}

}


/* ========================= */
/* MOBILE */
/* ========================= */

@media(max-width:575px){

.calendar-container{
padding:10px;
}

.calendar-card{
padding:14px;
}

.fc-header-toolbar{
flex-direction:column !important;
align-items:center !important;
}

.fc-toolbar-title{
font-size:16px;
text-align:center;
}

.fc-button{
font-size:12px !important;
padding:5px 8px !important;
}

.fc{
font-size:12px;
}

}


/* ========================= */
/* SMALL MOBILE */
/* ========================= */

@media(max-width:360px){

.fc-toolbar-title{
font-size:15px;
}

.fc-button{
font-size:11px !important;
padding:4px 6px !important;
}

.fc{
font-size:11px;
}

}


/* ========================= */
/* ULTRA SMALL */
/* ========================= */

@media(max-width:300px){

.calendar-container{
padding:6px;
}

.calendar-card{
padding:10px;
border-radius:10px;
}

.fc-toolbar-title{
font-size:14px;
}

.fc-button{
font-size:10px !important;
padding:3px 5px !important;
}

.fc{
font-size:10px;
}

/* reduce cell height */
.fc-daygrid-day{
min-height:40px !important;
}

}


/* ========================= */
/* MODAL FIX */
/* ========================= */

@media(max-width:575px){

.modal-dialog{
margin:10px;
}

.modal-content{
padding:5px;
}

.form-control{
font-size:14px;
padding:8px;
}

}

@media(max-width:300px){

.modal-dialog{
margin:5px;
}

.form-control{
font-size:13px;
padding:6px;
}

.btn{
font-size:13px;
padding:6px;
}

}

</style>



<div class="calendar-container">

<div class="calendar-card">

<h5 class="text-center mb-3">
📅 Schedule Your Classes
</h5>

<div id="calendar"></div>

</div>

</div>



<!-- Modal -->
<div class="modal fade" id="classModal" tabindex="-1">

<div class="modal-dialog">

<form id="classForm">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">
Schedule Class
</h5>

<button type="button"
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>


<div class="modal-body">

<input type="hidden"
name="teacher_id"
value="<?= $teacher_id ?>">

<div class="mb-3">

<label>Class Title</label>

<input type="text"
name="title"
class="form-control"
required>

</div>


<div class="mb-3">

<label>Date</label>

<input type="date"
name="date"
id="classDate"
class="form-control"
required>

</div>


<div class="mb-3">

<label>Time</label>

<input type="time"
name="time"
class="form-control"
required>

</div>


<div class="mb-3">

<label>Description</label>

<textarea name="description"
class="form-control">
</textarea>

</div>

</div>


<div class="modal-footer">

<button class="btn btn-primary"
type="submit">
Save
</button>

<button class="btn btn-secondary"
type="button"
data-bs-dismiss="modal">
Cancel
</button>

</div>

</div>

</form>

</div>

</div>



<script>

function initCalendar(){

const calendarEl=document.getElementById('calendar');

const calendar=new FullCalendar.Calendar(calendarEl,{

initialView:'dayGridMonth',

height:'auto',

contentHeight:'auto',

aspectRatio:1.2,

dateClick:function(info){

$('#classDate').val(info.dateStr);

new bootstrap.Modal(document.getElementById('classModal')).show();

},

events:'fetch_classes.php'

});

calendar.render();

$('#classForm').off('submit').on('submit',function(e){

e.preventDefault();

$.post('save_class.php',

$(this).serialize(),

function(res){

alert(res.message);

if(res.status==='success'){

bootstrap.Modal.getInstance(

document.getElementById('classModal')

).hide();

calendar.refetchEvents();

}

},

'json'

);

});

}

</script>