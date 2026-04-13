    <?php
    include "../../db_config.php";

    $student_id = $_GET['student_id'];

    $data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM enrollment_inquiries 
    WHERE student_id='$student_id'
    "));

    if(!$data){
        die("Student not found");
    }
    ?>

    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

    <div class="enroll-section">

    <h2 class="enroll-title"><i class="bi bi-pencil-square"></i> Edit Enrollment</h2>

    <form method="POST" action="invoice_system/enroll/update_enrollment.php" class="enroll-form">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

    <div class="form-row">

    <div class="form-group">
    <label>Program</label>
    <select name="program" id="program" required>
    <option value="Early Starters" <?php if($data['program']=="Early Starters") echo "selected"; ?>>Early Starters</option>

    <option value="Elementary" <?php if($data['program']=="Elementary") echo "selected"; ?>>Elementary</option>

    <option value="Advanced Learners" <?php if($data['program']=="Advanced Learners") echo "selected"; ?>>Advanced Learners</option>
    </select>
    </div>

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

    <div style="text-align:center">
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

    .submit-btn{
    background: linear-gradient(160deg,#166534,#22c55e);
    color:white;
    border:none;
    padding:10px 25px;
    border-radius:25px;
    font-weight:600;
    cursor:pointer;
    margin-top: 23px;
    }

    .submit-btn:hover{
    opacity:0.9;
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
    const programSelect = document.getElementById("program");
    const programCountSelect = document.getElementById("program_count");
    const subjectContainer = document.getElementById("subject_container");
    const subjectSection = document.getElementById("subject_section");

    // DB values
    let savedProgram = "<?php echo $data['program']; ?>";
    let savedProgramCount = "<?php echo $data['program_count']; ?>";
    let rawSubjects = "<?php echo $data['specific_subject']; ?>";

    let selectedSubjects = [];

    if(rawSubjects !== "All Programs"){
        selectedSubjects = rawSubjects.split(",").map(s => s.trim());
    }

    /* ================= SET PROGRAM COUNT ================= */
    function setProgramCount(program){

        program = program.trim().toLowerCase(); // ✅ FIX

        let html = '<option value="">Select Number of Programs</option>';

        if(program === "early starters"){
            html += `<option value="all">All Programs</option>`;
        }
        else if(program === "elementary" || program === "advanced learners"){
            html += `
                <option value="1">One Program</option>
                <option value="2">Two Programs</option>
                <option value="all">Three / All Programs</option>
            `;
        }

        programCountSelect.innerHTML = html;

    if(savedProgram){
        programCountSelect.value = savedProgramCount;
        savedProgram = ""; // reset after first use
    }
    }

    /* ================= LOAD SUBJECTS ================= */
    function loadSubjects(){

        let program = programSelect.value;
        let programCount = programCountSelect.value;

        if(program === "" || programCount === ""){
            return;
        }

        subjectSection.style.display = "block";
        subjectContainer.innerHTML = "Loading...";

        fetch("invoice_system/enroll/get_subjects.php?program=" + encodeURIComponent(program))
        .then(res => res.json())
        .then(data => {

            subjectContainer.innerHTML = "";

            data.forEach(sub => {

                let checked = selectedSubjects.some(s => 
                    s.toLowerCase() === sub.subject_name.toLowerCase()
                ) ? "checked" : "";

                subjectContainer.innerHTML += `
                    <label class="subject-box">
                        <input type="checkbox" name="subjects[]" value="${sub.subject_name}" ${checked}>
                        <span>${sub.subject_name}</span>
                    </label>
                `;
            });

        });
    }

    setProgramCount(savedProgram);
    loadSubjects();

    /* ================= EVENTS ================= */

    // Program change → reset everything
    programSelect.addEventListener("change", function(){

        selectedSubjects = []; // reset

        setProgramCount(this.value);

        // ✅ FORCE RESET dropdown
        programCountSelect.value = "";

        subjectContainer.innerHTML = "";
    });

    // Program count change → ONLY subjects reload
    programCountSelect.addEventListener("change", function(){
        selectedSubjects = [];
        subjectContainer.innerHTML = "";
        loadSubjects();
    });

    /* ================= LIMIT ================= */
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

    </script>
