<?php

session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #284daaff 100%); }
        .card-login { border-radius: 1.5rem; }
        .form-control-lg { border-radius: 0.75rem; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="bg-white p-5 card-login shadow-lg w-100" style="max-width: 400px;">
        <h2 class="text-3xl font-weight-bold mb-4 text-center text-primary">Login Aplikasi</h2>
        <p class="text-center text-muted mb-4">Silakan masuk untuk mengakses dashboard.</p>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <?= $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="proses_login.php">
            <div class="mb-3">
                <label for="username" class="form-label text-muted">Username:</label>
                <input type="text" id="username" name="username" class="form-control form-control-lg" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label text-muted">Password:</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold" style="background-color: #667eea; border-color: #667eea;">
                <i class="fas fa-sign-in-alt me-2"></i> MASUK
            </button>
        </form>
        
        <p class="text-muted text-center mt-3" style="font-size: 0.75rem;">*Kredensial: admin / 12345</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>