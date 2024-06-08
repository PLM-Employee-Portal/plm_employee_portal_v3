<?php

namespace App\Livewire\Creditsmonetization;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Monetization;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class CreditsMonetizationUpdate extends Component
{

    use WithFileUploads;

    public $first_name;
    public $middle_name;
    public $last_name;
    public $department_name;
    public $employee_type;
    public $current_position;
    public $salary;

    public $date_of_filling;

    public $requested_vacation_credits;

    public $requested_sick_credits;

    public $total_requested;

    public $purpose;

    public $applicant_signature;
    public $applicant_signature_date;

    public $date;

    public $vacation_credits;

    public $sick_credits;

    public $total_credits;

    public $index;


    public function mount($index){
        $loggedInUser = auth()->user();
        $this->index = $index;

        try {
            $this->index = $index;
            $monetizationdata = $this->editForm();
            // $this->authorize('update', [$teachpermitdata]);
            if($monetizationdata->employee_id != $loggedInUser->employee_id){
                redirect()->to(route('CreditsMonetizationTable'));
            }
        } catch (AuthorizationException $e) {
            abort(404);
        }

        $employeeRecord = Employee::select('first_name', 'middle_name', 'last_name', 'department_id', 'college_id', 'current_position', 'employee_type', 'vacation_credits', 'sick_credits', 'salary' )
                                    ->where('employee_id', $loggedInUser->employee_id)
                                    ->first();   
        $departmentName = DB::table('departments')->where('department_id', $employeeRecord->department_id)->value('department_name');
        $this->first_name = $employeeRecord->first_name;
        $this->middle_name = $employeeRecord->middle_name;
        $this->last_name = $employeeRecord->last_name;
        $this->department_name = $departmentName;
        $this->current_position = $employeeRecord->current_position;
        $this->employee_type = $employeeRecord->employee_type;
        $this->salary = $employeeRecord->salary;
        $this->sick_credits = $employeeRecord->sick_credits ?? 0;
        $this->vacation_credits = $employeeRecord->vacation_credits ?? 0;
        $this->total_credits = $employeeRecord->vacation_credits ?? 0 + $employeeRecord->sick_credits ?? 0;

        $this->date_of_filling = $monetizationdata->date_of_filling;
        $this->salary =  $monetizationdata->salary_grade;
        $this->requested_vacation_credits = $monetizationdata->requested_vacation_credits;
        $this->requested_sick_credits = $monetizationdata->requested_sick_credits;
        $this->total_requested = $monetizationdata->total_requested;
        $this->purpose = $monetizationdata->purpose;
        $this->applicant_signature_date = $monetizationdata->applicant_signature_date;
        $this->applicant_signature = $monetizationdata->applicant_signature ? ' ' : null;

        $this->date = now();
    }

    public function editForm(){
        $form = Monetization::where('reference_num', $this->index)->first();
        if(!$form){
            abort(404);
        }
        return $form;
    }

    public function getApplicantSignature(){
        $form = Monetization::where('reference_num', $this->index)->first();
        if(!$form){
            abort(404);
        }
        return $form->applicant_signature;
    }

    public function removeImage($item){
        $this->$item = null;
    }


    public function submit(){
        // foreach($this->rules as $rule => $validationRule){
        //     $this->validate([$rule => $validationRule]);
        //     // $this->resetErrorBag();
        //     $this->resetValidation();
        // }   
        
        $loggedInUser = auth()->user();

        $monetizationdata= Monetization::where('reference_num', $this->index)->first();;

        $departmentName = Employee::where('employee_id', $loggedInUser->employee_id)->value('department_id');

        $departmentName = DB::table('departments')->where('department_id', $departmentName[0])->value('department_name');

        $monetizationdata->salary_grade = $this->salary;
        $monetizationdata->requested_vacation_credits = $this->requested_vacation_credits;
        $monetizationdata->requested_sick_credits = $this->requested_sick_credits;
        $monetizationdata->total_requested = $this->total_requested;
        $monetizationdata->purpose = $this->purpose;
        $monetizationdata->applicant_signature_date = $this->applicant_signature_date;

        $properties = [
            'applicant_signature' => 'required|mimes:jpg,png|extensions:jpg,png|max:5120',
        ];
        
        // Iterate over the properties
        foreach ($properties as $propertyName => $validationRule) {
            // Check if the current property value is a string or an uploaded file
            if (is_string($this->$propertyName)) {
                // If it's a string, assign it directly
                // $teachpermitdata->$propertyName = $$propertyName;
            } else {
                // If it's an uploaded file, store it and apply validation rules
                $monetizationdata->$propertyName = file_get_contents($this->$propertyName->getRealPath());
                $monetizationdata->$propertyName = base64_encode($monetizationdata->$propertyName);
                $this->validate([$propertyName => $validationRule]);
            }
        }

        $updateData = [
            'status' => "Pending",
            'salary_grade' => $this->salary,
            'requested_vacation_credits' => $this->requested_vacation_credits,
            'requested_sick_credits' => $this->requested_sick_credits,
            'total_requested' => $this->total_requested,
            'purpose' => $this->purpose,
            'applicant_signature' => $monetizationdata->applicant_signature,
            'applicant_signature_date' => $this->applicant_signature_date,
            'updated_at' => now(),
        ];

        
        Monetization::where('reference_num', $this->index)
                               ->update($updateData);

      
        $this->js("alert('Monetization of Credits Request has been Submitted!')"); 
 
        return redirect()->to(route('CreditsMonetizationTable'));

    }

    public function render()
    {
        return view('livewire.creditsmonetization.credits-monetization-update')->extends('components.layouts.app');
    }
}
