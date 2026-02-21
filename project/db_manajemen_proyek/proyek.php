<?php
class Proyek {
    private $db;
    private $table = "proyek";

    public function __construct($db) {
        $this->db = $db;
    }

    // Ambil semua data proyek beserta nama username dari tabel users
    public function read() {
        // Menggunakan LEFT JOIN agar proyek tetap muncul meskipun belum ada anggota yang ditugaskan (Unassigned)
        $query = "SELECT p.*, u.username FROM " . $this->table . " p 
                  LEFT JOIN users u ON p.id_user = u.id_user 
                  ORDER BY p.id_proyek DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Mengambil satu data proyek secara detail berdasarkan ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_proyek = ? LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambah proyek baru dengan parameter lengkap termasuk id_user
    public function create($nama, $desc, $id_user, $tgl, $status) {
        // Jika id_user kosong, kita masukkan NULL agar tidak terjadi error Integrity Constraint
        $id_user = !empty($id_user) ? $id_user : null;

        $query = "INSERT INTO " . $this->table . " (nama_proyek, deskripsi, id_user, tanggal_mulai, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$nama, $desc, $id_user, $tgl, $status]);
    }

    // Update data proyek termasuk mengganti penanggung jawab
    public function update($id, $nama, $desc, $id_user, $status) {
        $id_user = !empty($id_user) ? $id_user : null;

        $query = "UPDATE " . $this->table . " SET nama_proyek = ?, deskripsi = ?, id_user = ?, status = ? WHERE id_proyek = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$nama, $desc, $id_user, $status, $id]);
    }

    // Menghapus proyek dari database
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_proyek = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>