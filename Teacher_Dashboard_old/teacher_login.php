<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

    $sql = "SELECT * FROM teachers WHERE email = '$email' AND password = '$password' AND status = 'Active'";
    $result = mysqli_query($conn, $sql);
    $teacher = mysqli_fetch_assoc($result);

    if ($teacher) {
        $_SESSION['teacher_id'] = $teacher['id'];
        $_SESSION['teacher_subject'] = $teacher['subject'];

        $teacher_id = $teacher['id'];
        $login_time = date("Y-m-d H:i:s");

        $insertLog = "INSERT INTO teacher_activity_logs (teacher_id, login_time) VALUES ('$teacher_id', '$login_time')";
        mysqli_query($conn, $insertLog);

        $_SESSION['activity_log_id'] = mysqli_insert_id($conn);

        header("Location: teacher_dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials or inactive account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(to right, #f7f7f7, #e2e2e2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      width: 100%;
      display: flex;
      overflow: hidden;
      animation: slideIn 0.6s ease;
    }

    @keyframes slideIn {
      from {
        transform: translateY(30px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .login-left {
      background: #6c63ff;
      color: white;
      padding: 40px 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 40%;
    }

    .login-left i {
      font-size: 4rem;
      margin-bottom: 15px;
    }

    .login-left h2 {
      font-weight: 600;
      text-align: center;
    }

    .login-right {
      padding: 40px 30px;
      width: 60%;
    }

    .form-label {
      font-weight: 500;
      color: #4a00e0;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    .btn-primary {
      border-radius: 10px;
      background-color: #4a00e0;
      border: none;
      padding: 12px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background-color: #5f27cd;
    }

    .form-check-label {
      font-size: 0.9rem;
    }

    .error-message {
      color: red;
      font-size: 0.9rem;
      margin-bottom: 10px;
      text-align: center;
    }

    .footer-text {
      margin-top: 20px;
      font-size: 0.85rem;
      text-align: center;
      color: #888;
    }

    @media (max-width: 768px) {
      .login-card {
        flex-direction: column;
      }

      .login-left, .login-right {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="login-left">
    <i class="bi bi-person-circle"></i>
    <h2>Teacher Login</h2>
  </div>
  <div class="login-right">
    <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="showPassword" onclick="togglePassword()">
        <label class="form-check-label" for="showPassword">
          Show Password
        </label>
      </div>

      <button type="submit" class="btn btn-primary w-100">Let’s Go!</button>
    </form>

    <div class="footer-text mt-3">
       Happy Teaching, Rockstar!
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
    } else {
      passwordInput.type = "password";
    }
  }
</script>

</body>
</html>

