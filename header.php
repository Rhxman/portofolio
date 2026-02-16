<?php
// Mencegah spasi di atas agar tidak merusak redirect
require_once 'auth_check.php';

// Menjalankan pengecekan login di setiap halaman yang menggunakan header ini
cekLogin(); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProyekManager - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #4e73df; --bg-light: #f8f9fc; }
        body { background-color: var(--bg-light); font-family: 'Nunito', sans-serif; }
        .navbar { background: white; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .card { border: none; border-radius: 0.75rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .nav-link { font-weight: 600; color: #858796; }
        .nav-link.active { color: var(--primary-color); }
        .navbar-brand { letter-spacing: 0.5px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="index.php">
            <i class="bi bi-kanban-fill me-2 fs-3"></i> ProyekManager
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">Dashboard</a>
                </li>
                <?php if($_SESSION['role'] == 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'tambah_proyek.php') ? 'active' : ''; ?>" href="tambah_proyek.php">Tambah Proyek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'manajemen_user.php') ? 'active' : ''; ?>" href="manajemen_user.php">Pengguna</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block border-end pe-3">
                    <div class="small fw-bold text-dark"><?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></div>
                    <div class="small text-muted" style="font-size: 0.75rem;"><?= $_SESSION['role']; ?></div>
                </div>
                <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>
<div class="container pb-5">