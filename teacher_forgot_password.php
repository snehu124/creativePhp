<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
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
    height:100%;
    margin:0;
    padding:0;
    overflow:hidden;
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
    .back-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }

    .back-link a {
      text-decoration: none;
      font-weight: 600;
      color: #667eea;
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
      font-weight: 400;
      font-size: 36px;
      margin-bottom: 10px;
      background: linear-gradient(to right, #e02121, #2f55a4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family:"Love Ya Like A Sister", cursive;
    }
  </style>
</head>

<body>

<div class="card-box">
  <div class="icon-circle">
    🔐
  </div>

  <h3 class="text-center">Forgot Password?</h3>
  <p class="text-center">
     Enter your registered email address.  
  We’ll send you a password reset link.
  </p>

  <form action="teacher_send_reset_link.php" method="POST">
    <div class="mb-3">
      <input 
        type="email" 
        name="email" 
        class="form-control" 
        placeholder="Email Address" 
        required
      >
    </div>

    <button type="submit" class="btn btn-primary w-100">
      Send Reset Link
    </button>
  </form>

  <div class="back-link">
    <a href="teacher_login.php">← Back to Login</a>
  </div>
</div>

</body>
</html>