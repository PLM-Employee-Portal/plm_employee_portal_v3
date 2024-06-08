<?php

namespace App\Livewire\Requestdocuments;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use Livewire\WithFileUploads;
use App\Models\Documentrequest;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;

class RequestDocumentForm extends Component
{

    use WithFileUploads;

    public $employeeRecord;
    public $date;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $department_name;
    public $current_position;
    public $employee_type;
    
    #[Locked]
    public $reference_num;

    private $private_reference_num;
    public $employment_status;
    public $status;
    public $date_of_filling;
    public $requests = [];
    public $milc_description;
    public $position;
    public $other_request;

    public $payrollDates;
    public $purpose;
    public $signature_requesting_party;


    public function mount(){
        $loggedInUser = auth()->user();
        $employeeRecord = Employee::select('first_name', 'middle_name', 'last_name', 'department_id', 'current_position', 'employee_type', 'employee_id' )
                                  ->where('employee_id', $loggedInUser->employee_id)
                                  ->first();   
        $departmentName = DB::table('departments')->where('department_id', $employeeRecord->department_id[0])->value('department_name');
        $this->first_name = $employeeRecord->first_name;
        $this->middle_name = $employeeRecord->middle_name;
        $this->last_name = $employeeRecord->last_name;
        $this->department_name = $departmentName;
        $this->current_position = $employeeRecord->current_position;
        $this->employee_type = $employeeRecord->employee_type;

        $randomNumber = 0;
        while(True) {
            $randomNumber = $this->generateRefNumber();
            $existingRecord = Documentrequest::where('reference_num', $randomNumber)->first();
            if($randomNumber != $existingRecord){
                break;
            }
        }
        $this->reference_num = $randomNumber;
        $this->private_reference_num = $randomNumber;
        $dateToday = Carbon::now()->toDateString();
        $this->date = $dateToday;
        $this->date_of_filling = $dateToday;
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

    protected $rules = [
        'reference_num' => 'required|min:13|max:13',
        'requests' => 'required|array|min:1',
        // 'requests.*' => 'in:Certificate of Employment,Certificate of Employment with Compensation,Service Record,Part time Teaching Services,MILC Certification,Certificate of No Pending Administrative Case,Others',
        'requests.*' => 'in:Certificate of Employment,Certificate of Employment with Compensation,Service Record,Part time Teaching Services,MILC Certification,Others,Payroll',
        'purpose' => 'required|min:2|max:1000', 
        'signature_requesting_party' => 'required|mimes:jpg,png,pdf|extensions:jpg,png,pdf|max:5120'
    ];

    public function submit(){
        $properties = [
            'milc_description' => 'MILC Certification',
            'other_request' => 'Others',
            'payrollDates' => 'Payroll',
        ];

        foreach($properties as $property => $value){
            if(in_array($value, $this->requests ?? [])){
                $this->validate([$property => 'required']);
            }
        }

        $this->validate();

        $loggedInUser = auth()->user();

        $documentrequestdata = new Documentrequest();


        $employeeRecord = Employee::where('employee_id', $loggedInUser->employee_id)->select('department_id', 'employee_type', 'first_name', 'middle_name', 'last_name')->first();
        $departmentName = DB::table('departments')->where('department_id', $employeeRecord->department_id)->value('department_name');
      

        $documentrequestdata->employee_id = $loggedInUser->employee_id;
        $documentrequestdata->name = $employeeRecord->first_name . $employeeRecord->middle_name . $employeeRecord->last_name;
        $documentrequestdata->office_department = $departmentName;
        $documentrequestdata->date_of_filling = $this->date_of_filling;
        $documentrequestdata->reference_num = $this->reference_num;
        $documentrequestdata->employment_status = $employeeRecord->employee_type;
        $documentrequestdata->status = 'Pending';
        $documentrequestdata->requests = $this->requests;
        $documentrequestdata->milc_description = $this->milc_description;
        $documentrequestdata->other_request = $this->other_request;
        $documentrequestdata->purpose = $this->purpose;

        $imageData = file_get_contents($this->signature_requesting_party->getRealPath());
        $documentrequestdata->signature_requesting_party = base64_encode($imageData);

        // $documentrequestdata->signature_requesting_party = $this->signature_requesting_party->store('photos/documentrequest/signature_requesting_party', 'local');
        $documentrequestdata->save();

        $this->js("alert('Your Document Request has been submitted!')"); 
 

        return redirect()->to(route('RequestDocumentTable'));

    }
    
    public function render()
    {
        return view('livewire.requestdocuments.request-document-form')->extends('components.layouts.app');
    }
}
