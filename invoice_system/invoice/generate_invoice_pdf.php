<?php

require "../../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

include "../../db_config.php";

$id=$_GET['invoice_id'];

$data=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT invoices.*, enrollment_inquiries.*
FROM invoices
JOIN enrollment_inquiries
ON invoices.student_id=enrollment_inquiries.id
WHERE invoices.id='$id'
"));

$price=$data['price'];
$gst=$data['gst'];
$total=$data['total'];

$student=$data;
$student['course_title'] = $data['specific_subject'];
$student['email'] = $data['guardian_email'];

$logoBase64="data:image/png;base64,".base64_encode(file_get_contents("../../images/logo.png"));

ob_start();

include "../../invoice_template.php";

$html=ob_get_clean();

$dompdf=new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper("A4");

$dompdf->render();

$dompdf->stream("invoice.pdf",["Attachment"=>0]);