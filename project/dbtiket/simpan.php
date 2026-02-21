<?php
include 'koneksi.php';

// Pengaman: pastikan form dikirim
if (!isset($_POST['nama'])) {
    echo "Akses tidak valid";
    exit;
}

// Ambil data dari form
$nama   = $_POST['nama'];
$nik    = $_POST['nik'];
$jk     = $_POST['jenis_kelamin'];
$tujuan = $_POST['tujuan'];
$tgl    = $_POST['tanggal_berangkat'];

// Query simpan data
$query = "INSERT INTO penumpang 
          (nama, nik, jenis_kelamin, tujuan, tanggal_berangkat)
          VALUES
          ('$nama', '$nik', '$jk', '$tujuan', '$tgl')";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}
?>
