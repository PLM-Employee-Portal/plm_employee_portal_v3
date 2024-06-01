<?php

namespace App\Livewire\Approverequests\Teachpermit;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Teachpermit;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ApproveTeachPermitTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    
    public $date_filter;

    public $status_filter;

    public $dateFilterName = "All";
    public $statusFilterName = "All";

    public $search = "";

    
    public function search()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $loggedInUser = auth()->user();
        
        $loggedInEmployeeData = Employee::where('employee_id', $loggedInUser->employee_id)->first();

        $dept_head_id = "Denied";
        foreach($loggedInEmployeeData->is_department_head as $index => $department_id){
            if($department_id == 1){
                $dept_head_id = $index;
            }
        }

        $college_head_id = "Denied";
        foreach($loggedInEmployeeData->is_college_head as $index => $college_id){
            if($college_id == 1){
                $college_head_id = $index;
            }
        }

        if($dept_head_id != "Denied"){
            $departmentHeadId = $loggedInEmployeeData->department_id[$dept_head_id];
        }
        if($college_head_id != "Denied"){
            $collegeDeanId = $loggedInEmployeeData->college_id[$college_head_id];
        }

        // Check if condition for department head is true
        // if($loggedInEmployeeData->role_id == 0){
        //     // $teachPermitData = Teachpermit::paginate(10);
        // }
        if ($college_head_id != "Denied" && $dept_head_id != "Denied"){
            $teachPermitData = Teachpermit::join('employees', 'employees.employee_id', 'teachpermits.employee_id')
                    ->where(function ($query) use ($collegeDeanId, $departmentHeadId) {
                        $query->whereJsonContains('employees.department_id', $departmentHeadId)
                            ->orwhereJsonContains('employees.college_id',  $collegeDeanId);
                    })
                    ->select('teachpermits.*') 
                    ->distinct() 
                    ->orderBy('created_at', 'desc');
        }
        else if ($dept_head_id != "Denied") {
            $teachPermitData = Teachpermit::join('employees', 'employees.employee_id', 'teachpermits.employee_id')
                ->where(function ($query) use ($departmentHeadId) {
                    $query->whereJsonContains('employees.department_id', $departmentHeadId);
                })
                ->select('teachpermits.*') 
                ->distinct() 
                ->orderBy('created_at', 'desc');
        }
        // Check if condition for college dean is true
        else if ($college_head_id != "Denied") {
            $teachPermitData = Teachpermit::join('employees', 'employees.employee_id', 'teachpermits.employee_id')
                ->where(function ($query) use ($collegeDeanId) {
                    $query->whereJsonContains('employees.college_id',  $collegeDeanId);
                })
                ->select('teachpermits.*')
                ->distinct()
                ->orderBy('created_at', 'desc');
        }
        else if ($loggedInUser->role_id == 1) { // Change to role id of an HR Admin
            $teachPermitData = Teachpermit::orderBy('created_at', 'desc');
        } 
        else{
            abort(404);
        }

        // $loggedInUser = auth()->user();
        // $teachPermitData = Teachpermit::where('employee_id', $loggedInUser->employee_id);
        switch ($this->date_filter) {
            case '1':
                $teachPermitData->whereDate('date_of_filling',  Carbon::today());
                $this->dateFilterName = "Today";
                break;
            case '2':
                $teachPermitData->whereBetween('date_of_filling', [Carbon::today()->startOfWeek(), Carbon::today()]);
                $this->dateFilterName = "Last 7 Days";
                break;
            case '3':
                $teachPermitData->whereBetween('date_of_filling', [Carbon::today()->subDays(30), Carbon::today()]);
                $this->dateFilterName = "Last 30 days";
                break;
            case '4':
                $teachPermitData->whereBetween('date_of_filling', [Carbon::today()->subMonths(6), Carbon::today()]);
                // $teachPermitData->whereDate('date_of_filling', '>=', Carbon::today()->subMonths(6), '<=', Carbon::today());
                $this->dateFilterName = "Last 6 Months";
                break;
            case '5':
                $teachPermitData->whereBetween('date_of_filling', [Carbon::today()->subYear(), Carbon::today()]);
                $this->dateFilterName = "Last Year";
                break;
        }

        switch ($this->status_filter) {
            case '1':
                $teachPermitData->where('status',  'Approved');
                $this->statusFilterName = "Approved";
                break;
            case '2':
                $teachPermitData->where('status', 'Pending');
                $this->statusFilterName = "Pending";
                break;
            case '3':
                $teachPermitData->where('status', 'Declined');
                $this->statusFilterName = "Declined";
                break;
        }
        
        if(strlen($this->search) >= 1){
            $teachPermitData = $teachPermitData->where('status', '!=', 'Deleted')->where('application_date', 'like', '%' . $this->search . '%')->orderBy('application_date', 'desc');
        } else {
            $teachPermitData = $teachPermitData->where('status', '!=', 'Deleted')->orderBy('application_date', 'desc');
        }

        return view('livewire.approverequests.teachpermit.approve-teach-permit-table', [
            'TeachPermitData' => $teachPermitData->paginate(5),
        ]);

        // $loggedInUser = auth()->user()->employee_id;
        // $departmentName = Employee::where('employee_id', $loggedInUser)->value('department_name');
        // return view('livewire.approverequests.teachpermit.approve-teach-permit-table', [
        //     'TeachPermitData' => Teachpermit::where('department_name', $departmentName)->paginate(10),
        // ]);

    }   
}
