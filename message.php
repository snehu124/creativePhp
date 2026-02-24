<?php
session_start();

$type    = $_SESSION['msg_type'] ?? 'info';   // success | error | info
$title   = $_SESSION['msg_title'] ?? 'Message';
$message = $_SESSION['msg_text'] ?? 'Something happened.';

unset($_SESSION['msg_type']);
unset($_SESSION['msg_title']);
unset($_SESSION['msg_text']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

.message-card{
    max-width:420px;
    width:100%;
    background:white;
    padding:35px 30px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 25px 50px rgba(0,0,0,0.25);
    animation:fade 0.5s ease;
}

@keyframes fade{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.icon{
    width:70px;
    height:70px;
    border-radius:50%;
    margin:0 auto 20px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
    color:white;
    font-weight:700;
}

.message-card h3{
      font-weight: 400;
      font-size: 36px;
      margin-bottom: 10px;
      background: linear-gradient(to right, #e02121, #2f55a4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family:"Love Ya Like A Sister", cursive;
}
.success{ background:#28a745; }
.error{ background:#dc3545; }
.info{ background:#0d6efd; }

.btn-main{
    background:#e53935;
    color:white;
    border:none;
    border-radius:12px;
    padding:12px 25px;
    font-weight:600;
    transition:0.3s;
    text-decoration: none;  
    display: inline-block;   
}


.btn-main:hover{
  background:#1e3c72;
  transform:translateY(-2px);
  text-decoration: none;
  color: white;
}

</style>
</head>

<body>

<div class="message-card">

    <div class="icon <?= $type ?>">
        <?php
        if($type=='success') echo "✔";
        elseif($type=='error') echo "✖";
        else echo "!";
        ?>
    </div>

    <h3><?= $title ?></h3>

    <p class="mt-3 text-muted">
        <?= $message ?>
    </p>

  <?php
    $backLink = $_SESSION['msg_back'] ?? 'teacher_login.php';
    unset($_SESSION['msg_back']);
    ?>

    <a href="<?= htmlspecialchars($backLink) ?>" class="btn-main">
        Go Back
    </a>

</div>

</body>
</html>
