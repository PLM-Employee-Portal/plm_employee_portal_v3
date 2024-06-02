<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = Employee::first();
        
        for ($i = 0; $i <= 50; $i++) {
            $randomNumber = rand(1000, 10000);
            $randomMonth = rand(1, 12); // Random month (1 to 12)
            $randomDay = rand(1, 28); // Random day (assuming all months have max 28 days)
            $attendanceDate = Carbon::createFromDate(2024, $randomMonth);
            
            Payroll::create([
                'employee_id' =>  $employee->employee_id,
                'date' => $attendanceDate,
                'salary' => $randomNumber,
                'lvt_pay' => $randomNumber,
                'absences' => $randomMonth,
                'amount_earned' => $randomNumber,
                'gsis_deduction' => $randomNumber,
                'wtax' => $randomNumber,
                'philhealth' => $randomNumber,
                'pag_ibig' => $randomNumber,
                'plmpcci' => $randomNumber,
                'landbank' => $randomNumber,
                'maxicare' => $randomNumber,
                'study_grant' => $randomNumber,
                'other_deductions' => $randomNumber,
                'net_pay' => $randomNumber,
            ]);
        }
    }
}
