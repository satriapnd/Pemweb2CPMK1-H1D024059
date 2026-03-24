<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'EmployeeModel.php';
require_once 'AttendanceModel.php';

$auth = new Auth();
$auth->protect(['admin']); // Khusus Admin

$empModel = new EmployeeModel();
$attModel = new AttendanceModel();

$month = date('m');
$year = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$employees = $empModel->all(); // Ambil semua karyawan
$matrix = $attModel->getMonthlyMatrix($month, $year);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekap Bulanan - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #2c3e50; color: white; }
        .name-col { text-align: left; font-weight: bold; position: sticky; left: 0; background: white; z-index: 10; min-width: 150px; }
        
        /* Warna Ketentuan User */
        .status-present { background-color: #2ecc71 !important; color: white; } /* Hijau = Hadir */
        .status-late { background-color: #f1c40f !important; color: black; }    /* Kuning = Telat */
        .status-absent { background-color: #e74c3c !important; color: white; }  /* Merah = Alpa */
        .status-empty { background-color: #f9f9f9; color: #ccc; }
        
        .legend { margin-top: 20px; display: flex; gap: 20px; font-size: 14px; }
        .legend-item { display: flex; align-items: center; gap: 5px; }
        .box { width: 20px; height: 20px; border-radius: 3px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Rekap Absensi Bulanan - <?= date('F Y') ?></h2>
    <a href="dashboard.php" style="display:inline-block; margin-bottom: 15px; color: #3498db;">← Kembali</a>

    <table>
        <thead>
            <tr>
                <th class="name-col">Nama Karyawan</th>
                <?php for($d=1; $d<=$daysInMonth; $d++): ?>
                    <th><?= $d ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($employees as $emp): ?>
            <tr>
                <td class="name-col"><?= htmlspecialchars($emp['name']) ?></td>
                <?php for($d=1; $d<=$daysInMonth; $d++): 
                    $status = $matrix[$emp['id']][$d] ?? '';
                    $class = '';
                    if($status == 'present') $class = 'status-present';
                    elseif($status == 'late') $class = 'status-late';
                    elseif($status == 'absent') $class = 'status-absent';
                    else $class = 'status-empty';
                ?>
                    <td class="<?= $class ?>" title="Tanggal <?= $d ?>">
                        <?= ($status) ? substr(strtoupper($status), 0, 1) : '-' ?>
                    </td>
                <?php endfor; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="legend">
        <div class="legend-item"><div class="box status-present"></div> Hadir</div>
        <div class="legend-item"><div class="box status-late"></div> Telat</div>
        <div class="legend-item"><div class="box status-absent"></div> Alpa/Tidak Hadir</div>
    </div>
</div>

</body>
</html>