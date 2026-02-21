<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Penumpang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Data Penumpang Tiket</h3>

    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Data</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM penumpang");
        while ($row = mysqli_fetch_assoc($data)) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['nik'] ?></td>
                <td><?= $row['jenis_kelamin'] ?></td>
                <td><?= $row['tujuan'] ?></td>
                <td><?= $row['tanggal_berangkat'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_penumpang'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= $row['id_penumpang'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus data?')">
                       Hapus
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
