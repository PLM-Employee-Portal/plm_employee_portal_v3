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

            $zero_balance_probability = 0.7; // Adjust probability as needed

            $random_number = rand(0, 100);
            
            if ($random_number <= $zero_balance_probability * 100) { // Convert probability to percentage for comparison
              $balance = 0;
            } else {
              $balance = rand(1, 1000);
            }
            
            $loan_balance = ($balance === 0) ? rand(1, 1000) : 0;

            Payroll::create([
                'employee_id' => $employeeId,
                'payroll_id' => $payrollId,
                'date' => $startDate->copy(), // Use the current start date for this record
                'salary' => rand(1000, 10000),
                'balance' => $balance,
                'loan_balance' => $loan_balance, 
                'lvt_pay' => rand(100, 1000),
                'absences' => rand(0, 5), // Random absences in the month
                'amount_earned' => rand(100, 1000),
                'gsis_deduction' => rand(100, 1000),
                'wtax' => rand(100, 1000),
                'pera' => rand(100, 1000),
                'philhealth' => rand(100, 1000),
                'pag_ibig' => rand(100, 1000),
                'plmpcci' => rand(100, 1000),
                'landbank' => rand(100, 1000),
                'maxicare' => rand(100, 1000),
                'study_grant' => rand(100, 1000),
                'other_deductions' =>rand(100, 1000),
                'net_pay' => rand(1000, 10000),
            ]);

            $startDate->addMonth(); // Move to the next month
            $i++; // Increment the counter for payroll IDs
        }
    }
}
