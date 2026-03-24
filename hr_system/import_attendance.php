<?php
date_default_timezone_set('Asia/Jakarta');
require_once 'Auth.php';
require_once 'AttendanceModel.php';

$auth = new Auth();
$auth->protect(['admin']); // Hanya Admin yang boleh import

$msg = "";
$errorMsg = "";

if (isset($_POST['import'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    
    // Validasi apakah file diunggah
    if (empty($file)) {
        $errorMsg = "Silakan pilih file CSV terlebih dahulu.";
    } else {
        $handle = fopen($file, "r");
        $rowCount = 0;
        $successCount = 0;
        
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            // Lewati baris pertama (header) jika ada
            fgetcsv($handle); 

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rowCount++;
                
                // Struktur CSV: employee_id, date, check_in, status
                $emp_id  = $data[0];
                $date    = $data[1];
                $time    = $data[2];
                $status  = $data[3];

                // Validasi Format Sederhana
                if (empty($emp_id) || empty($date) || empty($status)) continue;

                $stmt = $db->prepare("INSERT INTO attendances (employee_id, date, check_in, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$emp_id, $date, $time, $status]);
                $successCount++;
            }
            
            $db->commit();
            fclose($handle);
            $msg = "Berhasil! $successCount data absensi telah diimport.";
        } catch (Exception $e) {
            $db->rollBack();
            $errorMsg = "Gagal import: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Absensi CSV</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .info-box { background: #e2f3ff; padding: 15px; border-radius: 5px; font-size: 13px; margin-bottom: 20px; line-height: 1.6; }
        input[type="file"] { margin: 20px 0; display: block; }
        .btn-submit { background: #27ae60; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

<div class="card">
    <h2>Import Data Absensi (.csv)</h2>
    <a href="dashboard.php" style="text-decoration:none; color:#3498db; font-size:14px;">← Kembali</a>
    <hr>

    <?php if($msg): ?> <div class="alert success"><?= $msg ?></div> <?php endif; ?>
    <?php if($errorMsg): ?> <div class="alert error"><?= $errorMsg ?></div> <?php endif; ?>

    <div class="info-box">
        <strong>Format Kolom CSV:</strong><br>
        <code>employee_id, date, check_in, status</code><br>
        <small>*Gunakan format tanggal YYYY-MM-DD (Contoh: 2026-03-24)</small><br>
        <small>*Status: present, late, atau absent</small>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <label>Pilih File CSV:</label>
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit" name="import" class="btn-submit">Mulai Import Data</button>
    </form>
</div>

</body>
</html>