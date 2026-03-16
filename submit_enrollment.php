<?php

include 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

$name = mysqli_real_escape_string($conn,$_POST['name']);
$email = mysqli_real_escape_string($conn,$_POST['email']);
$phone = mysqli_real_escape_string($conn,$_POST['phone']);
$program = mysqli_real_escape_string($conn,$_POST['program']);
$grade = mysqli_real_escape_string($conn,$_POST['grade']);
$subject = mysqli_real_escape_string($conn,$_POST['subject']);
$message = mysqli_real_escape_string($conn,$_POST['message']);


/* INSERT DATA */

$sql = "INSERT INTO enrollment_inquiries 
(name,email,phone,program,grade,subject,message)
VALUES ('$name','$email','$phone','$program','$grade','$subject','$message')";

$query = mysqli_query($conn,$sql);


/* SEND EMAIL */

$admin_email = "admin@yourdomain.com";

$mail_subject = "New Enrollment Query";

$mail_body = "
New Enrollment Query Received

Name: $name
Email: $email
Phone: $phone
Program: $program
Grade: $grade
Subject: $subject

Message:
$message
";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

mail($admin_email,$mail_subject,$mail_body,$headers);


/* RESPONSE */

if($query){

echo "<script>
alert('Enrollment query submitted successfully');
window.location='enroll.php';
</script>";

}else{

echo "<script>
alert('Something went wrong');
window.location='enroll.php';
</script>";

}

}

?>