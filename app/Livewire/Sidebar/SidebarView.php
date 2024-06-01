<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Locked;

class SidebarView extends Component
{   
    #[Locked]
    public $role;

    public $employeeImage;

    public $employeeName;

    public $employeeEmail;

    public $head;

    public $departmentHeadId ;

    public $collegeDeanId;

    public $is_admin;

    public $employee_id;
    public function mount(){
        $loggedInUser = auth()->user();
        $this->is_admin = $loggedInUser->is_admin;
        // $this->role = (int) Employee::where('employee_id', $loggedInUser->employee_id)->value('employee_role');
        $employee = Employee::where('employee_id', $loggedInUser->employee_id)->first(); 
        // dd($this->role);
        $this->employeeImage = $employee->emp_image;
        $this->employeeName = $employee->first_name. ' ' . $employee->middle_name . ' ' . $employee->last_name;
        $this->employeeEmail = $loggedInUser->email;

        // $loggedInEmployeeData = Employee::where('employee_id', $loggedInUser->employee_id)->first();
        // $this->head = explode(',', $employee->is_department_head_or_dean[0] ?? ' ') ?? [];
        foreach($employee->is_department_head as $department_head){
            if($department_head == 1){
                $this->departmentHeadId = 1;
            }
        }
        foreach($employee->is_college_head as $college_head){
            if($college_head == 1){
                $this->collegeDeanId = 1;
            }
        }

        $this->role = $loggedInUser->role_id;
        $this->employee_id = $loggedInUser->employee_id;
        // dd($this->departmentHeadId, $this->collegeDeanId, $this->role);

    }

    public function render()
    {
        return view('livewire.sidebar.sidebar-view');
    }
}
