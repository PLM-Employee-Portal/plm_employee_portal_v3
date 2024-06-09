<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Dailytimerecord;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = Employee::first();
        $today = Carbon::today();
        $usedDates = collect(); // Collection to keep track of used dates
        $employeeId = 202410048; // Starting employee ID
        $recordCount = 275; // Number of records to create
        
        for ($i = 0; $i <= $recordCount; $i++) {
            // Loop to find a unique date not greater than today
            do {
                $randomYear = 2024; // Specify the year
                $randomMonth = rand(1, 12); // Random month (1 to 12)
                $daysInMonth = Carbon::createFromDate($randomYear, $randomMonth, 1)->daysInMonth; // Get the number of days in the month
                $randomDay = rand(1, $daysInMonth); // Random day within the range of days in the month
                $attendanceDate = Carbon::createFromDate($randomYear, $randomMonth, $randomDay);
            } while ($attendanceDate->greaterThan($today) || $usedDates->contains($attendanceDate->format('Y-m-d')));
        
            // Add the date to the set of used dates
            $usedDates->push($attendanceDate->format('Y-m-d'));

            $attendanceId = $employeeId . str_pad($i, 4, '0', STR_PAD_LEFT);
        
            $randomLate = rand(0, 1); // Random late status (0 or 1)
            $randomHour1 = rand(0, 23); // Random hour (0 to 23)
            $randomMinute1 = rand(0, 59); // Random minute (0 to 59)

            $randomHour2 = rand(0, 23); // Random hour (0 to 23)
            $randomMinut2 = rand(0, 59); // Random minute (0 to 59)
            
             // Randomly assign either 'overtime' or 'undertime' to be 1
            $overtime = rand(0, 1);
            $undertime = $overtime === 1 ? 0 : rand(0, 1);

            Dailytimerecord::create([
                'employee_id' => $employeeId,
                'attendance_id' => $attendanceId,
                'attendance_date' => $attendanceDate,
                'job_id' => rand(1, 10),
                'absent' => rand(1, 2),
                'overtime' => $overtime,
                'undertime' => $undertime,
                'cto' => rand(1, 2),
                'lwop' => rand(1, 2),
                'remarks' => 'remark',
                'time_in' => sprintf("%02d:%02d", $randomHour1, $randomMinute1), // Format hour and minute
                'time_out' => sprintf("%02d:%02d", $randomHour2, $randomMinute2), // Use same random time for time_out
                'late' => $randomLate,
                'sl_used' => rand(1, 2),
                'vl_used' => rand(1, 2),
                'status' => 1,
            ]);
        }
    }
}
