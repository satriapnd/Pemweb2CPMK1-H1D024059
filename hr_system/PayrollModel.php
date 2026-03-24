<?php
require_once 'BaseModel.php';

class PayrollModel extends BaseModel {
    protected $table = 'payrolls';

    // Fitur 2 & Bonus: Hitung Gaji Bersih
    public function calculate($base, $absent_days, $ot_hours = 0) {
        // Potongan 10% jika absen > 3 hari
        $deductions = ($absent_days > 3) ? $base * 0.10 : 0;
        
        // Tunjangan kehadiran jika hadir penuh
        $allowances = ($absent_days == 0) ? 500000 : 0;

        // Tantangan Bonus: Lembur
        $hourly_rate = $base / 173;
        $ot_pay = 0;
        if ($ot_hours > 0) {
            $ot_pay = ($ot_hours <= 3) ? ($ot_hours * 1.5 * $hourly_rate) : (3 * 1.5 * $hourly_rate + ($ot_hours-3) * 2 * $hourly_rate);
        }

        return [
            'allowances' => $allowances,
            'deductions' => $deductions,
            'overtime_pay' => $ot_pay,
            'net_salary' => ($base + $allowances + $ot_pay) - $deductions
        ];
    }
}