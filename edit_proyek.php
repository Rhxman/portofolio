<?php
require_once 'auth_check.php';
require_once 'Config.php';
require_once 'Proyek.php'; // Pastikan class Proyek dipanggil

cekLogin();
cekAdmin();

// Inisialisasi Database dan Objek
$database = new Config();
$db = $database->getConnection();
$proyekObj = new Proyek($db); // Menggunakan class Proyek agar codingan lebih rapi

// 1. Ambil daftar anggota tim (User) untuk dropdown
$queryUser = "SELECT id_user, username FROM users WHERE role = 'User'";
$stmtUser = $db->prepare($queryUser);
$stmtUser->execute();
// Tambahkan ini untuk tes saja, nanti hapus lagi
// echo "Jumlah user ditemukan: " . $stmtUser->rowCount();

// 2. Ambil data proyek lama berdasarkan ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Gunakan fungsi readOne yang sudah kita buat di Proyek.php agar aman
    $proyek = $proyekObj->readOne($id); 

    if (!$proyek) {
        die("Data proyek tidak ditemukan.");
    }
} else {
    header("Location: index.php");
    exit();
}

// 3. Proses update data ke database
if (isset($_POST['update'])) {
    $nama = htmlspecialchars($_POST['nama_proyek']);
    $desc = htmlspecialchars($_POST['deskripsi']);
    // Perbaikan: Paksa id_user menjadi NULL jika dropdown memilih kosong
    $id_user = !empty($_POST['id_user']) ? $_POST['id_user'] : null; 
    $status = $_POST['status'];

    // Menggunakan method update dari class Proyek yang sudah disempurnakan
    if ($proyekObj->update($id, $nama, $desc, $id_user, $status)) {
        header("Location: index.php?pesan=update_berhasil");
        exit();
    } else {
        $error = "Gagal memperbarui data proyek.";
    }
}

include 'header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                <h3 class="fw-bold mb-4 text-center">Edit Penugasan Proyek</h3>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Proyek</label>
                        <input type="text" name="nama_proyek" class="form-control" value="<?= htmlspecialchars($proyek['nama_proyek']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($proyek['deskripsi']); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Penanggung Jawab</label>
                        <select name="id_user" class="form-select shadow-sm">
                            <option value="">-- Pilih Anggota --</option>
                            <?php while ($u = $stmtUser->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?= $u['id_user']; ?>" <?= ($u['id_user'] == $proyek['id_user']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($u['username']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Status Proyek</label>
                        <select name="status" class="form-select shadow-sm">
                            <option value="Planning" <?= ($proyek['status'] == 'Planning') ? 'selected' : ''; ?>>Planning</option>
                            <option value="Ongoing" <?= ($proyek['status'] == 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                            <option value="Done" <?= ($proyek['status'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="update" class="btn btn-primary fw-bold rounded-pill">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="index.php" class="btn btn-outline-secondary rounded-pill">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>