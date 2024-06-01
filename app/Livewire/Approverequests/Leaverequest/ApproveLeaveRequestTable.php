<?php

namespace App\Livewire\Approverequests\Leaverequest;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Leaverequest;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ApproveLeaveRequestTable extends Component
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
        if ($college_head_id != "Denied" && $dept_head_id != "Denied"){
            $leaveRequestData = Leaverequest::join('employees', 'employees.employee_id', 'leaverequests.employee_id')
                ->where(function ($query) use ($collegeDeanId, $departmentHeadId) {
                    $query->whereJsonContains('employees.department_id', $departmentHeadId)
                        ->orwhereJsonContains('employees.college_id',  $collegeDeanId);
                })
                ->select('leaverequests.*') // Select only documentrequest columns
                ->distinct() // Ensure unique records
                ->orderBy('created_at', 'desc');
        }
        else if ($dept_head_id != "Denied") {
            $leaveRequestData= Leaverequest::join('employees', 'employees.employee_id', 'leaverequests.employee_id')
                ->where(function ($query) use ($departmentHeadId) {
                    $query->whereJsonContains('employees.department_id', $departmentHeadId);
                })
                ->select('leaverequests.*') // Select only Leaverequest columns
                ->distinct() // Ensure unique records
                ->orderBy('created_at', 'desc');
        }
        // Check if condition for college dean is true
        else if ($college_head_id != "Denied") {
            $leaveRequestData = Leaverequest::join('employees', 'employees.employee_id', 'leaverequests.employee_id')
                ->where(function ($query) use ($collegeDeanId) {
                    $query->whereJsonContains('employees.college_id',  $collegeDeanId);
                })
                ->select('leaverequests.*') // Select only Leaverequest columns
                ->distinct() // Ensure unique records
                ->orderBy('created_at', 'desc');
        }
        else if ($loggedInUser->role_id == 1) { // Change to role id of an HR Admin
            $leaveRequestData = Leaverequest::orderBy('created_at', 'desc');
        } 
        else{
            abort(404);
        }

        switch ($this->date_filter) {
            case '1':
                $leaveRequestData->whereDate('date_of_filling',  Carbon::today());
                $this->dateFilterName = "Today";
                break;
            case '2':
                $leaveRequestData->whereBetween('date_of_filling', [Carbon::today()->startOfWeek(), Carbon::today()]);
                $this->dateFilterName = "Last 7 Days";
                break;
            case '3':
                $leaveRequestData->whereBetween('date_of_filling', [Carbon::today()->subDays(30), Carbon::today()]);
                $this->dateFilterName = "Last 30 days";
                break;
            case '4':
                $leaveRequestData->whereBetween('date_of_filling', [Carbon::today()->subMonths(6), Carbon::today()]);
                // $leaveRequestData->whereDate('date_of_filling', '>=', Carbon::today()->subMonths(6), '<=', Carbon::today());
                $this->dateFilterName = "Last 6 Months";
                break;
            case '5':
                $leaveRequestData->whereBetween('date_of_filling', [Carbon::today()->subYear(), Carbon::today()]);
                $this->dateFilterName = "Last Year";
                break;
        }

        switch ($this->status_filter) {
            case '1':
                $leaveRequestData->where('status',  'Approved');
                $this->statusFilterName = "Approved";
                break;
            case '2':
                $leaveRequestData->where('status', 'Pending');
                $this->statusFilterName = "Pending";
                break;
            case '3':
                $leaveRequestData->where('status', 'Declined');
                $this->statusFilterName = "Declined";
                break;
        }

        if(strlen($this->search) >= 1){
            $leaveRequestData = $leaveRequestData->where('status', '!=', 'Deleted')->where('date_of_filling', 'like', '%' . $this->search . '%')->orderBy('date_of_filling', 'desc');
        } else {
            $leaveRequestData = $leaveRequestData->where('status', '!=', 'Deleted')->orderBy('date_of_filling', 'desc');
        }

        return view('livewire.approverequests.leaverequest.approve-leave-request-table', [
            'LeaveRequestData' => $leaveRequestData->paginate(5),
            // 'ipcrs' => Ipcr::where('employee_id', $loggedInUser->employee_id)->paginate(10),

        ]);

        // // $loggedInUser = auth()->user()->employee_id;
        // // $departmentName = Employee::where('employee_id', $loggedInUser)->value('department_name');
        // return view('livewire.approverequests.leaverequest.approve-leave-request-table', [
        //     'LeaveRequestData' => Leaverequest::where('department_name', $departmentName)->paginate(10),
        // ]);
    }

    public function removeLeaveRequest($id){
        $leaverequest = Leaverequest::findOrFail($id);
        $leaverequest->delete();
        return redirect()->route('LeaveRequestTable');
    }
    
   
}
