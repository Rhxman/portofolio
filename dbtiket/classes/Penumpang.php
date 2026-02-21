<?php
require_once "Database.php";

class Penumpang extends Database {

    public function tambah($data) {
        $stmt = $this->conn->prepare("INSERT INTO penumpang (nama, nik, jenis_kelamin, tujuan, tanggal_berangkat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $data['nama'], $data['nik'], $data['jenis_kelamin'], $data['tujuan'], $data['tanggal']);
        return $stmt->execute();
    }

    public function ambilSemua() {
        return $this->conn->query("SELECT * FROM penumpang");
    }

    public function ambilById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM penumpang WHERE id_penumpang = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE penumpang SET nama=?, nik=?, jenis_kelamin=?, tujuan=?, tanggal_berangkat=? WHERE id_penumpang=?");
        $stmt->bind_param("sssssi", $data['nama'], $data['nik'], $data['jenis_kelamin'], $data['tujuan'], $data['tanggal'], $id);
        return $stmt->execute();
    }

    public function hapus($id) {
        $stmt = $this->conn->prepare("DELETE FROM penumpang WHERE id_penumpang = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
