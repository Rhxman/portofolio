<?php
require_once 'auth_check.php';
require_once 'Config.php';
cekLogin();
cekAdmin();

$database = new Config();
$db = $database->getConnection();

$query = "SELECT * FROM users";
$stmt = $db->prepare($query);
$stmt->execute();

include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Pengguna</h3>
    <a href="tambah_user.php" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Tambah User Baru</a>
</div>

<div class="row g-4 mt-2">
    <?php while ($user = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card border-start border-primary border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 small fw-bold"><?= $user['role']; ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-circle fs-2 text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="edit_user.php?id=<?= $user['id_user']; ?>" class="btn btn-sm btn-link text-decoration-none p-0">Ubah Role</a>
                    <a href="hapus_user.php?id=<?= $user['id_user']; ?>" class="btn btn-sm btn-link text-danger text-decoration-none p-0">Hapus</a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>