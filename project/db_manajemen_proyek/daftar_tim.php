<?php
require_once 'Config.php';

$database = new Config();
$db = $database->getConnection();

// Daftar nama anggota yang ingin kamu masukkan
$anggota_baru = [
    'RAHMAN MAULANA',
    'MUHAMMAD GIRBAN',
    'OJAN'
];

foreach ($anggota_baru as $nama) {
    $username = strtolower(str_replace(' ', '_', $nama)); // Membuat username jadi kecil & tanpa spasi
    $password = password_hash('password123', PASSWORD_DEFAULT); // Password default: password123
    $role = 'User';

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    
    if ($stmt->execute([$nama, $password, $role])) {
        echo "Anggota <b>$nama</b> berhasil didaftarkan!<br>";
    }
}

echo "<br><a href='index.php'>Kembali ke Dashboard</a>";
?>