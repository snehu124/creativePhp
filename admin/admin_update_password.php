<?php
include "../db_config.php";
function showMessage($type,$title,$msg,$btn="Back to Login",$link="login.php")
{
$color1 = $type=="success" ? "#0d47a1" : "#dc3545";
$color2 = $type=="success" ? "#1565c0" : "#ff4d4d";
$icon   = $type=="success" ? "bi-check-circle-fill" : "bi-exclamation-triangle-fill";

echo '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
font-family:Segoe UI,sans-serif;
}
.box{
width:500px;
background:#fff;
padding:35px;
border-radius:22px;
text-align:center;
box-shadow:0 20px 55px rgba(0,0,0,.18);
}
.icon{
width:90px;height:90px;margin:auto auto 18px;
border-radius:50%;
display:flex;align-items:center;justify-content:center;
font-size:38px;color:#fff;
background:linear-gradient(135deg,'.$color1.','.$color2.');
}
h2{font-weight:800;color:'.$color1.';margin-bottom:10px;}
p{color:#666;line-height:1.7;margin-bottom:24px;}
a{
display:inline-block;
padding:12px 26px;
border-radius:14px;
text-decoration:none;
font-weight:700;
color:#fff;
background:linear-gradient(135deg,'.$color1.','.$color2.');
}
</style>
</head>
<body>
<div class="box">
<div class="icon"><i class="bi '.$icon.'"></i></div>
<h2>'.$title.'</h2>
<p>'.$msg.'</p>
<a href="'.$link.'">'.$btn.'</a>
</div>
</body>
</html>';
exit;
}
if (empty($_POST['password']) || empty($_POST['token'])) {
    showMessage("error","Invalid Request","Please try again.");
}

$password = $_POST['password'];
$token    = mysqli_real_escape_string($conn, $_POST['token']);

if (strlen($password) < 6) {
    showMessage(
        "error",
        "Weak Password",
        "Password must be at least 6 characters long.",
        "Go Back",
        "javascript:history.back()"
    );
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$check = mysqli_query($conn, "
SELECT id FROM admins
WHERE reset_token='$token'
AND token_expiry > NOW()
");

if (mysqli_num_rows($check) !== 1) {
   showMessage(
  "error",
  "Link Expired",
  "This password reset link is invalid or has already been used.",
  "Request New Link",
  "admin/admin_forgot_password.php"
  );
  }

$row = mysqli_fetch_assoc($check);  
$id  = $row['id'];

mysqli_query($conn, "
UPDATE admins
SET password='$hashedPassword',
    reset_token=NULL,
    token_expiry=NULL
WHERE id='$id'
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Password Updated</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    padding:15px;
}

.login-box{
    width:390px;
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 20px 55px rgba(0,0,0,.18);
}

.top{
    padding:38px 32px 34px;
    text-align:center;
    position:relative;
    z-index:5;
}

.logo-icon{
    width:92px;
    height:92px;
    margin:0 auto 16px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:38px;
    color:#fff;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 12px 28px rgba(0,0,0,.16);
}

.title{
    font-size:30px;
    font-weight:800;
    color:#0d47a1;
    margin-bottom:8px;
}

.sub{
    font-size:15px;
    color:#666;
    line-height:1.7;
    margin-bottom:28px;
}

.login-btn{
    width:100%;
    height:54px;
    border:none;
    border-radius:14px;
    font-size:18px;
    font-weight:700;
    color:#fff;
    text-decoration:none;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 10px 22px rgba(13,71,161,.22);
    transition:.25s;
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 28px rgba(0,0,0,.18);
    color:#fff;
}

/* waves */
.bottom{
    height:95px;
    overflow:hidden;
}

.bottom svg{
    width:100%;
    height:100%;
    display:block;
}
</style>
</head>

<body>

<div class="login-box">

<div class="top">

<div class="logo-icon">
<i class="bi bi-check-circle-fill"></i>
</div>

<div class="title">PASSWORD UPDATED</div>

<div class="sub">
Your password has been changed successfully.<br>
You can now login using your new password.
</div>

<a href="login.php" class="login-btn">
<i class="bi bi-box-arrow-in-right me-2"></i>
Go to Login
</a>

</div>

<div class="bottom">

<svg viewBox="0 0 390 95" preserveAspectRatio="none">

<path d="M0 30
C60 5,130 55,220 28
C300 8,340 45,390 18
L390 95 L0 95 Z"
fill="rgba(255,75,75,0.55)"/>

<path d="M0 52
C70 88,150 18,240 56
C315 82,345 35,390 58
L390 95 L0 95 Z"
fill="rgba(242,5,27,0.72)"/>

<path d="M0 72
C90 100,180 42,270 74
C330 96,355 56,390 78
L390 95 L0 95 Z"
fill="#c40000"/>

</svg>

</div>

</div>

</body>
</html>