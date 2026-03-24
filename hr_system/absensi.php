<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'AttendanceModel.php';
require_once 'Database.php'; // Pastikan Database di-load

$auth = new Auth();
$auth->protect(['admin','employee', 'hr']); 

$db = Database::getInstance();
$attModel = new AttendanceModel();

/// Ambil User ID dari session yang sedang aktif
$user_id = $_SESSION['user_id']; 
$db = Database::getInstance();

// CARI ID KARYAWAN YANG BENAR-BENAR MILIK USER INI
$stmt = $db->prepare("SELECT id FROM employees WHERE user_id = ?");
$stmt->execute([$user_id]);
$empData = $stmt->fetch(PDO::FETCH_ASSOC);

// Cek apakah data ditemukan untuk menghindari error #1452 lagi
if (!$empData) {
    die("Profil karyawan tidak sinkron. Silakan logout dan login kembali.");
}

// Sekarang $emp_id akan berisi 39 (untuk josjos) atau 40 (untuk sae) secara otomatis
$emp_id = $empData['id'];
$msg = "";
$status_absen = $attModel->checkTodayAttendance($emp_id);

// 4. Proses Absen Masuk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$status_absen) {
    if ($attModel->recordCheckIn($emp_id)) {
        $status_absen = $attModel->checkTodayAttendance($emp_id);
        $msg = "Absen Berhasil!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absen Masuk</title>
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .absensi-container { max-width: 450px; margin: 80px auto; text-align: center; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-absen { background: #27ae60; color: white; border: none; padding: 15px 35px; font-size: 18px; border-radius: 10px; cursor: pointer; width: 100%; transition: 0.3s; }
        .btn-absen:hover { background: #219150; }
        .btn-absen:disabled { background: #bdc3c7; cursor: not-allowed; }
        .info-absen { margin-top: 25px; padding: 20px; border-radius: 10px; background: #e8f5e9; border: 1px solid #c8e6c9; }
        .alert-late { color: #d35400; font-weight: bold; margin-top: 15px; padding: 10px; background: #fff3e0; border-radius: 5px; }
        .time-now { font-size: 24px; color: #2c3e50; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="absensi-container">
    <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?></h2>
    <div class="time-now" id="clock"><?= date('H:i:s') ?></div>
    <hr>

    <?php if ($msg): ?>
        <p style="color: #27ae60; font-weight: bold;"><?= $msg ?></p>
    <?php endif; ?>

    <?php if ($status_absen): ?>
        <div class="info-absen">
            <p>Anda sudah absen hari ini pada:</p>
            <h1 style="margin: 10px 0; color: #2c3e50;"><?= $status_absen['check_in'] ?></h1>
            <?php if ($status_absen['status'] == 'late'): ?>
                <div class="alert-late">
                     Sekarang sudah pukul <?= $status_absen['check_in'] ?>, jangan telat lagi!
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <form method="POST">
            <p style="color: #7f8c8d; margin-bottom: 20px;">Silakan klik tombol di bawah untuk mencatat kehadiran hari ini.</p>
            <button type="submit" class="btn-absen">Klik Untuk Absen Masuk</button>
        </form>
    <?php endif; ?>

    <br><br>
    <a href="dashboard.php" style="color: #3498db; text-decoration: none; font-size: 14px;">← Kembali ke Dashboard</a>
</div>

<script>
    // Opsional: Jam berjalan real-time di layar
    setInterval(() => {
        const now = new Date();
        document.getElementById('clock').innerText = now.toTimeString().split(' ')[0];
    }, 1000);
</script>

</body>
</html>