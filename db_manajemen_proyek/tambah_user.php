<?php
require_once 'auth_check.php';
require_once 'Config.php';

cekLogin();
cekAdmin(); // Memastikan hanya manajer/admin yang bisa menambah tim

if (isset($_POST['simpan_user'])) {
    $database = new Config();
    $db = $database->getConnection();

    $username = htmlspecialchars($_POST['username']);
    // Menggunakan password_hash agar keamanan akun tim sama kuatnya dengan admin
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$username, $password, $role])) {
        // Jika sukses, kembali ke halaman manajemen pengguna
        header("Location: manajemen_user.php?pesan=tambah_berhasil");
        exit();
    } else {
        $error = "Gagal menambah anggota tim baru.";
    }
}

include 'header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-person-plus-fill text-primary fs-1"></i>
                    <h3 class="fw-bold mt-2">Daftarkan Anggota Baru</h3>
                    <p class="text-muted small">Anggota yang terdaftar akan muncul sebagai pilihan penanggung jawab proyek.</p>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger small py-2"><?= $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" class="text-start mt-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username Anggota</label>
                            <input type="text" name="username" class="form-control rounded-pill px-3" placeholder="Contoh: rahman_dev" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Sementara</label>
                            <input type="password" name="password" class="form-control rounded-pill px-3" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Role / Akses</label>
                            <select name="role" class="form-select rounded-pill px-3">
                                <option value="User">User (Anggota Tim)</option>
                                <option value="Admin">Admin (Manajer Proyek)</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="simpan_user" class="btn btn-primary fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Data Anggota
                            </button>
                            <a href="manajemen_user.php" class="btn btn-light rounded-pill small">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>