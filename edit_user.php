<?php
require_once 'auth_check.php';
require_once 'Config.php';

cekLogin();
cekAdmin();

$database = new Config();
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT id_user, username, role FROM users WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Data anggota tidak ditemukan.");
    }
}

if (isset($_POST['update_role'])) {
    $new_role = $_POST['role'];
    $id_user = $_POST['id_user'];

    $queryUpdate = "UPDATE users SET role = ? WHERE id_user = ?";
    $stmtUpdate = $db->prepare($queryUpdate);
    
    if ($stmtUpdate->execute([$new_role, $id_user])) {
        header("Location: manajemen_user.php?pesan=role_diperbarui");
        exit();
    }
}

include 'header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Ubah Role Anggota</h3>
                    <form method="POST">
                        <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['username']); ?>" readonly>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Role Baru</label>
                            <select name="role" class="form-select">
                                <option value="User" <?= ($user['role'] == 'User') ? 'selected' : ''; ?>>User (Anggota Tim)</option>
                                <option value="Admin" <?= ($user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin (Manajer)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="update_role" class="btn btn-primary fw-bold rounded-pill">Simpan Perubahan</button>
                            <a href="manajemen_user.php" class="btn btn-light rounded-pill">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>