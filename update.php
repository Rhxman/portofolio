<?php
include 'koneksi.php';

// Pengaman: pastikan data dikirim lewat POST
if (!isset($_POST['id_penumpang'])) {
    echo "Akses tidak valid";
    exit;
}

$id     = $_POST['id_penumpang'];
$nama   = $_POST['nama'];
$nik    = $_POST['nik'];
$jk     = $_POST['jenis_kelamin'];
$tujuan = $_POST['tujuan'];
$tgl    = $_POST['tanggal_berangkat'];

$query = "UPDATE penumpang SET
            nama='$nama',
            nik='$nik',
            jenis_kelamin='$jk',
            tujuan='$tujuan',
            tanggal_berangkat='$tgl'
          WHERE id_penumpang='$id'";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal update data: " . mysqli_error($conn);
}
?>
