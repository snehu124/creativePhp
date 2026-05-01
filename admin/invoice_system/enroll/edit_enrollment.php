    <?php
    include "../../../db_config.php";

   $student_id = $_GET['student_id'] ?? 0;
    if(!$student_id){
        die("Invalid Student ID");
    }

    $data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM enrollment_inquiries 
    WHERE student_id='$student_id'
    "));

    if(!$data){
        die("Student not found");
    }
    $discountData = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT discount_type, discount_amount 
    FROM invoices 
    WHERE student_id='$student_id'
    ORDER BY id DESC 
    LIMIT 1
    "));

    $discount_type = $discountData['discount_type'] ?? '';
    $discount_amount = $discountData['discount_amount'] ?? '';
    ?>

    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

    <div class="enroll-section">

    <h2 class="enroll-title"><i class="bi bi-pencil-square"></i> Edit Enrollment</h2>

    <form id="editForm" class="enroll-form">

    <input type="hidden" name="discount_removed" id="discount_removed" value="0">
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

    <div class="form-row">
    <div class="form-group">
    <label>Grade</label>
    <select name="grade" id="grade" required>

    <option value="Pre-School" <?php if($data['grade']=="Pre-School") echo "selected"; ?>>Pre-School</option>
    <option value="Kindergarten" <?php if($data['grade']=="Kindergarten") echo "selected"; ?>>Kindergarten</option>

    <option value="Grade 1" <?php if($data['grade']=="1" || $data['grade']=="Grade 1") echo "selected"; ?>>Grade 1</option>
    <option value="Grade 2" <?php if($data['grade']=="2" || $data['grade']=="Grade 2") echo "selected"; ?>>Grade 2</option>
    <option value="Grade 3" <?php if($data['grade']=="3" || $data['grade']=="Grade 3") echo "selected"; ?>>Grade 3</option>
    <option value="Grade 4" <?php if($data['grade']=="4" || $data['grade']=="Grade 4") echo "selected"; ?>>Grade 4</option>
    <option value="Grade 5" <?php if($data['grade']=="5" || $data['grade']=="Grade 5") echo "selected"; ?>>Grade 5</option>
    <option value="Grade 6" <?php if($data['grade']=="6" || $data['grade']=="Grade 6") echo "selected"; ?>>Grade 6</option>
    <option value="Grade 7" <?php if($data['grade']=="7" || $data['grade']=="Grade 7") echo "selected"; ?>>Grade 7</option>
    <option value="Grade 8" <?php if($data['grade']=="8" || $data['grade']=="Grade 8") echo "selected"; ?>>Grade 8</option>

    <option value="Grade 9" <?php if($data['grade']=="9" || $data['grade']=="Grade 9") echo "selected"; ?>>Grade 9</option>
    <option value="Grade 10" <?php if($data['grade']=="10" || $data['grade']=="Grade 10") echo "selected"; ?>>Grade 10</option>
    <option value="Grade 11" <?php if($data['grade']=="11" || $data['grade']=="Grade 11") echo "selected"; ?>>Grade 11</option>
    <option value="Grade 12" <?php if($data['grade']=="12" || $data['grade']=="Grade 12") echo "selected"; ?>>Grade 12</option>

    </select>
    </div>

    <div class="form-group">
    <label>Program</label>
    <select name="program" id="program" required>
    <option value="Early Starters" <?php if($data['program']=="Early Starters") echo "selected"; ?>>Early Starters</option>

    <option value="Elementary" <?php if($data['program']=="Elementary") echo "selected"; ?>>Elementary</option>

    <option value="Advanced Learners" <?php if($data['program']=="Advanced Learners") echo "selected"; ?>>Advanced Learners</option>
    </select>
    </div>
    </div>
    <div class="form-row">
    <div class="form-group">
    <label>Program Count</label>
    <select name="program_count" id="program_count" required>
    <option value="">Select Number of Programs</option>
    </select>
    </div>

    </div>

    <div class="form-row" id="subject_section">
        <div class="form-group">
            <label>Select Subjects</label>
            <div id="subject_container"></div>
        </div>
    </div>


