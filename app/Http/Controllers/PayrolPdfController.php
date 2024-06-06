<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PayrolPdfController extends Controller
{
    public function turnToPdf($date){
        $payrollData = Payroll::where('date', $date)->first(); 
        $payrollData = json_decode($payrollData);
        $loggedInuser = auth()->user()->employee_id;
        $employee = Employee::query()->where('employee_id', $loggedInuser)->first(); 
        $departmentName = DB::table('departments')->where('department_id', $employee->department_id)->value('department_name');
        $logoUrl = Storage::disk('public')->get('plmlogo/plm-logo.png');
        $chiefSign = Storage::disk('local')->get('photos\payroll\R.jpg');
        $currentDay = date('d');
         // Get the current month
        $currentMonth = date('F');
        $currentYear = date('y');
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'system-ui']); 
        $pdf = PDF::loadView('livewire.payroll.payroll-pdf', ['payrollData' => $payrollData, 'employee' => $employee, 'logo' => $logoUrl, 'currentDay' => $currentDay, 'currentMonth' => $currentMonth, 'currentYear' =>  $currentYear, 'sign' => $chiefSign, 'dept_name' => $departmentName]); // Pass data to the blade file
        $pdf->setPaper('A4', 'portrait'); 
        return $pdf->stream();   
    }
}
