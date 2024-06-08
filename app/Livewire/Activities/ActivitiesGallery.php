<?php

namespace App\Livewire\Activities;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Activities;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;

class ActivitiesGallery extends Component
{   
    public $filter;

    #[Locked]
    public $is_head;


    public function mount(){
        $loggedInUser = auth()->user()->employee_id;
        $employeeData = Employee::where('employee_id', $loggedInUser)
                            ->first();


        $dept_head_id = False;
        foreach($employeeData->is_department_head as $department_id){
            if($department_id == 1){
                $dept_head_id = True;
            }
        }

        $college_head_id = False;
        foreach($employeeData->is_college_head as $college_id){
            if($college_id == 1){
                $college_head_id = True;
            }
        }
        $this->is_head = $dept_head_id == 1 || $college_head_id == 1;

    }

    public function getActivityPhoto($index){
        // $imageFile = $this->editLeaveRequest($this->index);
        $imageFile = Activities::where('activity_id', $index)->value('poster');
        return $imageFile;
    }

    public function filterListener(){
        $loggedInUser = auth()->user();
        $collegeName = Employee::where('employee_id', $loggedInUser->employee_id)
                                ->value('college_id');
        if($loggedInUser->role_id == 0){
            return Activities::paginate(10);
        }
        else if($this->filter == "Announcement"){
            $activities =  Activities::where(function ($query) use ($collegeName) {
                foreach ($collegeName as $college) {
                $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                    $query->orWhereJsonContains('visible_to_list', $college_name);
                }
            })
            ->where('type', 'Announcement') // Add additional conditions if needed
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        else if($this->filter == "Event"){
            $activities =  Activities::where(function ($query) use ($collegeName) {
                        foreach ($collegeName as $college) {
                        $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                            $query->orWhereJsonContains('visible_to_list', $college_name);
                        }
                        })
                        ->where('type', 'Event')
                        ->where('status', '!=', 'Deleted')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        }
        else if($this->filter == "Seminar"){
            $activities =  Activities::where(function ($query) use ($collegeName) {
                        foreach ($collegeName as $college) {
                        $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                            $query->orWhereJsonContains('visible_to_list', $college_name);
                        }
                        })
                        ->where('type', 'Seminar')
                        ->where('status', '!=', 'Deleted')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        }
        else if($this->filter == "Training"){
            $activities =  Activities::where(function ($query) use ($collegeName) {
                    foreach ($collegeName as $college) {
                    $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                        $query->orWhereJsonContains('visible_to_list', $college_name);
                    }
                    })
                    ->where('type', 'Training')
                    ->where('status', '!=', 'Deleted')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        }
        else if($this->filter == "Others"){
            $activities = Activities::where(function ($query) use ($collegeName) {
                    foreach ($collegeName as $college) {
                    $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                        $query->orWhereJsonContains('visible_to_list', $college_name);
                    }
                    })
                    ->where('type', 'Others')
                    ->where('status', '!=', 'Deleted')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        }
        else{
            $activities =  Activities::where(function ($query) use ($collegeName) {
                foreach ($collegeName as $college) {
                $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                    $query->orWhereJsonContains('visible_to_list', $college_name);
                }
            })->where('status', '!=', 'Deleted')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        return $activities;
    }

    public function fillerSetter($type){
       return $this->filter = $type;
    }
    
    public function render()
    {
        return view('livewire.activities.activities-gallery', [
            'ActivitiesData' => $this->filterListener(),
        ])->extends('components.layouts.app');
    }
}