<!-- 💼 DISCOUNT CARD -->
<div class="discount-card">

  <div class="discount-header">
    <span class="discount-icon">💸</span>
    <h3>Discount</h3>
  </div>

  <div class="discount-body">
    
    <div class="form-row">
      <div class="form-group">
        <label>Discount Type</label>
        <select name="discount_type" id="discount_type">
          <option value="">No Discount</option>
          <option value="sibling" <?php if($discount_type=="sibling") echo "selected"; ?>>
            Sibling Discount (Recurring)
          </option>
          <option value="one_time" <?php if($discount_type=="one_time") echo "selected"; ?>>
            One Time Discount
          </option>
        </select>
      </div>

      <div class="form-group" id="discount_amount_box" style="display:<?php echo ($discount_type ? 'block':'none'); ?>">
        <label>Discount Amount ($)</label>
        <input type="number" name="discount_amount" value="<?php echo $discount_amount; ?>" step="0.01">
      </div>
    </div>

  </div>

</div>
<?php if(!empty($discount_type)): ?>
<div class="discount-badge">
  Active: <?php echo ucfirst(str_replace("_"," ",$discount_type)); ?> ($<?php echo $discount_amount; ?>)
</div>
<?php endif; ?>


    <div class="submit-wrapper">
    <button class="submit-btn">Update Plan</button>
    </div>

    </form>

    </div>

    <style>

    .enroll-section{
    padding:0px 10px;
    background:#f7f9fc;
    }

    .enroll-title{
    font-family:"Love Ya Like A Sister", cursive;
    font-size:30px;
    /* text-align:center; */
    color:#05364d;
    margin-bottom:25px;
    }

    .enroll-form{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    width:600px;
    
    }

    .form-row{
    display:flex;
    gap:15px;
    margin-bottom:15px;
    }

    .form-group{
    flex:1;
    display:flex;
    flex-direction:column;
    }

    .form-group label{
    font-weight:600;
    margin-bottom:5px;
    }

    .form-group input,
    .form-group select{
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
    }
    .form-row.single .form-group{
    flex: 100%;
    }
    .enroll-form{
    max-width:700px;
    }
   .submit-btn{
  background: linear-gradient(135deg,#16a34a,#22c55e);
  color:white;
  border:none;
  padding:12px 30px;
  border-radius:30px;
  font-weight:600;
  cursor:pointer;
  transition: all 0.2s ease;
}

    .submit-btn:hover{
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(34,197,94,0.3);
    }

     /* 💼 PROFESSIONAL DISCOUNT CARD */
.discount-card{
  background: #ffffff;
  border-radius: 14px;
  box-shadow: 0 4px 18px rgba(0,0,0,0.06);
  border: 1px solid #eee;
  margin-top: 15px;
  overflow: hidden;
}

.discount-header{
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 18px;
  border-bottom: 1px solid #f1f1f1;
  background: #fafafa;
}

.discount-header h3{
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #222;
}

.discount-icon{
  font-size: 18px;
}

.discount-body{
  padding: 18px;
}
.discount-badge{
  font-size: 12px;
  background: #ecfdf5;
  color: #166534;
  padding: 6px 10px;
  border-radius: 20px;
  display: inline-block;
  margin: 10px 18px 0;
}
/* input focus premium feel */
.discount-card select,
.discount-card input{
  transition: all 0.2s ease;
}

.discount-card select:focus,
.discount-card input:focus{
  border-color: #22c55e;
  box-shadow: 0 0 0 2px rgba(34,197,94,0.1);
}
.submit-wrapper{
  display: flex;
  justify-content: center;
  margin-top: 25px;
}
        .subject-box {
        display:flex;
        align-items:center;
        gap:6px;
        padding:6px 12px;
        border:1px solid #ddd;
        border-radius:20px;
        cursor:pointer;
        font-size:13px;
        background:#fff;
        transition:0.2s;
        width:auto;
    }

    .subject-box:hover {
        background:#f0f4ff;
        border-color:#2a5298;
    }

    .subject-box input:checked + span {
        font-weight:600;
        color:#2a5298;
    }

    #subject_container {
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }

    /* MOBILE */
    @media(max-width:768px){

    .form-row{
    flex-direction:column;
    }

    }

    </style>

    <script>
   (function(){

var programSelect = document.getElementById("program");
var programCountSelect = document.getElementById("program_count");
var subjectContainer = document.getElementById("subject_container");
var subjectSection = document.getElementById("subject_section");

var savedProgram = "<?php echo $data['program']; ?>";
var savedProgramCount = "<?php echo strtolower(trim($data['program_count'])); ?>";
var rawSubjects = "<?php echo $data['specific_subject']; ?>";

var selectedSubjects = [];
var isAllPrograms = false;

if(rawSubjects.toLowerCase().trim() === "all programs"){
    isAllPrograms = true;
}
else{
    selectedSubjects = rawSubjects.split(",").map(s => s.trim());
}
document.getElementById("grade").addEventListener("change", function(){
    selectedSubjects = [];
    programCountSelect.value = "";
    subjectContainer.innerHTML = "";
});
/* ===== FUNCTIONS ===== */

function setProgramCount(program){
    program = program.trim().toLowerCase();

    let html = '<option value="">Select Number of Programs</option>';

    if(program === "early starters"){
        html += `<option value="all">All Programs</option>`;
    } else {
        html += `
            <option value="1">One Program</option>
            <option value="2">Two Programs</option>
            <option value="all">Three / All Programs</option>
        `;
    }

    programCountSelect.innerHTML = html;

    if(savedProgramCount){
     if(savedProgramCount === "3" || savedProgramCount === "all"){
            programCountSelect.value = "all";
        }
        else{
            for(let opt of programCountSelect.options){
                if(opt.value.toLowerCase().trim() === savedProgramCount){
                    programCountSelect.value = opt.value;
                    break;
                }
            }
        }
    }
}
function loadSubjects(){
    let program = programSelect.value;
    let programCount = programCountSelect.value;

    if(program === "" || programCount === "") return;

    subjectSection.style.display = "block";
    subjectContainer.innerHTML = "Loading...";

    fetch("invoice_system/enroll/get_subjects.php?program=" + encodeURIComponent(program))
    .then(res => res.json())
    .then(data => {

        subjectContainer.innerHTML = "";

        data.forEach(sub => {

            let checked = "";

        if(isAllPrograms){
            checked = "checked";
        }
        else{
            checked = selectedSubjects.some(s =>
                s.toLowerCase() === sub.subject_name.toLowerCase()
            ) ? "checked" : "";
        }

            subjectContainer.innerHTML += `
                <label class="subject-box">
                    <input type="checkbox" name="subjects[]" value="${sub.subject_name}" ${checked}>
                    <span>${sub.subject_name}</span>
                </label>
            `;
        });

    });
}

/* ===== INIT ===== */
setProgramCount(savedProgram);
loadSubjects();

/* ===== EVENTS ===== */

programSelect.addEventListener("change", function(){
    selectedSubjects = [];
    setProgramCount(this.value);
    programCountSelect.value = "";
    subjectContainer.innerHTML = "";
});

programCountSelect.addEventListener("change", function(){
    selectedSubjects = [];
    subjectContainer.innerHTML = "";
    loadSubjects();
});

subjectContainer.addEventListener("change", function(){

    let selectedValue = programCountSelect.value;
    let checked = document.querySelectorAll("input[name='subjects[]']:checked");

    if(selectedValue === "all") return;

    let max = parseInt(selectedValue);

    if(checked.length > max){
        alert("You can select only " + max + " subjects");
        checked[checked.length - 1].checked = false;
    }

});

$("#editForm").off("submit").on("submit", function(e){
    e.preventDefault();

    let btn = $(this).find(".submit-btn");

    if(btn.prop("disabled")) return;

    btn.prop("disabled", true).text("Updating...");

    let formData = $(this).serialize();

    $.ajax({
        url:"invoice_system/enroll/update_enrollment.php",
        type:"POST",
        data:formData,
        success:function(res){
            $("#page-content").html(res);
        },
        error:function(){
            alert("Update failed");
            btn.prop("disabled", false).text("Update Plan");
        }
    });
});

})();

