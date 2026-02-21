<?php
class Database {
    protected $host = "localhost";
    protected $user = "root";
    protected $pass = "";
    protected $db = "db_tiket";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }
}
?>
