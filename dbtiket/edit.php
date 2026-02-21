<?php
include 'koneksi.php';

// Mengambil ID dari URL
$id = $_GET['id'];

// Mengambil data penumpang berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM penumpang WHERE id_penumpang='$id'");
$d = mysqli_fetch_array($query);

// Jika data tidak ditemukan, kembali ke index
if (!$d) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penumpang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .card-header { background-color: #007bff; color: white; border-radius: 15px 15px 0 0 !important; font-weight: bold; }
        .btn-update { background-color: #007bff; color: white; transition: 0.3s; }
        .btn-update:hover { background-color: #0056b3; color: white; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center py-3">
                    <h4 class="mb-0">Edit Data Penumpang</h4>
                </div>
                <div class="card-body p-4">
                    
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id_penumpang" value="<?php echo $d['id_penumpang']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $d['nama']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">NIK</label>
                            <input type="text" name="nik" class="form-control" value="<?php echo $d['nik']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki" <?php echo ($d['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php echo ($d['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" value="<?php echo $d['tujuan']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Berangkat</label>
                            <input type="date" name="tanggal_berangkat" class="form-control" value="<?php echo $d['tanggal_berangkat']; ?>" required>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-update btn-lg">Simpan Perubahan</button>
                            <a href="index.php" class="btn btn-light">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
            <p class="text-center text-muted mt-3"><small>&copy; 2026 dbtiket System</small></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>