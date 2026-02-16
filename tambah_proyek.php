<?php
require_once 'auth_check.php';
require_once 'Config.php';
require_once 'Proyek.php';

cekLogin();
cekAdmin(); 

$database = new Config();
$db = $database->getConnection();
$proyek = new Proyek($db);

// Ambil daftar user dengan role 'User' untuk dropdown penugasan
$queryUser = "SELECT id_user, username FROM users WHERE role = 'User'";
$stmtUser = $db->prepare($queryUser);
$stmtUser->execute();

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama_proyek']);
    $desc = htmlspecialchars($_POST['deskripsi']);
    
    // Perbaikan: Pastikan id_user bernilai NULL jika tidak dipilih untuk mencegah error SQL
    $id_user = !empty($_POST['id_user']) ? $_POST['id_user'] : null; 
    
    $tgl  = $_POST['tanggal_mulai'];
    $status = $_POST['status'];

    // Menjalankan fungsi create dengan parameter lengkap
    if ($proyek->create($nama, $desc, $id_user, $tgl, $status)) {
        header("Location: index.php?pesan=berhasil");
        exit();
    } else {
        $error = "Gagal menyimpan data proyek. Pastikan semua data valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek - ProyekManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-form { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); background: #fff; }
        .form-label { font-weight: 600; color: #495057; }
        .btn-primary { border-radius: 8px; padding: 10px; transition: 0.3s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tambah Proyek</li>
                </ol>
            </nav>

            <div class="card card-form p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-plus-circle-fill text-primary" style="font-size: 3.5rem;"></i>
                        <h2 class="fw-bold mt-3 text-dark">Buat Proyek Baru</h2>
                        <p class="text-muted">Tentukan target dan pilih penanggung jawab tim.</p>
                    </div>
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="mt-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Proyek</label>
                            <input type="text" name="nama_proyek" class="form-control form-control-lg border-2 shadow-sm" placeholder="Contoh: Website E-Commerce" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control border-2 shadow-sm" rows="3" placeholder="Jelaskan tujuan proyek..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penanggung Jawab (Anggota Tim)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-2 border-end-0 text-muted"><i class="bi bi-person-fill"></i></span>
                                <select name="id_user" class="form-select border-2 shadow-sm" required>
                                    <option value="" disabled selected>-- Pilih Anggota --</option>
                                    <?php while ($user = $stmtUser->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $user['id_user']; ?>"><?= htmlspecialchars($user['username']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control border-2 shadow-sm" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Awal</label>
                                <select name="status" class="form-select border-2 shadow-sm">
                                    <option value="Planning">Planning</option>
                                    <option value="Ongoing">Ongoing</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary fw-bold fs-5 shadow-sm">
                                <i class="bi bi-save2 me-2"></i>Simpan Proyek
                            </button>
                            <a href="index.php" class="btn btn-light border fw-semibold py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>