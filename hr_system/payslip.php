<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'EmployeeModel.php';

$auth = new Auth();
$auth->protect(); // Semua role bisa akses

$empModel = new EmployeeModel();
$user_id = $_SESSION['user_id'];

// Ambil data profil dan gaji karyawan yang login
$db = Database::getInstance();
$stmt = $db->prepare("SELECT * FROM employees WHERE user_id = ?");
$stmt->execute([$user_id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employee) {
    die("Data karyawan tidak ditemukan.");
}

// Gunakan fungsi kalkulasi yang sudah kita perbarui sebelumnya
$calc = $empModel->calculateSalary($employee['id'], $employee['base_salary']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?= htmlspecialchars($employee['name']) ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f4f4f4; padding: 20px; }
        .payslip-box { 
            background: white; padding: 40px; border: 1px solid #ddd; 
            max-width: 800px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .info-table, .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; font-size: 14px; }
        .detail-table th, .detail-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .detail-table th { background: #f9f9f9; }
        .total-row { font-weight: bold; background: #eee; }
        .btn-print { 
            display: block; width: 100px; padding: 10px; background: #2c3e50; 
            color: white; text-align: center; text-decoration: none; margin: 20px auto; border-radius: 5px;
        }
        
        /* Pengaturan Cetak */
        @media print {
            .btn-print, .nav-back { display: none; }
            body { background: white; padding: 0; }
            .payslip-box { border: none; box-shadow: none; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

<div class="nav-back" style="max-width: 800px; margin: 0 auto 10px auto;">
    <a href="dashboard.php" style="text-decoration:none; color:#3498db;">← Kembali ke Dashboard</a>
</div>

<div class="payslip-box">
    <div class="header">
        <h1 style="margin:0;">SLIP GAJI KARYAWAN</h1>
        <p style="margin:5px 0;">Periode: <?= date('F Y') ?></p>
    </div>

    <table class="info-table">
        <tr>
            <td width="150">Nama Karyawan</td><td>: <?= htmlspecialchars($employee['name']) ?></td>
            <td width="150">Kode Karyawan</td><td>: <?= htmlspecialchars($employee['employee_code']) ?></td>
        </tr>
        <tr>
            <td>Jabatan</td><td>: <?= ucfirst($_SESSION['role']) ?></td>
            <td>Tanggal Cetak</td><td>: <?= date('d/m/Y H:i') ?></td>
        </tr>
    </table>

    <h3>Rincian Kehadiran (30 Hari Terakhir)</h3>
    <table class="detail-table">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Hadir Tepat Waktu</td>
                <td><?= $calc['present_count'] ?> Hari</td>
                <td>06:00 - 08:00 WIB</td>
            </tr>
            <tr>
                <td>Terlambat</td>
                <td><?= $calc['late_count'] ?> Hari</td>
                <td>08:01 - 09:00 WIB (Tanpa Potongan)</td>
            </tr>
            <tr>
                <td>Tidak Hadir (Alpa)</td>
                <td><?= $calc['absent_count'] ?> Hari</td>
                <td>> 09:00 WIB / Tanpa Absen</td>
            </tr>
        </tbody>
    </table>

    <h3>Rincian Pendapatan & Potongan</h3>
    <table class="detail-table">
        <tr>
            <td>Gaji Pokok</td>
            <td style="text-align:right;">Rp <?= number_format($employee['base_salary'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Bonus Kehadiran Penuh</td>
            <td style="text-align:right;">Rp <?= number_format($calc['bonus'], 0, ',', '.') ?></td>
        </tr>
        <tr style="color: #c0392b;">
            <td>Potongan Alpa (Mulai hari ke-4: <?= $calc['penalty_days'] ?> hari)</td>
            <td style="text-align:right;">- Rp <?= number_format($calc['penalty'], 0, ',', '.') ?></td>
        </tr>
        <tr class="total-row">
            <td>TOTAL GAJI BERSIH (TAKE HOME PAY)</td>
            <td style="text-align:right;">Rp <?= number_format($calc['final_salary'], 0, ',', '.') ?></td>
        </tr>
    </table>

    <div style="margin-top: 50px; display: flex; justify-content: space-between;">
        <div style="text-align:center; width: 200px;">
            <p>Penerima,</p>
            <br><br><br>
            <p>( <?= htmlspecialchars($employee['name']) ?> )</p>
        </div>
        <div style="text-align:center; width: 200px;">
            <p>Admin HRD,</p>
            <br><br><br>
            <p>( ............................ )</p>
        </div>
    </div>
</div>

<a href="#" class="btn-print" onclick="window.print()">Cetak Slip</a>

</body>
</html>