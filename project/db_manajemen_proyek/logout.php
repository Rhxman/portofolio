<?php
session_start(); // Memulai sesi agar bisa dihancurkan

// Menghapus semua data sesi
$_SESSION = array();

// Menghancurkan sesi secara total
session_destroy();

// Mengarahkan kembali ke halaman login dengan pesan sukses
header("Location: login.php?pesan=logout_berhasil");
exit();
?>