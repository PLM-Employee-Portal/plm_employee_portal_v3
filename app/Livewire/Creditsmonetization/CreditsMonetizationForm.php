<?php

namespace App\Livewire\Creditsmonetization;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Monetization;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class CreditsMonetizationForm extends Component
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
    public $vacation_credits_allowed;
  
    public $vacation_credits;

    public $sick_credits_allowed;
  
  	public $sick_credits;

    public $total_credits;


    public function mount(){
        $loggedInUser = auth()->user();
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
        $vacation_credits = floatval($employeeRecord->vacation_credits ?? 0) ;
        $this->vacation_credits  = $vacation_credits;
        $this->vacation_credits_allowed = $vacation_credits > 0 ? $vacation_credits - 1 : 0;
        $sick_credits = floatval($employeeRecord->sick_credits ?? 0) ;
        $this->sick_credits  = $sick_credits;
        $this->sick_credits_allowed =  $sick_credits > 0 ? $sick_credits - 1 : 0;
        $this->total_credits = $this->vacation_credits_allowed + $this->sick_credits_allowed;

        $dateToday = now();
        $this->date_of_filling = $dateToday;
        $this->date = $dateToday;
    }

    public function updated(){
        $sick_credits = 0;
        $vacation_credits = 0;
        if($this->requested_vacation_credits > 0){
            $vacation_credits =  (float) $this->requested_vacation_credits;
        }
        if($this->requested_sick_credits > 0){
            $sick_credits = (float)  $this->requested_sick_credits ;
        }
        $this->total_requested = $vacation_credits + $sick_credits;
    }

    private function generateRefNumber(){
        $today = date('Ymd');

        $randomDigits = '';
        for ($i = 0; $i < 5; $i++) {
            $randomDigits .= random_int(0, 9); // More secure random number generation
        }
        // Combine the date and random digits
        $referenceNumber = $today . $randomDigits;
        return $referenceNumber;
     }
     
     public function removeImage($item){
        $this->$item = null;
    }

    protected $rules = [
        'salary' => 'required',
        'requested_vacation_credits' => 'nullable|lte:vacation_credits_allowed',
        'requested_sick_credits' => 'nullable|lte:sick_credits_allowed',    
        'total_requested' => 'nullable|lte:total_credits',
        'purpose' => 'nullable|string|min:10|max:500',
        'applicant_signature' => 'required|mimes:jpg,png,pdf|extensions:jpg,png,pdf',
        'applicant_signature_date' => 'required|date|after_or_equal:date',
    ];

    public function submit(){
        foreach($this->rules as $rule => $validationRule){
            $this->validate([$rule => $validationRule]);
            // $this->resetErrorBag();
            $this->resetValidation();
        }   
        
        $loggedInUser = auth()->user();

        $changescheduledata = new Monetization();

        $randomNumber = 0;
        while(True) {
            $randomNumber = $this->generateRefNumber();
            $existingRecord = Monetization::where('reference_num', $randomNumber)->first();
            if(!$existingRecord){
                break;
            }
         
        }

        $departmentName = Employee::where('employee_id', $loggedInUser->employee_id)->value('department_id');

        $departmentName = DB::table('departments')->where('department_id', $departmentName[0])->value('department_name');

        $changescheduledata->reference_num = $randomNumber;
        $changescheduledata->employee_id = $loggedInUser->employee_id;
        $changescheduledata->date_of_filling = now();
        $changescheduledata->status = "Pending";
        $changescheduledata->salary_grade = $this->salary;
        $changescheduledata->requested_vacation_credits = $this->requested_vacation_credits;
        $changescheduledata->requested_sick_credits = $this->requested_sick_credits;
        $changescheduledata->total_requested = $this->total_requested;
        $changescheduledata->purpose = $this->purpose;
        $changescheduledata->applicant_signature_date = $this->applicant_signature_date;

        $imageData = file_get_contents($this->applicant_signature->getRealPath());
        $changescheduledata->applicant_signature = base64_encode($imageData);

      
        $this->js("alert('Monetization of Credits Request has been Submitted!')"); 
 
        $changescheduledata->save();

        return redirect()->to(route('CreditsMonetizationTable'));

    }

    public function render()
    {
        return view('livewire.creditsmonetization.credits-monetization-form')->extends('components.layouts.app');
    }
}
