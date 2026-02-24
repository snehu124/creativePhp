<?php
session_start();
include "db_config.php";

/* ================= VALIDATE REQUEST ================= */

if (empty($_POST['password']) || empty($_POST['token'])) {

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Invalid Request';
    $_SESSION['msg_text']  = 'Something went wrong. Please try again.';

    header("Location: message.php");
    exit;
}


/* ================= GET INPUT ================= */

$password = trim($_POST['password']);
$token    = mysqli_real_escape_string($conn, $_POST['token']);


/* ================= PASSWORD LENGTH ================= */

if (strlen($password) < 6) {

    $_SESSION['msg_type']   = 'error';
    $_SESSION['msg_title']  = 'Weak Password';
    $_SESSION['msg_text']   = 'Password must be at least 6 characters long.';
    $_SESSION['msg_back']   = 'teacher_reset_password.php?token=' . urlencode($token);

    header("Location: message.php");
    exit;
}


/* ================= CHECK TOKEN ================= */

$check = mysqli_query($conn, "
    SELECT id 
    FROM teachers 
    WHERE reset_token='$token' 
    AND token_expiry > NOW()
");

if (mysqli_num_rows($check) !== 1) {

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Session Expired';
    $_SESSION['msg_text']  = 'Your reset session has expired. Please request again.';

    header("Location: teacher_forgot_password.php");
    exit;
}


/* ================= HASH PASSWORD ================= */

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


/* ================= UPDATE PASSWORD ================= */

$row = mysqli_fetch_assoc($check);
$id  = $row['id'];

$update = mysqli_query($conn, "
    UPDATE teachers 
    SET password='$hashedPassword',
        reset_token=NULL,
        token_expiry=NULL
    WHERE id='$id'
");

if (!$update) {

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Update Failed';
    $_SESSION['msg_text']  = 'Unable to update password. Please try again later.';

    header("Location: message.php");
    exit;
}


/* ================= SUCCESS ================= */

$_SESSION['msg_type']  = 'success';
$_SESSION['msg_title'] = 'Password Updated';
$_SESSION['msg_text']  = 'Your password has been changed successfully. You can now login.';

header("Location: message.php");
exit;
