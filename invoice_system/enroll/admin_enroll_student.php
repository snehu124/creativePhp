<?php 
include "../../db_config.php";
?>
<style>

.dashboard-card
 {
    min-height: 400px;
}
.enroll-section{
padding:32px 10px;
background:#f7f9fc;
}

.enroll-title{
font-family:"Love Ya Like A Sister", cursive;
font-size:36px;
text-align:center;
color:#05364d;
margin-bottom:30px;
}

.enroll-form{
max-width:900px;
margin:auto;
background:#fff;
padding:35px 30px;
border-radius:18px;
box-shadow:0 10px 35px rgba(0,0,0,0.08);
}

.form-row{
display:flex;
gap:20px;
margin-bottom:15px;
}

.form-group{
flex:1;
display:flex;
flex-direction:column;
}

.form-group label{
font-weight:600;
margin-bottom:6px;
font-size:14px;
}

.form-group input,
.form-group select,
.form-group textarea{
padding:12px 14px;
border-radius:10px;
border:1px solid #ddd;
font-size:14px;
width:100%;
}

.form-group textarea{
height:110px;
resize:none;
}

.submit-btn{
background:#e8063c;
color:#fff;
border:none;
padding:12px 35px;
border-radius:25px;
font-weight:600;
cursor:pointer;
margin-top:10px;
}

.submit-btn:hover{
background:#111;
}

.section-title{
font-size:18px;
margin:20px 0 10px;
border-bottom:2px solid #e8063c;
padding-bottom:5px;
}

.required{
color:red;
font-weight:bold;
margin-left:3px;
}

.terms-box{
background:#fff8e1;
padding:20px;
border-radius:12px;
margin:25px 0;
font-size:13px;
line-height:1.6;
}

.form-check{
margin-top:10px;
}

.form-check input{
margin-right:6px;
}
/* ================= MOBILE RESPONSIVE ================= */

@media (max-width:768px){

  .enroll-form{
    padding:20px 15px;
  }

  .enroll-title{
    font-size:30px;
  }
.enroll-section {
    background: #f7f9fc;
    padding: 20px 0px;
}
 
  .form-row{
    flex-direction:column;
    gap:12px;
  }

  .form-group{
    width:100%;
  }

  /* input size optimize */
  .form-group input,
  .form-group select,
  .form-group textarea{
    font-size:13px;
    padding:10px 12px;
  }

  .form-group textarea{
    height:90px;
  }

  /* section titles */
  .section-title{
    font-size:16px;
  }

  /* terms box compact */
  .terms-box{
    padding:15px;
    font-size:12px;
  }

  /* button full width */
  .submit-btn{
    width:100%;
    padding:12px;
  }

}
</style>


<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<div class="enroll-section">

<h2 class="enroll-title">Admin Student Enrollment</h2>

<form method="POST" action="invoice_system/enroll/save_admin_enrollment.php" class="enroll-form">

<!-- Student Details -->

<h3 class="section-title">Student Details</h3>

<div class="form-row">

<div class="form-group">
<label>First Name  <span class="required">*</span></label>
<input type="text" name="first_name" placeholder="Enter student's first name" required>
</div>

<div class="form-group">
<label>Last Name  <span class="required">*</span></label>
<input type="text" name="last_name" placeholder="Enter student's last name" required>
</div>

</div>


<div class="form-row">

<div class="form-group">
<label>Date of Birth  <span class="required">*</span></label>
<input type="date" name="dob" required>
</div>

<div class="form-group">
<label>Enrollment Date  <span class="required">*</span></label>
<input type="date" name="enroll_date" required>
</div>

</div>


<div class="form-row">

<div class="form-group">
<label>Grade  <span class="required">*</span></label>

<select name="grade" required>

<option value="">Select Grade</option>

<option>Pre-School</option>
<option>Kindergarten</option>

<option>Grade 1</option>
<option>Grade 2</option>
<option>Grade 3</option>
<option>Grade 4</option>
<option>Grade 5</option>
<option>Grade 6</option>
<option>Grade 7</option>
<option>Grade 8</option>

<option>Grade 9</option>
<option>Grade 10</option>
<option>Grade 11</option>
<option>Grade 12</option>

</select>

</div>

<div class="form-group">
<label>Program</label>
<input type="text" name="program" placeholder="Example: Early Starters">
</div>

</div>


<div class="form-row">

<div class="form-group">
<label>Subject  <span class="required">*</span></label>

<select name="subject" required>

<option value="">Select Subject</option>
<option>Mathematics</option>
<option>Science</option>
<option>Reading & Writing</option>

</select>

</div>

<div class="form-group">
<label>Mode of Education</label>

<select name="mode_of_education">

<option value="">Select Mode</option>
<option>Physical</option>
<option>Online</option>

</select>

</div>

</div>


<!-- Guardian -->

<h3 class="section-title">Guardian Information</h3>

<div class="form-row">

<div class="form-group">
<label>Guardian Name  <span class="required">*</span></label>
<input type="text" name="guardian_name" placeholder="Enter guardian full name" required>
</div>

