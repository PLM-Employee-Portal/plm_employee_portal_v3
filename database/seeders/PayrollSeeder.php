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
        $employeeId = 202410031; // Starting employee ID
        $startDate = Carbon::createFromDate(2021, 1, 1); // Start from January 2021

        $currentDate = Carbon::now();
        $i = 0; // Counter for payroll IDs

        while ($startDate->lessThanOrEqualTo($currentDate)) {
            $randomNumber = rand(1000, 10000);

            $payrollId = $employeeId . str_pad($i, 4, '0', STR_PAD_LEFT);

            Payroll::create([
                'employee_id' => $employeeId,
                'payroll_id' => $payrollId,
                'date' => $startDate->copy(), // Use the current start date for this record
                'salary' => $randomNumber,
                'lvt_pay' => $randomNumber,
                'absences' => rand(0, 5), // Random absences in the month
                'amount_earned' => $randomNumber,
                'gsis_deduction' => $randomNumber,
                'wtax' => $randomNumber,
                'pera' => $randomNumber,
                'philhealth' => $randomNumber,
                'pag_ibig' => $randomNumber,
                'plmpcci' => $randomNumber,
                'landbank' => $randomNumber,
                'maxicare' => $randomNumber,
                'study_grant' => $randomNumber,
                'other_deductions' => $randomNumber,
                'net_pay' => $randomNumber,
            ]);

            $startDate->addMonth(); // Move to the next month
            $i++; // Increment the counter for payroll IDs
        }
    }
}
