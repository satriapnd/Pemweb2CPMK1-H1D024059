<?php
// Aktifkan laporan error agar jika ada salah ketik langsung terlihat pesannya
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Auth.php';
require_once 'EmployeeModel.php';

$auth = new Auth();
$auth->protect(['admin']); // Hanya admin yang boleh edit

$empModel = new EmployeeModel();

// 1. Validasi ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Karyawan tidak ditemukan.");
}

$id = $_GET['id'];
$employee = $empModel->find($id); // Memanggil fungsi di BaseModel

// 2. Jika ID tidak ada di database
if (!$employee) {
    die("Karyawan dengan ID tersebut tidak ada di database.");
}

// 3. Proses Update jika Form di-Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'];
    $id = $_GET['id'];

    try {
        $db = Database::getInstance();
        $db->beginTransaction();

        // 1. Ambil user_id terkait karyawan ini
        $employee = $empModel->find($id);
        $userId = $employee['user_id'];

        // 2. Update Nama di tabel Employees
        $sqlEmp = "UPDATE employees SET name = ?, position = ?, base_salary = ?, status = ? WHERE id = ?";
        $stmtEmp = $db->prepare($sqlEmp);
        $stmtEmp->execute([$newName, $_POST['position'], $_POST['base_salary'], $_POST['status'], $id]);

        // 3. Update Username di tabel Users
        $sqlUser = "UPDATE users SET username = ? WHERE id = ?";
        $stmtUser = $db->prepare($sqlUser);
        $stmtUser->execute([$newName, $userId]);

        // 4. KRUSIAL: Jika yang diedit adalah akun diri sendiri, update Session-nya!
        if ($userId == $_SESSION['user_id']) {
            $_SESSION['username'] = $newName;
        }

        $db->commit();
        header("Location: employee_list.php?status=updated");
        exit();

    } catch (Exception $e) {
        $db->rollBack();
        die("Gagal update: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Karyawan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-box { max-width: 500px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        label { font-weight: bold; color: #2c3e50; }
        .btn-save { background: #2c3e50; color: white; border: none; padding: 12px; width: 100%; cursor: pointer; border-radius: 4px; font-weight: bold; }
        .btn-cancel { display: block; text-align: center; margin-top: 10px; color: #7f8c8d; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body style="background: #f4f7f6; font-family: sans-serif;">

<div class="edit-box">
    <h2>Edit Data Karyawan</h2>
    <hr>
    
    <?php if(isset($error_msg)) echo "<p style='color:red'>$error_msg</p>"; ?>

    <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required>

        <label>Posisi / Jabatan</label>
        <input type="text" name="position" value="<?= htmlspecialchars($employee['position'] ?? 'Staf') ?>" required>

        <label>Gaji Pokok (Rp)</label>
        <input type="number" name="base_salary" value="<?= htmlspecialchars($employee['base_salary']) ?>" required>

        <label>Status</label>
        <select name="status">
            <option value="active" <?= $employee['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
            <option value="resign" <?= $employee['status'] == 'resign' ? 'selected' : '' ?>>Resign</option>
        </select>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
        <a href="employee_list.php" class="btn-cancel">Batal & Kembali</a>
    </form>
</div>

</body>
</html>