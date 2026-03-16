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

  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea, #764ba2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
      padding: 20px;
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
      background: linear-gradient(to right, #667eea, #764ba2);
      border: none;
      border-radius: 14px;
      padding: 12px;
      font-weight: 600;
      font-size: 15px;
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
      background: linear-gradient(to right, #667eea, #764ba2);
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      margin: 0 auto 20px;
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

  <form action="admin_send_reset_link.php" method="POST">
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
    <a href="login.php">← Back to Login</a>
  </div>
</div>

</body>
</html>