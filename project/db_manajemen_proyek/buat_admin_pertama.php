<?php
require_once 'Config.php';
$database = new Config();
$db = $database->getConnection();
$username = "admin";
$password = password_hash("admin123", PASSWORD_BCRYPT);
$role = "Admin";
$query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $db->prepare($query);
if($stmt->execute([$username, $password, $role])) {
    echo "Admin berhasil dibuat!";
}
?>