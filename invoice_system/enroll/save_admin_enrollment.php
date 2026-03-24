<?php
include "../../db_config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../PHPMailer/PHPMailer.php";
require "../../PHPMailer/SMTP.php";
require "../../PHPMailer/Exception.php";


$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$dob=$_POST['dob'];
$grade=$_POST['grade'];
$subject=$_POST['subject'];
$program=$_POST['program'];

$guardian_name=$_POST['guardian_name'];
$guardian_email=$_POST['guardian_email'];
$guardian_phone=$_POST['guardian_phone'];

$mother_name=$_POST['mother_name'];
$mother_phone=$_POST['mother_phone'];

$father_name=$_POST['father_name'];
$father_phone=$_POST['father_phone'];

$emergency_name=$_POST['emergency_name'];
$emergency_phone=$_POST['emergency_phone'];

$authorized_name=$_POST['authorized_name'];
$authorized_relation=$_POST['authorized_relation'];

$message=$_POST['message'];

$payment_by=$_POST['payment_by'];
$payment_type=$_POST['payment_type'];
$mode=$_POST['mode_of_education'];

$enroll_date=$_POST['enroll_date'];

$email_to = "";
$name_to = "";

if($payment_by == "Guardian"){
    $email_to = $guardian_email;
    $name_to = $guardian_name;
}

elseif($payment_by == "Mother"){
    $email_to = $_POST['mother_email'] ?? $guardian_email;
    $name_to = $mother_name;
}

elseif($payment_by == "Father"){
    $email_to = $_POST['father_email'] ?? $guardian_email;
    $name_to = $father_name;
}

if(!isset($_POST['terms_agreed'])){
die("Terms & Conditions must be accepted.");
}

if(empty($_POST['payment_type'])){
die("Payment type is required");
}

/* -----------------------------
SAVE STUDENT
-----------------------------*/

mysqli_query($conn,"
INSERT INTO enrollment_inquiries
(
first_name,last_name,dob,grade,specific_subject,program,
guardian_name,guardian_email,guardian_phone,
mother_name,mother_phone,father_name,father_phone,
emergency_name,emergency_phone,
authorized_name,authorized_relation,
message,terms_agreed,
payment_by,payment_type,mode_of_education,
enrolled_by,enroll_date
)

VALUES
(
'$first_name','$last_name','$dob','$grade','$subject','$program',
'$guardian_name','$guardian_email','$guardian_phone',
'$mother_name','$mother_phone','$father_name','$father_phone',
'$emergency_name','$emergency_phone',
'$authorized_name','$authorized_relation',
'$message','{$_POST['terms_agreed']}',
'$payment_by','$payment_type','$mode',
'admin','$enroll_date'
)
");

$student_id=mysqli_insert_id($conn);

/* -----------------------------
CALCULATE FEES
-----------------------------*/

$program_count = 1;

if($program == "Two Programs"){
    $program_count = 2;
}
elseif($program == "Three Programs"){
    $program_count = 3;
}


/* PRE SCHOOL → GRADE 2 */

if($grade == "Pre-School" || $grade == "Grade 1" || $grade == "Grade 2"){

    $price = 150;

}


/* GRADE 3 → 8 */

elseif(in_array($grade, ["Grade 3","Grade 4","Grade 5","Grade 6","Grade 7","Grade 8"])){

    if($program_count == 1){
        $price = 140;
    }
    elseif($program_count == 2){
        $price = 270;
    }
    else{
        $price = 400;
    }

}


/* GRADE 9 → 12 */

elseif(in_array($grade, ["Grade 9","Grade 10","Grade 11","Grade 12"])){

    if($program_count == 1){
        $price = 160;
    }
    elseif($program_count == 2){
        $price = 310;
    }
    else{
        $price = 460;
    }

}
if(!isset($price)){
    $price = 150;
}
$gst = $price * 0.05;
$total = $price + $gst;

/* -----------------------------
CREATE INVOICE
-----------------------------*/


$invoice_number="AC-".date("ymd")."-".rand(100,999);


mysqli_query($conn,"
INSERT INTO invoices
(student_id,invoice_number,invoice_date,due_date,price,gst,total,status)

VALUES
('$student_id','$invoice_number',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 15 DAY),'$price','$gst','$total','Pending')
");

$invoice_id=mysqli_insert_id($conn);



/* -----------------------------
GENERATE INVOICE PDF
-----------------------------*/

require "../../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$student=[
"id"=>$student_id,
"first_name"=>$first_name,
"last_name"=>$last_name,
"email"=>$guardian_email,
"course_title"=>$subject,
"created_at"=>date("Y-m-d")
];

$logoBase64="data:image/png;base64,".base64_encode(file_get_contents("../../images/logo.png"));

ob_start();

include "../../invoice_template.php";

$html=ob_get_clean();

$dompdf=new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper("A4");

$dompdf->render();

$pdf=$dompdf->output();

$file="../../temp_invoice.pdf";

file_put_contents($file,$pdf);



/* -----------------------------
SEND EMAIL
-----------------------------*/

$mail=new PHPMailer(true);

try{

$mail->isSMTP();

$mail->Host='smtp.gmail.com';

$mail->SMTPAuth=true;

$mail->Username='info.achieverscastle@gmail.com';

$mail->Password='hrgh jnhc kqkz zpbi';

$mail->SMTPSecure='tls';

$mail->Port=587;

$mail->setFrom('info.achieverscastle@gmail.com','Achievers Castle');

$mail->addAddress($email_to,$name_to);

$mail->Subject="Invoice for $first_name $last_name";

$mail->Body="

Hello $name_to,

Your child $first_name $last_name has been enrolled successfully.

Please find the invoice attached.

Thank you.

Achievers Castle
";

$mail->addAttachment($file,"invoice.pdf");

$mail->send();

}catch(Exception $e){

}



echo "<script>

alert('Student enrolled and invoice sent');

window.location='../../teacher_dashboard.php?page=invoice_system/dashboard/invoice_dashboard.php';

</script>";