<?php
require_once 'Database.php';

abstract class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // FUNGSI UNTUK MENGAMBIL 1 DATA (Penting untuk Form Edit)
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // FUNGSI UPDATE DINAMIS (Bisa digunakan untuk semua tabel)
    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");

        $sql = "UPDATE {$this->table} SET $fields WHERE id = :id";
        $data['id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // FUNGSI DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // FUNGSI PAGINATION
    public function paginate($limit, $offset) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} LIMIT :l OFFSET :o");
        $stmt->bindValue(':l', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':o', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // FUNGSI HITUNG TOTAL DATA
    public function countAll() {
        return $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}