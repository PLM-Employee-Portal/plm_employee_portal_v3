<?php

namespace App\Livewire\Activities;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Activities;
use Livewire\Attributes\Locked;

class ActivitiesView extends Component
{
    public $activityData;
    public $index;
    #[Locked]
    public $is_head;
    public function mount($index){
        $this->index = $index;
        $loggedInUser = auth()->user();
        $loggedInEmployeeData = Employee::where('employee_id', $loggedInUser->employee_id)->first();
        $this->activityData = Activities::where('activity_id', $index)->first();
            $dept_head_id = "Denied";
            foreach($loggedInEmployeeData->is_department_head as $index => $department_id){
                if($department_id == 1){
                    $dept_head_id = True;
                }
            }
    
            $college_head_id = "Denied";
            foreach($loggedInEmployeeData->is_college_head as $index => $college_id){
                if($college_id == 1){
                    $college_head_id = True;
                }
            }

        $this->is_head = $college_head_id == 1 ||$dept_head_id == 1 || $loggedInUser->is_admin ? true : false;
       
        // dd($this->activityData->poster);
    }

    public function removeActivity(){
        dd($this->index);
        $leaveRequestData = Activities::where('activity_id', $this->index)->first();
        $dataToUpdate = ['status' => 'Deleted',
                         'deleted_at' => now()];
        $this->authorize('delete', $leaveRequestData);
        Activities::where('reference_num', $this->index)->update($dataToUpdate);
        return redirect()->route('LeaveRequestTable');
    }

    public function render()
    {
        return view('livewire.activities.activities-view', [
            'ActivityData' => $this->activityData,
        ])->extends('components.layouts.app');

    }
}
