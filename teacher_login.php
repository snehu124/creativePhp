<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

    $sql = "SELECT * FROM teachers WHERE email = '$email' AND status = 'Active'";
    $result = mysqli_query($conn, $sql);
    $teacher = mysqli_fetch_assoc($result);

    if ($teacher) {

        // ✅ Plain password OR hashed password dono allow
        if (
            $teacher['password'] === $password || 
            password_verify($password, $teacher['password'])
        ) {
            $_SESSION['teacher_id'] = $teacher['id'];
            $_SESSION['teacher_subject'] = $teacher['subject'];

            $teacher_id = $teacher['id'];
            $login_time = date("Y-m-d H:i:s");

            $insertLog = "INSERT INTO teacher_activity_logs (teacher_id, login_time)
                          VALUES ('$teacher_id', '$login_time')";
            mysqli_query($conn, $insertLog);

            $_SESSION['activity_log_id'] = mysqli_insert_id($conn);

            header("Location: teacher_dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials or inactive account.";
        }

    } else {
        $error = "Invalid credentials or inactive account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Login | Achiever's Castle</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
    height:100vh;  
    overflow:hidden; 
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0; 
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

/* Main Container */
.login-container{
    margin:20px;
    width:100%;
    max-width:900px;
    max-height:90vh;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.15);
    border-radius:25px;
    box-shadow:0 25px 60px rgba(0,0,0,0.3);
    display:flex;
    overflow:hidden;
    animation: fadeIn 0.8s ease;
    z-index:1;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(40px);}
    to{opacity:1; transform:translateY(0);}
}

/* LEFT SIDE */
.left-side{
    flex:1;
    background:linear-gradient(160deg,#e53935,#b71c1c);
    color:white;
    padding:50px 30px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
}

.left-side img{
    width:220px;
    max-width:100%;
    margin-bottom:10px;
    filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));
}

.left-side h2{
    font-weight:700;
    letter-spacing:1px;
}

.left-side p{
    font-size:14px;
    opacity:0.9;
}

/* RIGHT SIDE */
.right-side{
    flex:1;
    background:white;
    padding:50px 40px;
}

.form-label{
    font-weight:600;
    color:#1e3c72;
}

.form-control{
    border-radius:12px;
    padding:12px;
    transition:0.3s;
}

.form-control:focus{
    border-color:#e53935;
    box-shadow:0 0 0 0.2rem rgba(229,57,53,0.25);
}

.btn-login{
    background:#1e3c72;
    color:white;
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    transition:0.3s;
}

.btn-login:hover{
    background:#e53935;
    transform:translateY(-2px);
}

.error-message{
    background:#ffe5e5;
    color:#b71c1c;
    padding:10px;
    border-radius:8px;
    text-align:center;
    margin-bottom:15px;
}

.footer-text{
    text-align:center;
    margin-top:20px;
    font-size:13px;
    color:#777;
}

  .right-side h3{
        font-weight: 400;
        font-size: 30px;
        margin-bottom: 29px !important;
        background: linear-gradient(to right, #e02121, #2f55a4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-family:"Love Ya Like A Sister", cursive;
    }
/* =====================
   TABLET RESPONSIVE
===================== */
@media (max-width: 992px){

    .login-container{
        max-width:750px;
    }

    .left-side img{
        width:180px;
    }

    .right-side{
        padding:40px 30px;
    }
}

/* =====================
   MOBILE RESPONSIVE
===================== */
@media (max-width: 768px){

    body{
        align-items:flex-start;
        justify-content:flex-start;
    }

    .login-container{
        width:100%;
        max-width:420px;
        max-height:none;
        margin:auto;
        flex-direction: column;
        border-radius:18px;
    }

    /* LEFT SIDE */
    .left-side{
        padding:30px 20px;
        min-height:200px;
    }

    .left-side img{
        width:130px;
        margin-bottom:5px;
    }

    .left-side h2{
        font-size:28px !important;
        line-height:1.2;
    }

    .left-side p{
        font-size:13px;
    }

    /* RIGHT SIDE */
    .right-side{
        padding:25px 20px;
    }

    .right-side h3{
        font-size:24px;
        text-align:center;
        margin-bottom:20px !important;
    }

    .btn-login{
        font-size:15px;
        padding:11px;
    }

    .footer-text{
        font-size:12px;
    }

    /* Hide background bubbles */
    body::before,
    body::after{
        display:none;
    }
}


/* =====================
   SMALL MOBILE
===================== */
@media (max-width: 480px){

    .login-container{
        border-radius:14px;
    }

    .left-side{
        padding:25px 15px;
    }

    .left-side img{
        width:110px;
    }

    .left-side h2{
        font-size:24px !important;
    }

    .right-side{
        padding:20px 15px;
    }

    .form-control{
        padding:10px;
        font-size:14px;
    }

    .btn-login{
        font-size:14px;
        padding:10px;
    }
}

</style>

</head>
<body>

<div class="login-container">

    <!-- LEFT SIDE -->
    <div class="left-side">
        <img src="images/logo3.png" alt="Achiever's Castle Logo">
        <h2 style="font-family: 'Love Ya Like A Sister', cursive; font-weight:400;font-size:44px; ">Welcome Teacher</h2>
        <p>Empowering young minds.<br>Inspiring future leaders.</p>
        <i class="bi bi-stars" style="font-size:40px;margin-top:15px;"></i>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-side">

        <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

        <h3 class="mb-4">Login to Your Dashboard</h3>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

           <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Show Password -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" onclick="togglePassword()" id="showPass">
                <label class="form-check-label" for="showPass">
                    Show Password
                </label>
            </div>

            <!-- Forgot Password -->
            <a href="teacher_forgot_password.php">
                Forgot Password?
            </a>

        </div>
            <button type="submit" class="btn btn-login w-100">Login Now</button>
        </form>

        <div class="footer-text">
            © <?php echo date("Y"); ?> Achiever's Castle | Happy Teaching 🌟
        </div>

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
