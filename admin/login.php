<?php
session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
}

.login-card {
    width: 360px;
    background: rgba(255,255,255,0.95);
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.login-card h4 {
    font-weight: 700;
    margin-bottom: 20px;
}

.form-group {
    position: relative;
}

.form-control {
    height: 48px;
    border-radius: 10px;
    padding-left: 42px;
    padding-right: 42px;
}

.form-control:focus {
    box-shadow: none;
    border-color: #4f46e5;
}

.left-icon {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #6b7280;
}

.right-icon {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6b7280;
}

.btn-primary {
    height: 48px;
    border-radius: 12px;
    font-weight: 600;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none;
}

.btn-primary:hover {
    opacity: 0.9;
}

</style>
</head>

<body>

<div class="login-card">
    <h4 class="text-center">Admin Login</h4>

    <form action="login_process.php" method="POST">

        <!-- Email -->
        <div class="mb-3 form-group">
            <i class="bi bi-envelope left-icon"></i>
            <input type="email" name="email" class="form-control" placeholder="Email address" required>
        </div>

        <!-- Password with show/hide -->
        <div class="mb-3 form-group">
            <i class="bi bi-lock left-icon"></i>
            <input 
                type="password" 
                name="password" 
                id="password"
                class="form-control" 
                placeholder="Password" 
                required
            >
            <i class="bi bi-eye-slash right-icon" id="togglePassword"></i>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">
            Login
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="admin_forgot_password.php" class="text-decoration-none">
            Forgot your password?
        </a>
    </div>
</div>

<!-- JS (minimal & clean) -->
<script>
const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');

togglePassword.addEventListener('click', function () {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});
</script>

</body>
</html>
