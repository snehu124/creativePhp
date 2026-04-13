<?php
include "../../db_config.php";
session_start();

$valid = false;
$token = '';

if (isset($_GET['token']) && !empty($_GET['token'])) {

    $token = mysqli_real_escape_string($conn, $_GET['token']);

    $q = mysqli_query($conn, "
      SELECT id FROM students
      WHERE reset_token='$token'
      AND token_expiry > NOW()
    ");

    if (mysqli_num_rows($q) === 1) {
        $valid = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Set Password</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<style>
*{
    box-sizing:border-box;
    overflow-x:hidden;
}

body{
    margin:0;
    min-height:100vh;
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    position:relative;
    font-family:'Poppins',sans-serif;
}

/* Floating circles */
body::before,
body::after{
    content:"";
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.08);
    animation: float 6s infinite ease-in-out;
    z-index:0;
}
body::before{
    width:250px;
    height:250px;
    top:-80px;
    left:-80px;
}
body::after{
    width:200px;
    height:200px;
    bottom:-70px;
    right:-70px;
}

@keyframes float{
    0%,100%{transform:translateY(0px);}
    50%{transform:translateY(20px);}
}

/* Card */
.card-box{
    width:420px;
    background:#fff;
    border-radius:28px;
    padding:45px 35px;
    text-align:center;
    box-shadow:0 35px 70px rgba(0,0,0,0.25);
    position:relative;
    z-index:1;
}

/* Lock Icon */
.lock-icon{
    width:70px;
    height:70px;
    background:#2f55a4;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    margin:0 auto 20px;
}

/* Title */
.card-box h2{
    font-weight:400;
    font-size:36px;
    margin-bottom:10px;
    background: linear-gradient(to right, #e02121, #2f55a4);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    font-family:"Love Ya Like A Sister", cursive;
}

.card-box p{
    font-size:14px;
    color:#666;
    margin-bottom:25px;
}

/* Input Group */
.input-group{
    position:relative;
    margin-bottom:15px;
}

.input-group input{
    width:100%;
    padding:14px 45px 14px 15px;
    border-radius:14px;
    border:1px solid #ddd;
    font-size:14px;
    outline:none;
}

.input-group input:focus{
    border-color:#2f55a4;
}

.eye-icon{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    user-select:none;
    font-size:18px;
}

/* Hint */
.hint{
    font-size:12px;
    color:#999;
    text-align:left;
    margin:5px 0 20px;
}

/* Button */
.btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
    transition:.3s;
}

.btn-primary{
    background:#e02121;
    color:#fff;
}

.btn-primary:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

.btn-danger{
    background:#e02121;
    color:#fff;
}

.btn-danger:hover{
    opacity:.9;
}

/* ===== TOAST ===== */
.toast{
    position:fixed;
    top:20px;
    right:20px;
    background:#e02121;
    color:#fff;
    padding:14px 22px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    font-size:14px;
    opacity:0;
    transform:translateX(120%);
    transition:.4s ease;
    z-index:9999;
}

.toast.show{
    opacity:1;
    transform:translateX(0);
}
</style>
</head>
<body>

<?php if($valid): ?>

<div class="card-box">

    <div class="lock-icon">🔐</div>

    <h2>Set Your Password</h2>

    <p>Enter your new password below. Make sure it's strong and secure.</p>

    <form action="update_password.php" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div class="input-group">
            <input type="password" 
                   name="password" 
                   id="password"
                   placeholder="New Password"
                   required>
            <span class="eye-icon" onclick="togglePassword()" id="eye">🙈</span>
        </div>

        <div class="hint">Password must be at least 6 characters.</div>

        <button type="submit" class="btn btn-primary">
            Set Password
        </button>
    </form>
</div>

<script>
function togglePassword(){
    const input = document.getElementById("password");
    const eye = document.getElementById("eye");

    if(input.type === "password"){
        input.type = "text";
        eye.textContent = "👁️";
    }else{
        input.type = "password";
        eye.textContent = "🙈";
    }
}
</script>

<?php else: ?>

<div class="card-box">

    <lottie-player 
        src="https://assets9.lottiefiles.com/packages/lf20_kcsr6fcp.json"
        background="transparent"
        speed="1"
        style="width:170px;height:170px;margin:0 auto -48px;"
        autoplay loop>
    </lottie-player>

    <h2>Link Expired</h2>

    <p>
        This password link is invalid or has expired.
        Please request a new link.
    </p>

    <button onclick="goBack()" class="btn btn-danger">
        Go Back
    </button>

</div>

<script>
function goBack(){
    window.location.href="forgot_password.php";
}
</script>

<?php endif; ?>

<!-- ===== TOAST MESSAGE ===== -->
<?php if(isset($_SESSION['error'])): ?>
<div id="toast" class="toast show">
    <?= $_SESSION['error']; ?>
</div>

<script>
setTimeout(()=>{
    document.getElementById("toast").classList.remove("show");
},3000);
</script>
<?php unset($_SESSION['error']); endif; ?>

</body>
</html>
