<?php
require_once 'auth_check.php';
require_once 'Config.php';

cekLogin();
cekAdmin(); // Hanya Admin yang boleh menghapus proyek

$database = new Config();
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM proyek WHERE id_proyek = ?";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$id])) {
        header("Location: index.php?pesan=hapus_berhasil");
        exit();
    } else {
        echo "Gagal menghapus proyek.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>