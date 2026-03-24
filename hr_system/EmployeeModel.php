<?php
require_once 'BaseModel.php';

class EmployeeModel extends BaseModel {
    protected $table = 'employees';
    // Override fungsi paginate untuk mengambil nama departemen
    public function paginate($limit, $offset) {
        // Mengambil semua data dari employees yang sudah terhubung dengan users
        $sql = "SELECT e.*, u.role 
                FROM employees e 
                JOIN users u ON e.user_id = u.id 
                ORDER BY e.employee_code ASC
                LIMIT :l OFFSET :o";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':l', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':o', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Tambahkan fungsi ini di dalam class EmployeeModel
    public function calculateSalary($emp_id, $base_salary) {
        // 1. Ambil data absensi 30 hari terakhir
        $sql = "SELECT status, COUNT(*) as jumlah FROM attendances 
                WHERE employee_id = ? 
                AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                GROUP BY status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$emp_id]);
        $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $absentCount = $results['absent'] ?? 0; // Alpa (> jam 9)
        $lateCount   = $results['late'] ?? 0;   // Telat (jam 8 - 9)
        $presentCount = $results['present'] ?? 0; // Tepat Waktu

        // 2. LOGIKA POTONGAN BARU:
        // Potongan hanya berlaku untuk 'absent' (Alpa), bukan 'late' (Telat).
        // Potongan dimulai dari hari ke-4 (3 hari pertama gratis).
        $penaltyDays = 0;
        if ($absentCount > 3) {
            $penaltyDays = $absentCount - 3; 
        }

        // Setiap hari pelanggaran (mulai hari ke-4) potong 10%
        $penaltyPercentage = $penaltyDays * 0.10;
        $totalPenalty = $base_salary * $penaltyPercentage;

        // 3. LOGIKA BONUS:
        // Bonus 100rb HANYA jika 30 hari Full Tepat Waktu (0 Telat & 0 Alpa)
        $bonus = 0;
        if ($presentCount >= 30 && $lateCount == 0 && $absentCount == 0) {
            $bonus = 100000;
        }

        return [
            'final_salary'  => $base_salary - $totalPenalty + $bonus,
            'absent_count'  => $absentCount,
            'late_count'    => $lateCount,
            'present_count' => $presentCount,
            'penalty'       => $totalPenalty,
            'bonus'         => $bonus,
            'penalty_days'  => $penaltyDays // Untuk keterangan di tampilan
        ];
    }

    

    // Tambahkan di dalam class EmployeeModel
    public function all() {
        // Kita gunakan JOIN ke users agar bisa mendapatkan Role/Posisi jika dibutuhkan
        $sql = "SELECT e.*, u.role 
                FROM employees e 
                JOIN users u ON e.user_id = u.id 
                ORDER BY e.employee_code ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}