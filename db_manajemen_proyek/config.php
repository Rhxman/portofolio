<?php
class Config {
    private $host = "localhost";
    private $db_name = "db_manajemen_proyek";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Menggunakan set charset utf8 agar data teks (seperti nama anggota) aman
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            // Menghilangkan echo agar tidak mengganggu proses redirect/session
            error_log("Connection error: " . $exception->getMessage());
            return null;
        }
        return $this->conn;
    }
}
?>