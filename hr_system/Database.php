<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=hr_db", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi Gagal: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) self::$instance = new Database();
        return self::$instance->conn;
    }
}