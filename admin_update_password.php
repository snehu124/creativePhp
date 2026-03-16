<?php
include "db_config.php";

if (empty($_POST['password']) || empty($_POST['token'])) {
    die("Invalid request");
}

$password = $_POST['password'];
$token    = mysqli_real_escape_string($conn, $_POST['token']);

if (strlen($password) < 6) {
    die("Password must be at least 6 characters");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$check = mysqli_query($conn, "
  SELECT id FROM admins 
  WHERE reset_token='$token' 
  AND token_expiry > NOW()
");

if (mysqli_num_rows($check) !== 1) {
    die("Invalid or expired token!");
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
  <title>Password Updated</title>
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
      text-align: center;
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
      width: 80px;
      height: 80px;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      margin: 0 auto 20px;
    }

    h3 {
      font-weight: 700;
      margin-bottom: 10px;
      color: #333;
    }

    p {
      font-size: 14px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn-primary {
      background: linear-gradient(to right, #667eea, #764ba2);
      border: none;
      border-radius: 14px;
      padding: 12px;
      font-weight: 600;
      font-size: 15px;
    }
  </style>
</head>

<body>

<div class="card-box">
  <div class="icon-circle">
    ✅
  </div>

  <h3>Password Updated!</h3>
  <p>
    Your password has been successfully updated.  
    You can now login with your new password.
  </p>

  <a href="login.php" class="btn btn-primary w-100">
    Go to Login
  </a>
</div>

</body>
</html>
