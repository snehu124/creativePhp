<?php
include "../../db_config.php";
session_start();

if (empty($_POST['password']) || empty($_POST['token'])) {
    header("Location: forgot_password.php");
    exit;
}

$password = $_POST['password'];
$token    = mysqli_real_escape_string($conn, $_POST['token']);

if (strlen($password) < 6) {
    session_start();
    $_SESSION['error'] = "Password must be at least 6 characters";
    header("Location: reset_password.php?token=$token");
    exit;
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$check = mysqli_query($conn, "
  SELECT id FROM students 
  WHERE reset_token='$token' 
  AND token_expiry > NOW()
");

if (mysqli_num_rows($check) !== 1) {
    $_SESSION['error'] = "Invalid or expired token!";
    header("Location: reset_password.php?token=$token");
    exit;
}

$row = mysqli_fetch_assoc($check);
$id  = $row['id'];

mysqli_query($conn, "
  UPDATE students 
  SET password='$hashedPassword', 
      reset_token=NULL, 
      token_expiry=NULL 
  WHERE id='$id'
");

header("Location: ../student_login.php?success=1");
exit;
