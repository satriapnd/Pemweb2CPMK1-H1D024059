<?php
require_once 'BaseModel.php';

class AttendanceModel extends BaseModel {
    protected $table = 'attendances';

    public function checkTodayAttendance($emp_id) {
        $date = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM attendances WHERE employee_id = ? AND date = ?");
        $stmt->execute([$emp_id, $date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordCheckIn($emp_id) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        // Tentukan status berdasarkan jam
        $hour = (int)date('H');
        if ($hour < 8) { $status = 'present'; }
        elseif ($hour < 9) { $status = 'late'; }
        else { $status = 'absent'; }

        // Gunakan query sederhana
        $sql = "INSERT INTO attendances (employee_id, date, check_in, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        // Jika eksekusi gagal, berikan pesan error yang jelas
        if (!$stmt->execute([$emp_id, $date, $time, $status])) {
            print_r($stmt->errorInfo()); 
            return false;
        }
        return true;
    }
    // Tambahkan di dalam class AttendanceModel
    public function getHistory30Days($emp_id = null) {
        $where = "";
        $params = [];
        
        // Jika ada emp_id, filter hanya untuk karyawan tersebut (untuk menu karyawan)
        // Jika null, tampilkan semua (untuk menu admin)
        if ($emp_id) {
            $where = "WHERE a.employee_id = ?";
            $params = [$emp_id];
        }

        $sql = "SELECT a.*, e.name, e.employee_code 
                FROM attendances a 
                JOIN employees e ON a.employee_id = e.id 
                $where 
                AND a.date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY a.date DESC, a.check_in DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllHistory30Days($emp_id = null) {
        // Jika ada emp_id, maka filter per orang (User)
        // Jika null, maka ambil semua data (Admin)
        $sql = "SELECT a.*, e.name, e.employee_code, u.role 
                FROM attendances a 
                JOIN employees e ON a.employee_id = e.id 
                JOIN users u ON e.user_id = u.id ";
        
        if ($emp_id) {
            $sql .= " WHERE a.employee_id = :emp_id ";
        }

        $sql .= " AND a.date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY a.date DESC, a.check_in DESC";

        $stmt = $this->db->prepare($sql);
        if ($emp_id) {
            $stmt->execute(['emp_id' => $emp_id]);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyMatrix($month, $year) {
        $sql = "SELECT employee_id, DAY(date) as day, status 
                FROM attendances 
                WHERE MONTH(date) = ? AND YEAR(date) = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$month, $year]);
        
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[$row['employee_id']][$row['day']] = $row['status'];
        }
        return $data;
    }

    public function processCheckOut($emp_id) {
        $now = date('H:i:s');
        $today = date('Y-m-d');
        $standard_out = "17:00:00";
        $hourly_rate = 28409;

        // Hitung selisih jam dari jam 17:00
        $diff = strtotime($now) - strtotime($standard_out);
        $overtime_hours = ($diff > 0) ? floor($diff / 3600) : 0;

        $overtime_pay = 0;
        if ($overtime_hours > 0) {
            if ($overtime_hours <= 3) {
                $overtime_pay = $overtime_hours * (1.5 * $hourly_rate);
            } else {
                // Jam ke-4 dst dibayar 2x upah per jam
                $overtime_pay = $overtime_hours * (2 * $hourly_rate);
            }
        }

        $sql = "UPDATE attendances SET 
                check_out = ?, 
                overtime_hours = ?, 
                overtime_pay = ? 
                WHERE employee_id = ? AND date = ? AND check_out IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$now, $overtime_hours, $overtime_pay, $emp_id, $today]);
    }
}