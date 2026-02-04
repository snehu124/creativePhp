<?php
session_start();
include "db_config.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $student = mysqli_fetch_assoc($result);
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_email'] = $student['email']; 
        $_SESSION['student_name'] = $student['name'];
        header("Location: student_dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #dfe9f3, #ffffff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-container {
      max-width: 900px;
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .login-image {
      background: url('https://img.freepik.com/free-vector/students-study-campus-park-flat-vector-illustration_74855-8605.jpg?w=826&t=st=1688312716~exp=1688313316~hmac=7a0b95d30a56630f3d7c013f1e38921aeb43b00e112d9a7ad0b4e30555fd5f65') center/cover no-repeat;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #6c63ff;
    }
    .show-password {
      position: absolute;
      right: 10px;
      top: 9px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container login-container d-flex">
    <div class="row w-100">
      <div class="col-md-6 login-image d-none d-md-block"></div>

      <div class="col-md-6 p-5">
        <h3 class="text-center mb-4">Student Login</h3>

        <?php if (isset($error) && $error): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
          </div>
          <div class="mb-3 position-relative">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <span class="show-password" onclick="togglePassword()">
              👁️
            </span>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3 mb-0"><small>Forgot your password? <a href="#">Reset here</a></small></p>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }
  </script>
</body>
</html>
