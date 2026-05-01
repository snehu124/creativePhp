<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Admin Login</title>

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
}

/* card */
.login-box{
    width:500px ;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 18px 45px rgba(0,0,0,.18);
}

/* top section */
.top{
    padding:38px 32px 50px;;
    text-align:center;
    position:relative;
    z-index:5;
}

.logo{
    width:95px;
    margin-bottom:14px;
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
    font-size:15px;
    color:#666;
    margin-bottom:28px;
}

/* inputs */
.form-group{
    position:relative;
    margin-bottom:18px;
}

.form-control{
    height:52px;
    border:1px solid #dbe2ef;
    border-radius:10px;
    padding-left:42px;
    padding-right:42px;
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

.right-icon{
    position:absolute;
    right:14px;
    top:50%;
    transform:translateY(-50%);
    color:#888;
    cursor:pointer;
}

/* options */
.options{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:6px 0 18px;
    font-size:14px;
}

.options a{
    text-decoration:none;
    color:#ef5350;
    font-weight:600;
}

.login-btn{
    width:44%;
    height:48px;
    margin:0 auto;         
    margin-top:-6px;
    display:block;
    border:none;
    border-radius:28px;
    font-size:18px;
    font-weight:700;
    color:#fff;
    background:linear-gradient(135deg,#0d47a1,#1565c0,#ef5350);
    box-shadow:0 8px 18px rgba(0,0,0,.18);
    position:relative;
    z-index:10;
}
.top form{
    text-align:left;
}

.bottom{
    height:165px;
    margin-top:-108px;
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
.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(0,0,0,.18);
}


</style>
</head>

<body>

<div class="login-box">

    <div class="top">

        <img src="../images/logo.png" class="logo" alt="Logo">

        <div class="title">ADMIN PANEL</div>
        <div class="sub">Secure Control Panel Login</div>

        <form action="login_process.php" method="POST">

            <div class="form-group">
                <i class="bi bi-envelope-fill left-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
            </div>

            <div class="form-group">
                <i class="bi bi-lock-fill left-icon"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                <i class="bi bi-eye-slash right-icon" id="togglePassword"></i>
            </div>

            <div class="options">
                <label><input type="checkbox"> Remember</label>
                <a href="admin_forgot_password.php">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>

        </form>
    </div>

    <!-- Waves -->
    <div class="bottom">

<!-- sirf SVG me colors replace karo -->

<svg viewBox="0 0 390 170" preserveAspectRatio="none">

    <!-- top wave transparent -->
    <path d="M0 60 
             C60 20,130 95,220 55
             C300 20,340 78,390 42
             L390 170 L0 170 Z"
          fill="rgba(255,75,75,0.55)"/>

    <!-- middle wave transparent -->
    <path d="M0 95
             C70 150,150 40,240 92
             C315 138,345 58,390 95
             L390 170 L0 170 Z"
          fill="rgba(242,5,27,0.72)"/>

    <!-- bottom wave same dark -->
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

togglePassword.addEventListener('click', function(){
    const type = password.type === 'password' ? 'text' : 'password';
    password.type = type;
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});
</script>

</body>
</html>