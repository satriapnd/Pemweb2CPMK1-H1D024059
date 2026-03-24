<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'EmployeeModel.php';

$auth = new Auth();
$auth->protect(); // Semua role (Admin, HR, Employee) bisa masuk

$db = Database::getInstance();
$empModel = new EmployeeModel();

// Ambil data user yang sedang login dari session
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// PERBAIKAN: Query hanya mengambil dari tabel employees
$stmt = $db->prepare("SELECT * FROM employees WHERE user_id = ?");
$stmt->execute([$user_id]);
$me = $stmt->fetch(PDO::FETCH_ASSOC);

// Fitur Turnover dinonaktifkan sementara karena tabel departments sudah dihapus
$topTurnover = null; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard HR System</title>
    <style>
        /* Sesuai tema visual: Background abu-abu muda halus */
        body { 
            font-family: 'Segoe UI', Roboto, sans-serif; 
            background-color: #f8f9fa; 
            margin: 0; 
            padding: 0; 
            color: #333;
        }

        .container { 
            max-width: 1100px; 
            margin: 50px auto; 
            padding: 0 20px; 
        }

        .welcome-card { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            margin-bottom: 30px; 
        }

        h1 { margin: 0; color: #2c3e50; font-size: 28px; font-weight: 700; }

        .role-badge { 
            background: #3498db; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 8px; 
            font-size: 11px; 
            vertical-align: middle; 
            margin-left: 10px;
            text-transform: uppercase;
        }
        
        .sub-text { color: #7f8c8d; margin-top: 10px; font-size: 16px; }

        .menu-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
            gap: 20px; 
            margin-top: 35px; 
        }

        .menu-item { 
            background: white; 
            padding: 30px 20px; 
            border-radius: 12px; 
            text-align: center; 
            text-decoration: none; 
            color: #333; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            border: 1px solid #edf2f7;
            display: flex;
            flex-direction: column;
        }

        .menu-item:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.08); 
            border-color: #3498db; 
        }

        .admin-item { border-top: 4px solid #3498db; }

        .menu-item strong { display: block; font-size: 18px; color: #2c3e50; margin-bottom: 8px; }
        .menu-item span { font-size: 13px; color: #95a5a6; line-height: 1.4; }

        .logout-btn { 
            color: #e74c3c; 
            font-weight: 600; 
            text-decoration: none; 
            margin-top: 40px; 
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="welcome-card">
        <h1>Halo, <?= htmlspecialchars($me['name'] ?? 'User') ?> 
            <span class="role-badge"><?= strtoupper($role) ?></span>
        </h1>
        <p class="sub-text">Selamat datang di Sistem Manajemen HR. Apa yang ingin Anda lakukan hari ini?</p>
        
        <div class="menu-grid">
            <a href="absensi.php" class="menu-item">
                <strong>Absen</strong>
                <span>Catat kehadiran harian Anda</span>
            </a>
            
            <a href="attendance_history.php" class="menu-item">
                <strong>Riwayat Absensi</strong>
                <span>Lihat log kehadiran pribadi</span>
            </a>

            <a href="payslip.php" class="menu-item">
                <strong>Slip Gaji</strong>
                <span>Breakdown gaji & overtime</span>
            </a>

            <?php if ($role === 'admin'): ?>
                <a href="employee_list.php" class="menu-item admin-item">
                    <strong>Data Karyawan</strong>
                    <span>Kelola staf & payroll massal</span>
                </a>
                
                <a href="admin_rekap_bulanan.php" class="menu-item admin-item">
                    <strong>Rekap Bulanan</strong>
                    <span>Visualisasi absensi matrix</span>
                </a>

                <a href="import_attendance.php" class="menu-item admin-item">
                    <strong>Import CSV</strong>
                    <span>Upload data absensi masal</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <a href="logout.php" class="logout-btn">Logout →</a>
</div>

</body>
</html>