<?php

namespace App\Livewire\Trainings;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Training;
use App\Models\Traininganswer;
use Livewire\Attributes\Locked;

class TrainingView extends Component
{
    public $trainingData;
    public $index;
    public $preTestAnswerExists;
    public $postTestAnswerExists;

    #[Locked]
    public $is_head;

    public function mount($index){
        $this->index = $index;
        $loggedInUser = auth()->user();
        $loggedInEmployeeData = Employee::where('employee_id', $loggedInUser->employee_id)->first();
        $this->trainingData = Training::where('training_id', $index)->first();
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
        // $this->preTestAnswerExists = Traininganswer::where('employee_id', $loggedInUser->employeeId)
        //     ->whereNotNull('pre_test_answers')
        //     ->where('id', $this->trainingData->id)
        //     ->exists();
        // $this->postTestAnswerExists = Traininganswer::where('employee_id', $loggedInUser->employeeId)
        //     ->whereNotNull('post_test_answers')
        //     ->where('id', $this->trainingData->id)
        //     ->exists();
        // dd($this->activityData->poster);
    }

    public function getTrainingPhoto(){
        $trainingdata = Training::findOrFail($this->index);
        return $trainingdata->training_photo;
    }

    public function render()
    {
      
        return view('livewire.trainings.training-view', [
            'TrainingData' => $this->trainingData,
            'PreTestAnswer' => $this->preTestAnswerExists
        ])->extends('components.layouts.app');
    }
}
