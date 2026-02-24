<?php
include "../../db_config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../PHPMailer/Exception.php';
require_once __DIR__ . '/../../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer/SMTP.php';

$env = parse_ini_file(__DIR__ . '/../../.env');
$baseUrl = rtrim($env['APP_URL'], '/');

$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');

$status = "error";
$title = "Whoops!!";
$message = "";

$q = mysqli_query($conn,"SELECT first_name,email FROM students WHERE email='$email'");

if(mysqli_num_rows($q) === 1){

    $user = mysqli_fetch_assoc($q);
    $token = bin2hex(random_bytes(32));

    mysqli_query($conn,"
        UPDATE students
        SET reset_token='$token',
            token_expiry = DATE_ADD(NOW(),INTERVAL 15 MINUTE)
        WHERE email='{$user['email']}'
    ");

    $resetLink = $baseUrl."/Student_dashboard/auth/reset_password.php?token=$token";

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = $env['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $env['MAIL_USER'];
        $mail->Password = $env['MAIL_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $env['MAIL_PORT'];

        $mail->setFrom($env['MAIL_USER'],'Creative Theka');
        $mail->addAddress($user['email']);
        $mail->Subject = 'Password Reset Link';
        $mail->Body = "Click below link to reset password:\n$resetLink";
        $mail->send();

        $status = "success";
        $title = "Success!";
        $message = "A reset link has been sent to";

    }catch(Exception $e){
        $status="error";
        $title="Whoops!!";
        $message="Failed to send reset link for";
    }

}else{
    $status="error";
    $title="Whoops!!";
    $message="the e-mail address";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Status</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<style>

/* ================= Desktop ================= */

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

.overlay{
    position:relative;
    z-index:2;
}

.modal-card{
    width:430px;
    border-radius:24px;
    overflow:hidden;
    background:#f4f5f9;
    box-shadow:0 30px 70px rgba(0,0,0,0.35);
    animation:popup .35s ease;
    position:relative;
}

@keyframes popup{
    from{transform:scale(.9);opacity:0;}
    to{transform:scale(1);opacity:1;}
}

.modal-top{
    padding:45px 30px 35px;
    background:url(../../images/resent1-bg.avif) no-repeat center;
    background-size:cover;
    text-align:center;
    position:relative;
}

.close-btn{
    position:absolute;
    right:18px;
    top:18px;
    width:42px;
    height:42px;
    background:#dcdde3;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    cursor:pointer;
}

.modal-content{
    background:#ffffff;
    padding:40px 30px;
    text-align:center;
}

.modal-content h2{
    font-weight:400;
    font-size:36px;
    margin-bottom:10px;
    background: linear-gradient(to right, #e02121, #2f55a4);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    font-family:"Love Ya Like A Sister", cursive;
}

.modal-content p{
    font-size:14px;
    color:#666;
    margin-bottom:30px;
    line-height:1.6;
}

.email-highlight{
    color:#2f55a4;
    font-weight:600;
}

.modal-content button{
    width:100%;
    background:#e02121;
    color:#fff;
    border:none;
    padding:15px;
    border-radius:10px;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
    box-shadow:0 8px 18px rgba(11,28,72,0.25);
}
.modal-content button:hover{
    opacity:.9;
}


/* ================= MOBILE ================= */

@media (max-width:600px){

    body{
        padding:0;
        margin:0;
        display:block;
        min-height:100vh;
    }

    .overlay{
        width:100%;
        padding:20px 15px;
        box-sizing:border-box;
        display:flex;
        justify-content:center;
        align-items:center;
        min-height:100vh;
    }

    .modal-card{
        width:100%;
        max-width:100%;
        border-radius:28px;
    }

    .modal-top{
        padding:35px 20px 25px;
    }

    .modal-content{
        padding:30px 20px;
    }

    .modal-content h2{
        font-size:28px;
    }

    .modal-content p{
        font-size:14px;
    }

    .modal-content button{
        padding:14px;
        font-size:15px;
    }

    .close-btn{
        width:36px;
        height:36px;
        font-size:15px;
    }

    lottie-player{
        width:140px !important;
        height:140px !important;
    }
}

</style>
</head>
<body>

<div class="overlay">
    <div class="modal-card">

        <div class="modal-top">
            <div class="close-btn" onclick="goBack()">✕</div>

            <lottie-player 
                src="wired-lineal-177-envelope-send-hover-flying.json"
                background="transparent"
                speed="1"
                style="width:170px; height:170px; margin:auto;"
                autoplay
                loop>
            </lottie-player>
        </div>

        <div class="modal-content">
            <h2><?= $title ?></h2>

            <p>
                <?= $message ?>
                <span class="email-highlight">
                    <?= htmlspecialchars($email) ?>
                </span>
                <?= $status == "success" ? "" : "is not registered in our system." ?>
            </p>

            <button onclick="goBack()">OK</button>
        </div>

    </div>
</div>

<script>
function goBack(){
    window.location.href="forgot_password.php";
}
</script>

</body>
</html>
