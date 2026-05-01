<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Forgot Password</title>

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

/* main box */
.login-box{
    width:500px;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 18px 45px rgba(0,0,0,.18);
}

/* top area */
.top{
    padding:35px 32px 22px;
    text-align:center;
    position:relative;
    z-index:5;
}

.icon-circle{
    width:90px;
    height:90px;
    margin:0 auto 15px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:38px;
    color:#fff;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 12px 24px rgba(0,0,0,.18);
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
    line-height:1.5;
    margin-bottom:26px;
}

/* input */
.form-group{
    position:relative;
    margin-bottom:18px;
}

.form-control{
    height:52px;
    border:1px solid #dbe2ef;
    border-radius:10px;
    padding-left:42px;
    font-size:15px;
    background:#f8fbff;
}

.form-control:focus{
    border-color:#1565c0;
    box-shadow:0 0 0 4px rgba(21,101,192,.08);
}

.left-icon{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#1565c0;
    font-size:17px;
}

/* button */
.login-btn{
    width:51%;
    height:48px;
    border:none;
    border-radius:28px;
    font-size:17px;
    font-weight:700;
    color:#fff;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 8px 18px rgba(0,0,0,.18);
    transition:.25s;
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(0,0,0,.18);
}

/* back */
.back-link{
    margin-top:18px;
    font-size:14px;
}

.back-link a{
    text-decoration:none;
    color:#ef5350;
    font-weight:700;
}

/* wave area */
.bottom{
    height:165px;
    margin-top:-78px;
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

        <div class="icon-circle">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="title">RESET PASSWORD</div>

        <div class="sub">
            Enter your registered email address.<br>
            We’ll send you a reset link.
        </div>

        <form action="admin_send_reset_link.php" method="POST">

            <div class="form-group">
                <i class="bi bi-envelope-fill left-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
            </div>

            <button type="submit" class="login-btn">
                Send Reset Link
            </button>

        </form>

        <div class="back-link">
            <a href="login.php">← Back to Login</a>
        </div>

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

</body>
</html>