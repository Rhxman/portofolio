<?php
require_once 'auth_check.php';
require_once 'Config.php';
require_once 'Proyek.php';
cekLogin();

$database = new Config();
$db = $database->getConnection();
$proyek = new Proyek($db);

// --- LOGIKA PENCARIAN BARU ---
$keyword = isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '';

if (!empty($keyword)) {
    // Mencari berdasarkan Nama Proyek atau Nama Anggota
    $querySearch = "SELECT p.*, u.username FROM proyek p 
                    LEFT JOIN users u ON p.id_user = u.id_user 
                    WHERE p.nama_proyek LIKE ? OR u.username LIKE ?
                    ORDER BY p.id_proyek DESC";
    $stmt = $db->prepare($querySearch);
    $stmt->execute(["%$keyword%", "%$keyword%"]);
    $proyek_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Ambil semua data jika tidak ada pencarian
    $data = $proyek->read();
    $proyek_list = $data->fetchAll(PDO::FETCH_ASSOC);
}

// Logika Statistik (Dihitung dari data yang tampil)
$total_proyek = count($proyek_list);
$ongoing = 0;
$done = 0;

foreach($proyek_list as $p) {
    if($p['status'] == 'Ongoing') $ongoing++;
    if($p['status'] == 'Done') $done++;
}

include 'header.php'; 
?>

<div class="row mb-4 justify-content-center">
    <div class="col-md-6">
        <form action="index.php" method="GET" class="input-group shadow-sm border rounded-pill overflow-hidden">
            <span class="input-group-text bg-white border-0 ps-3">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="cari" class="form-control border-0 shadow-none" 
                   placeholder="Cari proyek atau anggota tim..." 
                   value="<?= $keyword; ?>">
            <?php if(!empty($keyword)): ?>
                <a href="index.php" class="btn btn-white border-0 text-muted d-flex align-items-center">
                    <i class="bi bi-x-circle"></i>
                </a>
            <?php endif; ?>
            <button class="btn btn-primary px-4 fw-bold" type="submit">Cari</button>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-0 border-start border-primary border-4 shadow-sm py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1" style="font-size: 0.75rem;">Total Proyek</div>
                        <div class="h5 mb-0 fw-bold text-dark"><?= $total_proyek; ?></div>
                    </div>
                    <div class="col-auto"><i class="bi bi-kanban fs-2 text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 border-start border-warning border-4 shadow-sm py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1" style="font-size: 0.75rem;">Sedang Berjalan</div>
                        <div class="h5 mb-0 fw-bold text-dark"><?= $ongoing; ?></div>
                    </div>
                    <div class="col-auto"><i class="bi bi-gear-wide-connected fs-2 text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 border-start border-success border-4 shadow-sm py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1" style="font-size: 0.75rem;">Selesai</div>
                        <div class="h5 mb-0 fw-bold text-dark"><?= $done; ?></div>
                    </div>
                    <div class="col-auto"><i class="bi bi-check-all fs-2 text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3 align-items-center">
    <div class="col-md-6">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-list-stars me-2 text-primary"></i>Ringkasan Tugas</h5>
    </div>
    <div class="col-md-6 text-md-end">
        <button onclick="window.print()" class="btn btn-white shadow-sm btn-sm rounded-pill px-3 border">
            <i class="bi bi-printer me-2 text-primary"></i>Cetak Laporan
        </button>
    </div>
</div>

<?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'status_updated'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> Status proyek berhasil diperbarui!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" width="80">No</th> 
                    <th>Proyek & Deskripsi</th>
                    <th>Anggota Tim</th> 
                    <th>Status Pekerjaan</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                if(count($proyek_list) > 0):
                    foreach ($proyek_list as $row): 
                ?>
                <tr>
                    <td class="ps-4 fw-bold text-primary">#<?= $no++; ?></td>
                    <td>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama_proyek']); ?></div>
                        <div class="text-muted small"><?= substr(htmlspecialchars($row['deskripsi']), 0, 50); ?>...</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['username'] ?? 'U'); ?>&background=random&color=fff" class="rounded-circle me-2" width="28">
                            <span class="small fw-semibold">
                                <?= $row['username'] ? htmlspecialchars($row['username']) : '<span class="text-muted fw-normal">Unassigned</span>'; ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <?php 
                            $badge = "btn-secondary";
                            if($row['status'] == 'Done') $badge = "btn-success";
                            if($row['status'] == 'Ongoing') $badge = "btn-warning text-dark";
                            ?>
                            <button class="btn btn-sm <?= $badge; ?> dropdown-toggle rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                <?= $row['status']; ?>
                            </button>
                            <ul class="dropdown-menu shadow-lg border-0">
                                <li><a class="dropdown-item small" href="update_status.php?id=<?= $row['id_proyek']; ?>&status=Planning">Planning</a></li>
                                <li><a class="dropdown-item small" href="update_status.php?id=<?= $row['id_proyek']; ?>&status=Ongoing">Ongoing</a></li>
                                <li><a class="dropdown-item small" href="update_status.php?id=<?= $row['id_proyek']; ?>&status=Done">Done</a></li>
                            </ul>
                        </div>
                    </td>
                    <td class="text-end pe-4">
                        <div class="btn-group shadow-sm">
                            <a href="edit_proyek.php?id=<?= $row['id_proyek']; ?>" class="btn btn-sm btn-white border"><i class="bi bi-pencil-square text-primary"></i></a>
                            <?php if($_SESSION['role'] == 'Admin'): ?>
                                <a href="hapus_proyek.php?id=<?= $row['id_proyek']; ?>" class="btn btn-sm btn-white border" onclick="return confirm('Hapus proyek ini?')"><i class="bi bi-trash text-danger"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted">Proyek tidak ditemukan.</p>
                        <a href="index.php" class="btn btn-sm btn-primary rounded-pill px-3">Lihat Semua Proyek</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>