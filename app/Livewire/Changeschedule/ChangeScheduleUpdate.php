<?php

namespace App\Livewire\Changeschedule;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithFileUploads;
use App\Models\ChangeSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class ChangeScheduleUpdate extends Component
{
    
    use WithFileUploads;

    public $first_name;
    public $middle_name;
    public $last_name;
    public $department_name;
    public $employee_type;
    public $current_position;
    public $date_of_filling;

    public $date;
    public $original;
    public $proposed;

    public $start_period_cover;

    public $end_period_cover;


    public $reason;
    public $applicant_signature;

    public $index;

    public function mount($index){
        $loggedInUser = auth()->user();
        $this->index = $index;

        try {
            $this->index = $index;
            $changescheduledata = $this->editForm();
            // $this->authorize('update', [$teachpermitdata]);
            if($changescheduledata->employee_id != $loggedInUser->employee_id){
                redirect()->to(route('ChangeScheduleTable'));
            }
        } catch (AuthorizationException $e) {
            abort(404);
        }
        $loggedInUser = auth()->user();
        $employeeRecord = Employee::select('first_name', 'middle_name', 'last_name', 'department_id', 'college_id', 'current_position', 'employee_type', 'teach_available_units' )
                                    ->where('employee_id', $loggedInUser->employee_id)
                                    ->first();   
        $departmentName = DB::table('departments')->where('department_id', $employeeRecord->department_id)->value('department_name');
        $this->first_name = $employeeRecord->first_name;
        $this->middle_name = $employeeRecord->middle_name;
        $this->last_name = $employeeRecord->last_name;
        $this->department_name = $departmentName;
        $this->current_position = $employeeRecord->current_position;
        $this->employee_type = $employeeRecord->employee_type;
        $dateToday = now();
        $this->date_of_filling = $dateToday;
        $this->date = $dateToday;

        $this->date_of_filling = $changescheduledata->date_of_filling;

        $this->date = $changescheduledata->date;
        $this->original = json_decode($changescheduledata->original, true);
        $this->proposed = json_decode($changescheduledata->proposed, true);
        $this->start_period_cover = $changescheduledata->start_period_cover;
        $this->end_period_cover = $changescheduledata->end_period_cover;
        $this->reason = $changescheduledata->reason;
        $this->applicant_signature = $changescheduledata->applicant_signature;

        // $this->original = [
        //     ['start_time_schedule' => '', 'end_time_schedule' => '', 'work_days' => '', 'start_break_time' => '', 'end_break_time' => '','day_off' => '']
        // ];

        // $this->proposed = [
        //     ['start_time_schedule' => '', 'end_time_schedule' => '', 'work_days' => '', 'start_break_time' => '', 'end_break_time' => '','day_off' => '']
        // ];
        
    }

    public function editForm(){
        $form = ChangeSchedule::where('reference_num', $this->index)->first();
        if(!$form){
            abort(404);
        }
        // $this->leaverequest = $leaverequest;
        return $form;
    }

    public function getApplicantSignature(){
        $form = ChangeSchedule::where('reference_num', $this->index)->first();
        if(!$form){
            abort(404);
        }
        return $form->applicant_signature;
    }

    public function removeSchedule($index){
        unset($this->original[$index]);
        unset($this->proposed[$index]);

        $this->original = array_values($this->original);
        $this->proposed = array_values($this->proposed);

        $this->dispatch('update-original-load', [json_encode($this->original, true)]);
        $this->dispatch('update-proposed-load', [json_encode($this->proposed, true)]);
    }

    public function removeImage($item){
        $this->$item = null;
    }

    public function addSchedule(){
        $this->original[] =  ['start_time_schedule' => '', 'end_time_schedule' => '', 'work_days' => '', 'start_break_time' => '', 'end_break_time' => '','day_off' => ''];
        $this->proposed[] =  ['start_time_schedule' => '', 'end_time_schedule' => '', 'work_days' => '', 'start_break_time' => '', 'end_break_time' => '','day_off' => ''];
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
    protected $validationAttributes = [
        'start_period_cover' => 'Start Period',
        'end_period_cover' => 'End Period',
        'original.*.start_time_schedule' => 'Start Time Schedule',
        'original.*.end_time_schedule' => 'End Time Schedule',
        'original.*.work_days' => 'Work Days',
        'original.*.start_break_time' => 'Start Break Time',
        'original.*.end_break_time' => 'End Break Time',
        'original.*.day_off' => 'Day Off',
        'proposed.*.start_time_schedule' => 'Start Time Schedule',
        'proposed.*.end_time_schedule' => 'End Time Schedule',
        'proposed.*.work_days' => 'Work Days',
        'proposed.*.start_break_time' => 'Start Break Time',
        'proposed.*.end_break_time' => 'End Break Time',
        'proposed.*.day_off' => 'Day Off',
    ];

    protected $rules = [
        'start_period_cover' => 'required|date',
        'end_period_cover' => 'required|after_or_equal:start_period_cover|date',
        'original.*.start_time_schedule' => 'required',
        'original.*.end_time_schedule' => 'required|after_or_equal:original.*.start_time_schedule',
        'original.*.work_days' => 'required',
        'original.*.start_break_time' => 'required',
        'original.*.end_break_time' => 'required|after_or_equal:subjectLoad.*.start_time',
        'original.*.day_off' => 'required',
        'proposed.*.start_time_schedule' => 'required',
        'proposed.*.end_time_schedule' => 'required|after_or_equal:proposed.*.start_time_schedule',
        'proposed.*.work_days' => 'required',
        'proposed.*.start_break_time' => 'required',
        'proposed.*.end_break_time' => 'required|after_or_equal:subjectLoad.*.start_time',
        'proposed.*.day_off' => 'required|',
    ];

   
    public function submit(){
        foreach($this->rules as $rule => $validationRule){
            $this->validate([$rule => $validationRule]);
            // $this->resetErrorBag();
            $this->resetValidation();
        }   
        // $this->validate();
        
        $loggedInUser = auth()->user();

        $changescheduledata = ChangeSchedule::where('reference_num', $this->index)->first();;
       
        $departmentName = Employee::where('employee_id', $loggedInUser->employee_id)->value('department_id');

        $departmentName = DB::table('departments')->where('department_id', $departmentName[0])->value('department_name');

        $changescheduledata->date_of_filling = now();
        $changescheduledata->status = "Pending";
        $changescheduledata->reason = $this->reason;
        $changescheduledata->start_period_cover = $this->start_period_cover;
        $changescheduledata->end_period_cover = $this->end_period_cover;

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
                $changescheduledata->$propertyName = file_get_contents($this->$propertyName->getRealPath());
                $changescheduledata->$propertyName = base64_encode($changescheduledata->$propertyName);
                $this->validate([$propertyName => $validationRule]);
            }
        }

        foreach($this->original as $load){
            $jsonOriginalLoad[] = [
                'start_time_schedule' => $load['start_time_schedule'],
                'end_time_schedule' => $load['end_time_schedule'],
                'work_days' => $load['work_days'],
                'start_break_time' => $load['start_break_time'],
                'end_break_time' => $load['end_break_time'],
                'day_off' => $load['day_off'],
            ];
        }
        foreach($this->proposed as $proposed){
            $jsonProposedLoad[] = [
                'start_time_schedule' => $proposed['start_time_schedule'],
                'end_time_schedule' => $proposed['end_time_schedule'],
                'work_days' => $proposed['work_days'],
                'start_break_time' => $proposed['start_break_time'],
                'end_break_time' => $proposed['end_break_time'],
                'day_off' => $proposed['day_off'],
            ];
        }

        $jsonOriginalLoad = json_encode($jsonOriginalLoad);
        $jsonProposedLoad = json_encode($jsonProposedLoad);


        $changescheduledata->original = $jsonOriginalLoad;
        $changescheduledata->proposed = $jsonProposedLoad;

        $updateData = [
            'start_period_cover' => $this->start_period_cover,
            'end_period_cover' => $this->end_period_cover,
            'reason' => $this->reason,
            'original' => $jsonOriginalLoad,
            'proposed' => $jsonProposedLoad ,
            'applicant_signature' => $changescheduledata->applicant_signature,
            'updated_at' => now(),
        ];

        
        ChangeSchedule::where('reference_num', $this->index)
                               ->update($updateData);

        $this->js("alert('Change of Schedule Request Updated!')"); 
 
        return redirect()->to(route('ChangeScheduleTable'));

    }

    public function render()
    {
        return view('livewire.changeschedule.change-schedule-update')->extends('components.layouts.app');
    }
}
