<?php
session_start();
require_once 'Config.php';

// Inisialisasi koneksi database
$database = new Config();
$db = $database->getConnection();

// Proses pengecekan saat tombol login ditekan
if (isset($_POST['login'])) {
    $userInput = htmlspecialchars($_POST['username']);
    $passInput = $_POST['password'];

    // Cari user di tabel users berdasarkan username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$userInput]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi: Cek apakah user ada dan password hash cocok
    if ($data && (password_verify($passInput, $data['password']) || md5($passInput) === $data['password'])) {
    $_SESSION['id_user']  = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role']     = $data['role'];
    header("Location: index.php");
    exit();
    } else {
        // Jika gagal, buat pesan error
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ProyekManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100vh; display: flex; align-items: center; font-family: 'Segoe UI', sans-serif; }
        .login-card { border-radius: 15px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.3); }
        .btn-primary { background-color: #667eea; border: none; padding: 10px; font-weight: 600; }
        .btn-primary:hover { background-color: #5a6fd6; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Login Sistem</h3>
                    <p class="text-muted small">Manajemen Proyek & Tugas</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger p-2 small border-0 shadow-sm mb-3">
                        <i class="bi bi-exclamation-circle me-1"></i> <?= $error; ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'logout_berhasil'): ?>
                    <div class="alert alert-success small py-2 border-0 shadow-sm mb-3 text-center">
                        <i class="bi bi-check-circle me-1"></i> Anda telah berhasil keluar.
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" name="login" class="btn btn-primary rounded-pill">
                            Masuk Sekarang <i class="bi bi-arrow-right-circle ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
            <p class="text-center mt-4 text-white-50 small">© 2026 ProyekManager App</p>
        </div>
    </div>
</div>
</body>
</html>