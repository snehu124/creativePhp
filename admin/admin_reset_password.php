<?php
include "../db_config.php";

/* professional error page function */
function showMessage($title,$message,$btn="Back to Login",$link="login.php")
{
echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>'.$title.'</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<style>
body{
margin:0;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:15px;
font-family:Segoe UI,sans-serif;
background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
}
.box{
width:500px;
background:#fff;
border-radius:22px;
padding:38px 30px;
text-align:center;
box-shadow:0 20px 55px rgba(0,0,0,.18);
}
.icon{
width:92px;
height:92px;
margin:0 auto 18px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:38px;
color:#fff;
background:linear-gradient(135deg,#dc3545,#ff4d4d);
box-shadow:0 12px 28px rgba(0,0,0,.16);
}
h2{
font-weight:400;
  font-size:36px;
  margin-bottom:10px;
  background: linear-gradient(to right, #e02121, #2f55a4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-family:"Love Ya Like A Sister", cursive;
}
p{
font-size:15px;
color:#666;
line-height:1.7;
margin-bottom:26px;
}
a{
display:inline-flex;
align-items:center;
justify-content:center;
gap:8px;
height:52px;
padding:0 24px;
border-radius:14px;
font-size:17px;
font-weight:700;
color:#fff;
text-decoration:none;
background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
box-shadow:0 10px 22px rgba(13,71,161,.22);
}
</style>
</head>
<body>

<div class="box">
<div class="icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
<h2>'.$title.'</h2>
<p>'.$message.'</p>
<a href="'.$link.'"><i class="bi bi-arrow-left"></i> '.$btn.'</a>
</div>

</body>
</html>';
exit;
}

/* check token */
if (!isset($_GET['token']) || empty($_GET['token'])) {
    showMessage(
        "Invalid Link",
        "This password reset link is missing or invalid.",
        "Request New Link",
        "admin/admin_forgot_password.php"
    );
}

$token = mysqli_real_escape_string($conn, $_GET['token']);

$q = mysqli_query($conn, "
SELECT id FROM admins
WHERE reset_token='$token'
AND token_expiry > NOW()
");

if (mysqli_num_rows($q) !== 1) {
    showMessage(
        "Link Expired",
        "This password reset link has expired or has already been used.",
        "Request New Link",
        "admin/admin_forgot_password.php"
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Reset Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

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

/* card */
.login-box{
    width:500px;
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 20px 55px rgba(0,0,0,.18);
}

/* top section */
.top{
    padding:38px 32px 34px;
    text-align:center;
    position:relative;
    z-index:5;
}

.logo-icon{
    width:90px;
    height:90px;
    margin:0 auto 14px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:36px;
    color:#fff;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.title{
  font-weight:400;
  font-size:36px;
  margin-bottom:10px;
  background: linear-gradient(to right, #e02121, #2f55a4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-family:"Love Ya Like A Sister", cursive;
}

.sub{
    font-size:14px;
    color:#666;
    margin-bottom:26px;
    line-height:1.6;
}

/* input */
.form-group{
    position:relative;
    margin-bottom:12px;
}

.form-control{
    height:56px;
    border:1px solid #dbe2ef;
    border-radius:14px;
    padding-left:45px;
    padding-right:45px;
    font-size:16px;
    background:#f8fbff;
}

.form-control:focus{
    border-color:#1565c0;
    box-shadow:0 0 0 4px rgba(21,101,192,.08);
}


.left-icon{
    position:absolute;
    left:16px;
    top:28px;            
    transform:translateY(-50%);
    color:#1565c0;
    font-size:18px;
    line-height:1;
    z-index:5;
}

.right-icon{
    position:absolute;
    right:16px;
    top:28px;           
    transform:translateY(-50%);
    color:#888;
    cursor:pointer;
    font-size:18px;
    line-height:1;
    z-index:5;
}

/* hint */
.password-hint{
    font-size:12px;
    color:#8c8c8c;
    margin-top:8px;
    margin-bottom:18px;
    text-align:left;
}

/* button */
.login-btn{
    width:55%;
    height:54px;
    border:none;
    border-radius:14px;
    font-size:18px;
    font-weight:700;
    color:#fff;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 10px 22px rgba(13,71,161,.22);
    transition:.25s;
    margin-top:4px;
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(0,0,0,.18);
}

/* wave section */
.bottom{
    height:165px;
    margin-top:-82px;
    overflow:hidden;
    background:transparent;
    position:relative;
    z-index:1;
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
<i class="bi bi-shield-lock-fill"></i>
</div>

<div class="title">RESET PASSWORD</div>
<div class="sub">
Enter your new password below.<br>
Make it strong and secure.
</div>

<form action="admin_update_password.php" method="POST">

<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

<div class="form-group">
<i class="bi bi-lock-fill left-icon"></i>

<input
type="password"
name="password"
id="password"
class="form-control"
placeholder="Enter New Password"
required
>

<i class="bi bi-eye-slash right-icon" id="togglePassword"></i>

<div class="password-hint">
Password must be at least 6 characters.
</div>
</div>

<button type="submit" class="login-btn">
Update Password
</button>

</form>

</div>

<!-- waves -->
<div class="bottom">

<svg viewBox="0 0 390 170" preserveAspectRatio="none">

<path d="M0 60
C60 20,130 95,220 55
C300 20,340 78,390 42
L390 170 L0 170 Z"
fill="rgba(255,75,75,0.55)"/>

<path d="M0 95
C70 150,150 40,240 92
C315 138,345 58,390 95
L390 170 L0 170 Z"
fill="rgba(242,5,27,0.72)"/>

<path d="M0 130
C90 175,180 78,270 132
C330 170,355 102,390 138
L390 170 L0 170 Z"
fill="#c40000"/>

</svg>

</div>

</div>

<script>
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

togglePassword.addEventListener('click', function () {
    const type = password.type === 'password' ? 'text' : 'password';
    password.type = type;
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});
</script>

</body>
</html>