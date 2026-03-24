<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'EmployeeModel.php';

$auth = new Auth();
// Semua role bisa melihat daftar ini
$auth->protect(['admin', 'hr', 'employee']); 

$empModel = new EmployeeModel();

// Konfigurasi Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data karyawan
$employees = $empModel->paginate($limit, $offset);
$totalData = $empModel->countAll();
$totalPage = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Karyawan & Penggajian</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 1300px; margin: auto; }
        
        .nav-links { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .nav-links a { color: #3498db; text-decoration: none; font-weight: bold; margin-right: 15px; font-size: 14px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #2c3e50; color: white; padding: 15px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #333; font-size: 14px; vertical-align: middle; }
        tr:hover { background-color: #f9fbff; }

        /* Gaya Khusus Gaji & Status */
        .salary-final { font-weight: bold; color: #27ae60; font-size: 15px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block; margin-bottom: 2px; }
        .badge-alpa { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
        .badge-late { background: #fffaf0; color: #9b2c2c; border: 1px solid #fbd38d; }
        .badge-bonus { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
        .text-muted { color: #95a5a6; font-size: 12px; }

        /* Tombol Aksi */
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 5px; font-size: 12px; cursor: pointer; border: none; transition: 0.2s; }
        .btn-edit { background-color: #3498db; color: white; }
        .btn-delete { background-color: #e74c3c; color: white; }
        
        .pagination { margin-top: 20px; }
        .pagination a { padding: 7px 12px; border: 1px solid #ddd; text-decoration: none; color: #333; border-radius: 4px; margin-right: 4px; }
        .pagination a.active { background: #2c3e50; color: white; border-color: #2c3e50; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Daftar Karyawan</h2>
        
    </div>
    
    

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Gaji Pokok</th>
                <th>Gaji Bulan Ini</th>
                <th>Ringkasan Absen (30H)</th>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <th>Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $row): 
                // Kalkulasi Gaji berdasarkan logika: Alpa (Status: absent) & Tepat Waktu (Status: present)
                $calc = $empModel->calculateSalary($row['id'], $row['base_salary']);
            ?>
            <tr>
                <td><code><?= htmlspecialchars($row['employee_code']) ?></code></td>
                <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                <td>
                    <?php 
                        if ($row['role'] === 'admin') echo 'Administrator';
                        elseif ($row['role'] === 'hr') echo 'HR Staff';
                        else echo 'Employee';
                    ?>
                </td>
                <td>Rp <?= number_format($row['base_salary'], 0, ',', '.') ?></td>
                
                <td class="salary-final">
                    Rp <?= number_format($calc['final_salary'], 0, ',', '.') ?>
                </td>

                <td>
                    <?php if ($calc['absent_count'] > 0): ?>
                        <div class="badge badge-alpa">
                            Alpa: <?= $calc['absent_count'] ?>x 
                            <?= ($calc['absent_count'] >= 3) ? '(Potong '.(floor($calc['absent_count']/3)*10).'%)' : '' ?>
                        </div><br>
                    <?php endif; ?>

                    <?php if ($calc['late_count'] > 0): ?>
                        <div class="badge badge-late">Telat: <?= $calc['late_count'] ?>x</div><br>
                    <?php endif; ?>

                    <?php if ($calc['bonus'] > 0): ?>
                        <div class="badge badge-bonus">Bonus Tepat Waktu!</div>
                    <?php elseif ($calc['absent_count'] == 0 && $calc['late_count'] == 0): ?>
                        <span class="text-muted">Proses Bonus (Hadir: <?= $calc['present_count'] ?? 0 ?>/30)</span>
                    <?php endif; ?>
                </td>
                
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <td>
                    <a href="employee_edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                    
                    <?php if ($row['user_id'] != $_SESSION['user_id']): ?>
                        <form action="employee_delete.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Hapus data?')">Hapus</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted" style="margin-left:5px;">(Self)</span>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

</body>
</html>