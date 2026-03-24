<?php
require_once 'Database.php';

class Auth {
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance();
    }

    /**
     * FUNGSI LOGIN
     */
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    /**
     * FUNGSI REGISTRASI
     * @param string $dept_id ID dari tabel departments
     */
    public function register($username, $email, $password, $role = 'employee') {
        try {
            $this->db->beginTransaction();

            // 1. Cek email unik
            $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$email]);
            if ($check->fetch()) { return "email_exists"; }

            // 2. Simpan ke tabel users
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sqlUser = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([$username, $email, $hashedPassword, $role]);
            
            $userId = $this->db->lastInsertId();

            // 3. Generate NIK (001A, 001B, dst)
            $nik = $this->generateRoleBasedNIK($role);

            // 4. Simpan ke tabel employees (Tanpa department_id)
            $positionName = ucfirst($role); // Jabatan otomatis jadi 'Admin' atau 'Employee'
            
            $sqlEmp = "INSERT INTO employees (user_id, employee_code, name, position, base_salary, status) 
                    VALUES (?, ?, ?, ?, ?, 'active')";
            $stmtEmp = $this->db->prepare($sqlEmp);
            
            // Gaji default 5jt
            $stmtEmp->execute([$userId, $nik, $username, $positionName, 5000000]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * GENERATE NIK UNIK
     */
    private function generateRoleBasedNIK($role) {
        $roleMap = ['admin' => 'A', 'employee' => 'B', 'hr' => 'C'];
        $char = $roleMap[$role] ?? 'B';

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
        $stmt->execute([$role]);
        $count = $stmt->fetchColumn();

        return str_pad($count, 3, "0", STR_PAD_LEFT) . $char;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    /**
     * PROTEKSI HALAMAN
     */
    public function protect($allowedRoles = []) {
        if (!$this->isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        if (!empty($allowedRoles) && !in_array($_SESSION['role'], $allowedRoles)) {
            die("<div style='color:red; font-family:sans-serif; text-align:center; margin-top:50px;'>
                    <h2>Akses Ditolak!</h2>
                    <p>Anda tidak memiliki izin untuk membuka halaman ini.</p>
                    <a href='dashboard.php'>Kembali ke Dashboard</a>
                 </div>");
        }
    }
}