<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id_hapus = $_GET['id'];
    if (isset($_SESSION['contacts'][$id_hapus])) {
        $nama_kontak = $_SESSION['contacts'][$id_hapus]['nama'];
        unset($_SESSION['contacts'][$id_hapus]);
        $_SESSION['contacts'] = array_values($_SESSION['contacts']); 
        $_SESSION['success_message'] = "Kontak " . htmlspecialchars($nama_kontak) . " berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "ID kontak tidak valid!";
    }
    header("Location: index.php"); 
    exit;
}

$success = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
$error = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #e9ecef; }
        .card { border-radius: 1rem; }
        .header-bg { background-color: #667eea; background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 0 0 1rem 1rem; }
    </style>
</head>
<body>
    <div class="header-bg py-4 mb-5 shadow-lg">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="fs-3 fw-bold"><i class="fas fa-address-book me-2"></i> CONTACT MANAGER</h1>
            <div class="d-flex align-items-center">
                <span class="me-3 fs-6 fw-medium">Halo, <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                <a href="logout.php" class="btn btn-light btn-sm shadow-sm">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <?= $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow-lg border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><i class="fas fa-users me-2"></i> Total Kontak</h5>
                        <p class="card-text fs-2"><?= count($_SESSION['contacts']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-flex align-items-stretch">
                 <a href="tambah.php" class="card bg-success text-white shadow-lg border-0 w-100 p-3 d-flex justify-content-center align-items-center text-decoration-none">
                    <i class="fas fa-plus-circle me-3 fs-3"></i>
                    <h5 class="mb-0 fw-bold">TAMBAH KONTAK BARU</h5>
                 </a>
            </div>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-light border-bottom-0 rounded-top-3">
                <h2 class="h5 mb-0 fw-bold text-muted">Data Kontak Anda</h2>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 5%;">No</th>
                                <th scope="col" style="width: 25%;">Nama</th>
                                <th scope="col" style="width: 25%;">Email</th>
                                <th scope="col" style="width: 20%;">Telepon</th>
                                <th scope="col" style="width: 25%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1; 
                            if (!empty($_SESSION['contacts'])):
                                foreach($_SESSION['contacts'] as $id => $kontak): 
                            ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= htmlspecialchars($kontak['nama']); ?></td>
                                <td><?= htmlspecialchars($kontak['email']); ?></td>
                                <td><?= htmlspecialchars($kontak['telepon']); ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $id; ?>" class="btn btn-warning btn-sm me-2 text-white">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <a href="index.php?action=hapus&id=<?= $id; ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin menghapus <?= htmlspecialchars($kontak['nama']); ?>?');">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted fst-italic py-4">Belum ada data kontak yang tersimpan di sesi.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>