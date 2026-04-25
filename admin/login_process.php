<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include __DIR__ . '/../db_config.php'; // safe path

// 🔒 Basic validation
if (!isset($_POST['email'], $_POST['password'])) {
    header("Location: login.php");
    exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

// ✅ Fetch user by email ONLY
$sql = "SELECT id, email, password, role, branch_id FROM admins WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {

    $user = $result->fetch_assoc();
    $dbPassword = $user['password'];

    /**
     * ✅ Allow:
     * 1. Hashed password (password_verify)
     * 2. Normal password (legacy)
     */
    if (
        password_verify($password, $dbPassword) ||
        $password === $dbPassword
    ) {

        // 🔐 Login success
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['branch_id'] = $user['branch_id'];
        $_SESSION['admin_id'] = $user['id'];

        /**
         * 🔁 Auto-upgrade plain password → hash
         */
        if (!password_verify($password, $dbPassword)) {
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            $update = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
            $update->bind_param("si", $newHash, $user['id']);
            $update->execute();
        }

        // 🚀 Role based redirect
        if ($user['role'] === 'super_admin') {
            header("Location: dashboard.php");
        } 
        elseif ($user['role'] === 'branch_admin') {
            header("Location: branch_admin/branch_dashboard.php");
        } 
        else {
            session_destroy();
            echo "<script>alert('Unknown role'); window.location.href='login.php';</script>";
        }

        exit;

    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
        exit;
    }

} else {
    echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
    exit;
}
