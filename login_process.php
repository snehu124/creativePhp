<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_config.php'; // adjust path if needed

$email = $_POST['email'];
$password = $_POST['password'];

// Example only: Replace with hashed password logic!
$sql = "SELECT * FROM admins WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    
    $user = $result->fetch_assoc();
    
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_email'] = $email;
    $_SESSION['role'] = $user['role'];
    $_SESSION['branch_id'] = $user['branch_id'];
    
    if($user['role'] === 'super_admin'){
    header("Location: dashboard.php");
} 
elseif ($user['role'] === 'branch_admin') {
        header("Location: branch_admin/branch_dashboard.php");
    }
    else {
        echo "<script>alert('Unknown role'); window.location.href='login.php';</script>";
    }
    
  }  else {
    echo "<script>alert('Invalid login'); window.location.href='login.php';</script>";
}
