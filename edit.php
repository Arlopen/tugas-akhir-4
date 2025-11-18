<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_SESSION['contacts'][$_GET['id']])) {
    header("Location: index.php");
    exit;
}

$id_edit = $_GET['id'];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $kontak_saat_ini = $_SESSION['contacts'][$id_edit];
    $nama = $kontak_saat_ini['nama'];
    $email = $kontak_saat_ini['email'];
    $telepon = $kontak_saat_ini['telepon'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nama"])) { $errors['nama'] = "Nama wajib diisi."; } else {
        $nama = trim($_POST["nama"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) { $errors['nama'] = "Nama hanya boleh mengandung huruf dan spasi."; }
    }
    
    if (empty($_POST["email"])) { $errors['email'] = "Email wajib diisi."; } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = "Format email tidak valid."; }
    }
    $telepon = trim($_POST["telepon"]) ?? '';

    if (empty($errors)) {
        $_SESSION['contacts'][$id_edit] = [
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon
        ];
        
        $_SESSION['success_message'] = "Kontak " . htmlspecialchars($nama) . " berhasil diperbarui!";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { background-color: #f8f9fa; }</style>
</head>
<body class="p-4">
    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-warning text-dark text-center rounded-top-3">
                <h2 class="h4 mb-0 fw-bold"><i class="fas fa-edit me-2"></i> EDIT KONTAK</h2>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="edit.php?id=<?= $id_edit; ?>">
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
                        <label for="telepon" class="form-label fw-medium">Telepon (Opsional):</label>
                        <input type="text" id="telepon" name="telepon" class="form-control" value="<?= htmlspecialchars($telepon); ?>">
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-warning shadow-sm fw-bold text-dark px-4">
                            <i class="fas fa-save me-2"></i> Update
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