<?php

include "../../db_config.php";

/* -----------------------------
TEST MODE (REMOVE IN PRODUCTION)
-----------------------------*/
if (date('d') != '01') {
    exit;
}

/* -----------------------------
MAIL + PDF LIBRARIES
-----------------------------*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../PHPMailer/PHPMailer.php";
require "../../PHPMailer/SMTP.php";
require "../../PHPMailer/Exception.php";

require "../../dompdf/autoload.inc.php";
use Dompdf\Dompdf;


/* -----------------------------
FETCH STUDENTS (FULL DATA)
-----------------------------*/

$result = mysqli_query($conn, "SELECT * FROM enrollment_inquiries");


while ($row = mysqli_fetch_assoc($result)) {

    $student_id = $row['id'];

    // ✅ skip duplicate monthly invoice
    $check = mysqli_query($conn, "
        SELECT id FROM invoices 
        WHERE student_id='$student_id' 
        AND DATE_FORMAT(invoice_date,'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')
    ");

    if (mysqli_num_rows($check) > 0) {
        continue;
    }

    /* -----------------------------
    SAME EMAIL LOGIC AS ENROLLMENT
    -----------------------------*/

    $email_to = "";
    $name_to = "";

    if($row['payment_by'] == "Guardian"){
        $email_to = $row['guardian_email'];
        $name_to = $row['guardian_name'];
    }
    elseif($row['payment_by'] == "Mother"){
        $email_to = $row['mother_email'] ?: $row['guardian_email'];
        $name_to = $row['mother_name'];
    }
    elseif($row['payment_by'] == "Father"){
        $email_to = $row['father_email'] ?: $row['guardian_email'];
        $name_to = $row['father_name'];
    }

    /* -----------------------------
    SAME PRICE LOGIC
    -----------------------------*/

    $program_count = 1;

    if($row['program'] == "Two Programs"){
        $program_count = 2;
    }
    elseif($row['program'] == "Three Programs"){
        $program_count = 3;
    }

    if($row['grade'] == "Pre-School" || $row['grade'] == "Grade 1" || $row['grade'] == "Grade 2"){
        $price = 150;
    }
    elseif(in_array($row['grade'], ["Grade 3","Grade 4","Grade 5","Grade 6","Grade 7","Grade 8"])){

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
    elseif(in_array($row['grade'], ["Grade 9","Grade 10","Grade 11","Grade 12"])){

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

    $invoice_number = "AC-" . date("ymd") . "-" . rand(100,999);

    mysqli_query($conn, "
    INSERT INTO invoices
    (student_id,invoice_number,invoice_date,due_date,price,gst,total,status)

    VALUES
    ('$student_id','$invoice_number',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 15 DAY),'$price','$gst','$total','Pending')
    ");

    /* -----------------------------
    GENERATE PDF (UNIQUE FILE)
    -----------------------------*/

    $student = [
        "id"=>$student_id,
        "first_name"=>$row['first_name'],
        "last_name"=>$row['last_name'],
        "email"=>$email_to,
        "course_title"=>$row['specific_subject'],
        "created_at"=>date("Y-m-d")
    ];

    $logoBase64 = "data:image/png;base64," . base64_encode(file_get_contents("../../images/logo.png"));

    ob_start();
    include "../../invoice_template.php";
    $html = ob_get_clean();

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper("A4");
    $dompdf->render();

    $pdf = $dompdf->output();

    // ✅ unique file (important)
    $file = "../../temp_invoice_".$student_id.".pdf";
    file_put_contents($file, $pdf);


    /* -----------------------------
    SEND MAIL (SAME FORMAT)
    -----------------------------*/

    $mail = new PHPMailer(true);

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

        $mail->Subject="Monthly Invoice - ".$row['first_name']." ".$row['last_name'];

        $mail->Body="

        Hello $name_to,

        Your monthly invoice has been generated.

        Please complete the payment.

        Thank you,
        Achievers Castle
        ";

        $mail->addAttachment($file,"invoice.pdf");

        $mail->send();

        echo "Mail sent to $email_to <br>";

    }catch(Exception $e){
        echo "Mail Error: ".$mail->ErrorInfo."<br>";
    }

}