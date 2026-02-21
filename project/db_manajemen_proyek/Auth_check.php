<?php
// Pastikan tidak ada spasi di atas tag <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk mengecek apakah user sudah login
function cekLogin() {
    // SESUAIKAN: Menggunakan 'id_user' sesuai kolom di database kamu
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php?pesan=belum_login");
        exit();
    }
}

// Fungsi khusus untuk halaman yang hanya boleh diakses Admin
function cekAdmin() {
    // Pastikan session sudah ada sebelum dicek role-nya
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: index.php?pesan=akses_ditolak");
        exit();
    }
}
?>