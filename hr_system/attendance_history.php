<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'AttendanceModel.php';
require_once 'EmployeeModel.php';

$auth = new Auth();
$auth->protect(); // Semua role bisa masuk

$attModel = new AttendanceModel();
$user_id = $_SESSION['user_id'];

// SEMUA ROLE: Cari dulu ID Employee mereka sendiri berdasarkan user_id di session
$db = Database::getInstance();
$stmt = $db->prepare("SELECT id FROM employees WHERE user_id = ?");
$stmt->execute([$user_id]);
$emp = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$emp) {
    die("Data profil karyawan tidak ditemukan.");
}

// Ambil riwayat hanya untuk diri sendiri (ID yang login)
$history = $attModel->getAllHistory30Days($emp['id']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Saya</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 30px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 900px; margin: auto; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2c3e50; color: white; padding: 15px; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #edf2f7; font-size: 14px; }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .ontime { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
        .late { background: #fffaf0; color: #9b2c2c; border: 1px solid #fbd38d; }
        .absent { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
    </style>
</head>
<body>

<div class="card">
    <div class="header-flex">
        <h2 style="margin:0;">Riwayat Absensi Saya</h2>
        <a href="dashboard.php" style="text-decoration:none; color:#3498db; font-weight:bold;">← Kembali</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($history)): ?>
                <tr><td colspan="3" style="text-align:center; padding:30px; color:#95a5a6;">Belum ada riwayat absen.</td></tr>
            <?php else: ?>
                <?php foreach($history as $row): ?>
                <tr>
                    <td><strong><?= date('d M Y', strtotime($row['date'])) ?></strong></td>
                    <td><?= $row['check_in'] ?></td>
                    <td>
                        <?php if($row['status'] == 'present'): ?>
                            <span class="badge ontime">TEPAT WAKTU</span>
                        <?php elseif($row['status'] == 'late'): ?>
                            <span class="badge late">TERLAMBAT</span>
                        <?php else: ?>
                            <span class="badge absent">TIDAK HADIR</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>