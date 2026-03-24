<?php
require_once 'Auth.php';
require_once 'Database.php';
$auth = new Auth();
$auth->protect(['admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $empId = $_POST['id'];
    $db = Database::getInstance();

    // 1. Ambil user_id dari employee_id yang dikirim
    $stmt = $db->prepare("SELECT user_id FROM employees WHERE id = ?");
    $stmt->execute([$empId]);
    $emp = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($emp) {
        $userId = $emp['user_id'];
        
        // Proteksi agar tidak hapus diri sendiri
        if ($userId == $_SESSION['user_id']) {
            die("Gagal: Anda tidak bisa menghapus diri sendiri.");
        }

        // 2. HAPUS HANYA DI TABEL users
        // Karena sudah ada ON DELETE CASCADE, tabel employees & attendances
        // akan otomatis dibersihkan oleh database.
        $del = $db->prepare("DELETE FROM users WHERE id = ?");
        $del->execute([$userId]);

        header("Location: employee_list.php?status=deleted");
        exit();
    }
}