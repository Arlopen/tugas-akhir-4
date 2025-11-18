<?php

session_start();
$username_valid = "admin";
$password_valid = "12345"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $username_valid && $password === $password_valid) {

        $_SESSION['logged_in'] = true; 
        $_SESSION['username'] = $username;
        
        if (!isset($_SESSION['contacts'])) {
            $_SESSION['contacts'] = []; 
        }
        
        $_SESSION['success_message'] = "Selamat datang, " . htmlspecialchars($username) . "!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Username atau Password salah!";
        header("Location: login.php?error=true");
        exit;
    }
}
?>