document.getElementById("discount_type").addEventListener("change", function(){

    let type = this.value;
    let box = document.getElementById("discount_amount_box");

    // show/hide amount field
    box.style.display = type ? "block" : "none";

    // 🔥 REMOVE LOGIC
    if(type === ""){
        document.getElementById("discount_removed").value = "1";
    } else {
        document.getElementById("discount_removed").value = "0";
    }

});

// grade dependency

document.getElementById("grade").addEventListener("change", function(){

    let grade = this.value;
    let programSelect = document.getElementById("program");

    // reset program
    programSelect.value = "";

    if(grade === "") return;

    if(
        grade === "Pre-School" || 
        grade === "Kindergarten" ||
        grade === "Grade 1" || 
        grade === "Grade 2"
    ){
        programSelect.value = "Early Starters";
    }
    else if(
        ["Grade 3","Grade 4","Grade 5","Grade 6","Grade 7","Grade 8"].includes(grade)
    ){
        programSelect.value = "Elementary";
    }
    else if(
        ["Grade 9","Grade 10","Grade 11","Grade 12"].includes(grade)
    ){
        programSelect.value = "Advanced Learners";
    }

    // 🔥 trigger program change manually (VERY IMPORTANT)
    programSelect.dispatchEvent(new Event('change'));
});
    </script>
