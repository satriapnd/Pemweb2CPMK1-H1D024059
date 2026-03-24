<?php
require_once 'BaseModel.php';

class DepartmentModel extends BaseModel {
    protected $table = 'departments';

    // Menampilkan relasi: "Budi adalah manager dari IT"
    public function getDepartmentsWithManager() {
        $sql = "SELECT d.name as dept_name, e.name as manager_name 
                FROM departments d
                LEFT JOIN employees e ON d.manager_id = e.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Untuk fitur Turnover Analysis (Tantangan Bonus)
    public function getTurnoverAnalysis() {
        $sql = "SELECT d.name, 
                COUNT(CASE WHEN e.status = 'resign' THEN 1 END) as total_resign,
                COUNT(e.id) as total_employee
                FROM departments d
                LEFT JOIN employees e ON d.id = e.department_id
                GROUP BY d.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}