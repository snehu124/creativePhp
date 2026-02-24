<?php
include "db_config.php";

session_start();

if (!isset($_GET['token']) || empty($_GET['token'])) {

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Invalid Link';
    $_SESSION['msg_text']  = 'This password reset link is invalid or has expired.';

    header("Location: message.php");
    exit;
}

$token = mysqli_real_escape_string($conn, $_GET['token']);

$q = mysqli_query($conn, "
  SELECT id FROM teachers
  WHERE reset_token='$token'
  AND token_expiry > NOW()
");

if (mysqli_num_rows($q) !== 1) {

    $_SESSION['msg_type']  = 'error';
    $_SESSION['msg_title'] = 'Link Expired';
    $_SESSION['msg_text']  = 'This reset link has already been used or has expired.';

    header("Location: message.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
 <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
  
  <style>
*{
    font-family:'Poppins',sans-serif;
    box-sizing: border-box;
}

html, body{
    width:100%;
    overflow-x:hidden;
}

body{
    margin:0;
    min-height:100vh;
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow-x:hidden;
    padding:20px;
    position:relative;
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

    .card-box {
      max-width: 420px;
      width: 100%;
      background: #fff;
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 25px 50px rgba(0,0,0,0.25);
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .icon-circle {
      width: 70px;
      height: 70px;
      background: linear-gradient(to right,#1e3c72,#2a5298);
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      margin: 0 auto 20px;
    }

    .card-box h3 {
      font-weight: 700;
      margin-bottom: 10px;
      color: #333;
    }

      .card-box p {
      color: #666;
      font-size: 14px;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 14px;
      padding: 12px 15px;
      font-size: 15px;
    }

    .btn-primary {
      background:#e53935;
      color:white;
      border:none;
      border-radius:12px;
      padding:12px;
      font-weight:600;
      transition:0.3s;
    }

    .btn-primary:hover {
    background:#1e3c72;
    transform:translateY(-2px);
    }

    .password-hint {
      font-size: 12px;
      color: #999;
      margin-top: 6px;
    }
      .card-box h3 {
      font-weight: 400;
      font-size: 36px;
      margin-bottom: 10px;
      background: linear-gradient(to right, #e02121, #2f55a4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family:"Love Ya Like A Sister", cursive;
      display: flex;
      justify-content: center;
    }
  </style>
</head>

<body>

<div class="card-box">
  <div class="icon-circle">
    🔐
  </div>

  <h3>Reset Password</h3>
  <p>
    Enter your new password below.  
    Make sure it’s strong and secure.
  </p>

  <form action="teacher_update_password.php" method="POST">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

  <div class="mb-3 position-relative">
    <input 
      type="password" 
      name="password" 
      id="password"
      class="form-control" 
      placeholder="New Password" 
      required
    >

    <!-- 👁️ Show / Hide -->
    <span 
      onclick="togglePassword()" 
      style="
        position:absolute;
        right:15px;
        top:32%;
        transform:translateY(-50%);
        cursor:pointer;
        user-select:none;
      "
      id="eyeIcon"
    >
      🙈
    </span>

    <div class="password-hint">
      Password must be at least 6 characters.
    </div>
  </div>

  <button type="submit" class="btn btn-primary w-100">
    Update Password
  </button>
</form>
</div>

<script>
  function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
      input.type = "text";
      icon.textContent = "👁️";
    } else {
      input.type = "password";
      icon.textContent = "🙈";
    }
  }
</script>

</body>
</html>