<div class="form-group">
<label>Guardian Email  <span class="required">*</span></label>
<input type="email" name="guardian_email" placeholder="guardian@email.com" required>
</div>

</div>


<div class="form-row">

<div class="form-group">
<label>Guardian Phone  <span class="required">*</span></label>
<input type="text" name="guardian_phone" placeholder="10 digit phone number" required>
</div>

<div class="form-group">
<label>Payment Will Be Made By  <span class="required">*</span></label>

<select name="payment_by" required>

<option value="">Select</option>

<option>Guardian</option>
<option>Mother</option>
<option>Father</option>

</select>

</div>

</div>


<!-- Parents -->

<h3 class="section-title">Parent Information</h3>

<div class="form-row">

<div class="form-group">
<label>Mother Name</label>
<input type="text" name="mother_name" placeholder="Enter mother name">
</div>

<div class="form-group">
<label>Mother Email</label>
<input type="email" name="mother_email" placeholder="mother@email.com">
</div>

<div class="form-group">
<label>Mother Phone</label>
<input type="text" name="mother_phone" placeholder="Mother phone number">
</div>

</div>


<div class="form-row">

<div class="form-group">
<label>Father Name</label>
<input type="text" name="father_name" placeholder="Enter father name">
</div>

<div class="form-group">
<label>Father Email</label>
<input type="email" name="father_email" placeholder="father@email.com">
</div>

<div class="form-group">
<label>Father Phone</label>
<input type="text" name="father_phone" placeholder="Father phone number">
</div>

</div>


<!-- Emergency -->

<h3 class="section-title">Emergency Contact</h3>

<div class="form-row">

<div class="form-group">
<label>Emergency Contact Name</label>
<input type="text" name="emergency_name" placeholder="Emergency contact person">
</div>

<div class="form-group">
<label>Emergency Phone</label>
<input type="text" name="emergency_phone" placeholder="Emergency phone number">
</div>

</div>


<div class="form-row">

<div class="form-group">
<label>Authorized Pickup Name</label>
<input type="text" name="authorized_name" placeholder="Person allowed to pickup">
</div>

<div class="form-group">
<label>Relation</label>
<input type="text" name="authorized_relation" placeholder="Relation with student">
</div>

</div>


<!-- Admin Fields -->

<h3 class="section-title">Payment Information</h3>

<div class="form-row">

<div class="form-group">
<label>Payment Type <span class="required">*</span></label>

<select name="payment_type" required>

<option value="">Select Payment Type</option>

<option>Cash</option>
<option>Bank Transfer</option>
<option>E-Transfer</option>

</select>

</div>

</div>


<div class="form-group">
<label>Admin Message / Notes</label>
<textarea name="message" placeholder="Optional notes about student"></textarea>
</div>

<!-- Terms & Conditions -->

<div class="terms-box">

<p><strong>Terms & Conditions:</strong></p>

<ul>

<li>A non-refundable Registration fee is required at time of registration.</li>

<li>Student course fees, activity fees and other material fees are non-refundable.</li>

<li>No placement is confirmed prior to any mode of payment.</li>

<li>One month notice or fee in lieu of is required for withdrawals.</li>

<li>No refund for leave of absence during course term.</li>

<li>Sibling discount of $10 per month applies only if first child is enrolled.</li>

<li>Course fees do not include short term programs such as Summer Camp or Workshops.</li>

<li>Preferred payment method is e-transfer to  
<b>info@achieverscastle.com</b></li>

<li>NSF cheque will incur $25 service charge.</li>

<li>Late payments may incur late charges.</li>

<li>Fees may increase annually due to cost of living adjustment.</li>

<li>Achievers Castle Learning Centre Ltd. is not liable for injuries unless due to negligence.</li>

<li>Photos or videos may be used for promotional purposes unless otherwise specified.</li>

<li>All information submitted in this form must be accurate.</li>

</ul>

<div class="form-check">

<input type="checkbox" name="terms_agreed" value="1" required>

<label>
<strong>I confirm that the guardian/parent agrees to the above Terms & Conditions.</strong>
</label>

</div>

</div>

<div style="text-align:center">

<button class="submit-btn" type="submit">
Enroll Student
</button>

</div>

</form>

</div>

<script>
document.querySelector(".enroll-form").addEventListener("submit", function(e){

    let paymentBy = document.querySelector("[name='payment_by']").value;

    let guardianEmail = document.querySelector("[name='guardian_email']").value.trim();
    let motherEmail = document.querySelector("[name='mother_email']").value.trim();
    let fatherEmail = document.querySelector("[name='father_email']").value.trim();

    if(paymentBy === "Guardian" && guardianEmail === ""){
        alert("Guardian email is required!");
        e.preventDefault();
    }

    if(paymentBy === "Mother" && motherEmail === ""){
        alert("Mother email is required!");
        e.preventDefault();
    }

    if(paymentBy === "Father" && fatherEmail === ""){
        alert("Father email is required!");
        e.preventDefault();
    }

});
</script>