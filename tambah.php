<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$errors = [];
$nama = $email = $telepon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nama"])) {
        $errors['nama'] = "Nama wajib diisi.";
    } else {
        $nama = trim($_POST["nama"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
            $errors['nama'] = "Nama hanya boleh mengandung huruf dan spasi.";
        }
    }
    if (empty($_POST["email"])) {
        $errors['email'] = "Email wajib diisi.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Format email tidak valid.";
        }
    }
    if (empty($_POST["telepon"])) {
        $errors['telepon'] = "Nomor Telepon wajib diisi.";
    } else {
        $telepon = trim($_POST["telepon"]);
        if (!preg_match("/^[0-9\s\+\-]+$/", $telepon)) {
             $errors['telepon'] = "Nomor Telepon hanya boleh mengandung angka, spasi, +, atau -.";
        }
    }
    if (empty($errors)) {
        $new_kontak = [
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon
        ];
        
        $_SESSION['contacts'][] = $new_kontak;
        $_SESSION['success_message'] = "Kontak " . htmlspecialchars($nama) . " berhasil ditambahkan!";
        
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { background-color: #f8f9fa; }</style>
</head>
<body class="p-4">
    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-success text-white text-center rounded-top-3">
                <h2 class="h4 mb-0 fw-bold"><i class="fas fa-user-plus me-2"></i> TAMBAH KONTAK BARU</h2>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-medium">Nama Lengkap:</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($nama); ?>">
                        <div class="text-danger small mt-1"><?= $errors['nama'] ?? ''; ?></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>">
                        <div class="text-danger small mt-1"><?= $errors['email'] ?? ''; ?></div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="telepon" class="form-label fw-medium">Nomor Telepon:</label> <input type="text" id="telepon" name="telepon" class="form-control" value="<?= htmlspecialchars($telepon); ?>">
                        <div class="text-danger small mt-1"><?= $errors['telepon'] ?? ''; ?></div> </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success shadow-sm px-4 fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                        <a href="index.php" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>