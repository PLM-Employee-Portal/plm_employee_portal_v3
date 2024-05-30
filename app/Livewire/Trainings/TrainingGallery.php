<?php

namespace App\Livewire\Trainings;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Training;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;

class TrainingGallery extends Component
{
    public $training_title;
    public $training_information;
    public $training_photo;
    public $pre_test_title;
    public $post_test_title;
    public $pre_test_description;
    public $post_test_description;
    public $pre_test_questions;
    public $post_test_questions;
    public $pre_test_rating;
    public $post_test_rating;
    public $host;
    public $is_featured;
    public $visible_to_list;

    public $department_name;


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

    public function filterListener(){
        $loggedInUser = auth()->user();
        $employeeData = Employee::select('department_id', 'college_id')
                    ->where('employee_id', $loggedInUser->employee_id)
                    ->first();
        // $head = explode(',', $employeeData->is_department_head_or_dean[0] ?? ' ');
        // $this->is_head = $head[0] == 1 || $head[1] == 1 || $loggedInUser->is_admin ? true : false;
        
        $this->department_name = $employeeData->department_name;
        $collegeName = Employee::where('employee_id', $loggedInUser->employee_id)
                                ->value('college_id');
        if($loggedInUser->role_id == 0){
            return Training::paginate(10);
        }
        else{
            return Training::where(function ($query) use ($collegeName) {
                foreach ($collegeName as $college) {
                $college_name = DB::table('colleges')->where('college_id', $college)->value('college_name');
                    $query->orWhereJsonContains('visible_to_list', $college_name);
                }
            })
            // ->where('type', 'Announcement') // Add additional conditions if needed
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        // else {
        //     return Training::whereJsonContains('visible_to_list', $employeeData->department_name)->orderBy('created_at', 'desc')->paginate(10);
        // }

    }

    public function fillerSetter($type){
        return $this->filter = $type;
    }

    public function getActivityPhoto($index){
        $imageFile = Training::where('training_id', $index)->value('training_photo');
        return $imageFile;
    }


    public function render()
    {
        return view('livewire.trainings.training-gallery', [
            // 'ActivitiesData' => $this->filterListener(),
            'TrainingData' => $this->filterListener(),

        ])->extends('components.layouts.app');
    }
}
