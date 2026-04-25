<?php
session_start();
include "../db_config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {

        $student = mysqli_fetch_assoc($result);

        // ❌ WRONG PASSWORD
        if (!(password_verify($password, $student['password']) || $password === $student['password'])) {
            $error = "Invalid Email or Password!";
        }

        // ❌ INACTIVE ACCOUNT
        elseif ($student['status'] == 0) {
            $error = "Account is disabled. Contact admin.";
        }

        // ✅ SUCCESS LOGIN
        else {
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_email'] = $student['email'];
            $_SESSION['student_name'] = $student['first_name']; // 👈 fix name

            header("Location: student_dashboard.php");
            exit();
        }

    } else {
        $error = "Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Student Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<style>
*{ box-sizing:border-box; margin:0; padding:0; }

body{
  font-family:'Poppins',sans-serif;
  min-height:100vh;
  display:flex;
  background:#f3f3f3;
}

/* LEFT SIDE */
.left-side{
  width:40%;
  display:flex;
  justify-content:center;
  align-items:center;
  position:relative;
  z-index:5; /* above right side */
}

.form-text{
  font-weight:400;
  font-size:36px;
  margin-bottom:10px;
  background: linear-gradient(to right, #e02121, #2f55a4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-family:"Love Ya Like A Sister", cursive;
}

/* 👇 OVERLAP ADDED HERE */
.form-card {
    width:558px;
    background:#ffffff;
    padding:30px 38px;
    border-radius:28px;
    box-shadow:0 30px 80px rgba(0, 0, 0, 0.25);
    position:relative;
    z-index:10;
    margin-right: -335px;
}

.logo{
  text-align:center;
  margin-bottom:15px;
}

.logo img{
  width:110px;
}

.form-card h2{
  text-align:center;
  margin-bottom:30px;
  font-weight:400;
}

.form-card input{
  width:100%;
  padding:18px 24px;
  margin-bottom:22px;
  border-radius:25px;
  border:1px solid #d0d7de;
  background:#eef2f6;
  font-size:14px;
}

.form-card input:focus{
  outline:none;
  border-color:#e02121;
  background:#fff;
  box-shadow:0 0 0 3px rgba(198,66,57,0.2);
}

.password-wrapper{ position:relative; }

.show-password{
  position:absolute;
  right:24px;
  top:50%;
  transform:translateY(-50%);
  cursor:pointer;
}

/* BUTTON */
.form-card button{
  width:100%;
  padding:18px;
  border:none;
  border-radius:30px;
  background:#e02121;
  color:#fff;
  font-weight:600;
  font-size:16px;
  cursor:pointer;
  transition:0.3s;
}

.form-card button:hover{ background:#2ea82e; }

.error{
  color:red;
  text-align:center;
  margin-bottom:15px;
}

.forgot{
  text-align:center;
  margin-top:20px;
}

/* RIGHT SIDE */
.right-side{
  width:60%;
  position:relative;
  overflow:hidden;
  z-index:1;
}

.green-shape{
  position:absolute;
  right:-400px;
  top:50%;
  transform:translateY(-50%);
  width:1200px;
  height:1200px;
  border-radius:50%;
  background:#2f55a4;
}

.bg-design{
  position:absolute;
  width:100%;
  height:100%;
  object-fit:cover;
  opacity:0.12;
}

.girl-img{
  position:absolute;
  right:140px;
  top:50%;
  transform:translateY(-45%);
  width:438px;
  z-index:2;
}

/* MOBILE */
@media(max-width:900px){

  body{
    flex-direction:column;
    background:#2f55a4;
    padding:20px 15px;
  }

  .right-side{ display:none; }

  .left-side{
    width:100%;
    align-items:center;
    justify-content:center;
  }

  .form-card{
    width:100%;
    max-width:420px;
    margin:0 auto; /* remove overlap */
    padding:30px 25px;
  }

  .form-text{
    font-size:28px;
    text-align:center;
  }

}
</style>
</head>

<body>

<div class="left-side">
  <div class="form-card">

    <div class="logo">
      <img src="../images/logo.png" alt="Brand Logo">
    </div>

    <h2 class="form-text">Student Login</h2>

    <?php if (!empty($error)) : ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" id="loginForm">
      <input type="email" name="email" placeholder="Enter Email" required>

      <div class="password-wrapper">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span class="show-password" onclick="togglePassword()" id="toggleIcon">🙈</span>
      </div>

      <button type="submit" id="loginBtn">
        <span id="btnText">Login</span>
      </button>
    </form>

    <div class="forgot">
      Forgot your password?
      <a href="./auth/forgot_password.php">Reset here</a>
    </div>

  </div>
</div>

<div class="right-side">
  <div class="green-shape">
      <img src="../images/bg-design (2).png" class="bg-design">
  </div>
  <img src="../images/girl-pencil.png" class="girl-img">
</div>

<script>
function togglePassword(){
  const pass = document.getElementById("password");
  const icon = document.getElementById("toggleIcon");

  if(pass.type === "password"){
    pass.type = "text";
    icon.innerHTML = "🧐";
  }else{
    pass.type = "password";
    icon.innerHTML = "🙈";
  }
}

const form = document.getElementById("loginForm");
const btn = document.getElementById("loginBtn");
const btnText = document.getElementById("btnText");

form.addEventListener("submit", function(){
  btn.disabled = true;
  btnText.innerText = "Logging in...";
});
</script>

</body>
</html>