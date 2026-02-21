<?php
require_once 'auth_check.php';
require_once 'Config.php';

// Pastikan hanya user yang sudah login yang bisa akses
cekLogin();

$database = new Config();
$db = $database->getConnection();

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Validasi status agar hanya menerima input yang sesuai ENUM database
    $allowed_status = ['Planning', 'Ongoing', 'Done'];
    
    if (in_array($status, $allowed_status)) {
        $query = "UPDATE proyek SET status = ? WHERE id_proyek = ?";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([$status, $id])) {
            // Kembali ke index dengan pesan sukses
            header("Location: index.php?pesan=status_updated");
            exit();
        } else {
            echo "Gagal memperbarui status.";
        }
    } else {
        echo "Status tidak valid.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>