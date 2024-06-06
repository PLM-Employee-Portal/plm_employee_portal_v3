<?php

namespace App\Livewire\Requestdocuments;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithFileUploads;
use App\Models\Documentrequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class RequestDocumentUpdate extends Component
{

    use WithFileUploads;
   
    public $ref_number;

    public $index;
    public $employeeRecord;
    public $date;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $department_name;
    public $current_position;
    public $employee_type;

   

    private $private_ref_number;
    public $employment_status;
    public $status;
    public $date_of_filling;
    public $requests = [];
    public $milc_description;
    public $position;
    public $other_request;
    public $purpose;
    public $signature_requesting_party;

    public $certificate_of_employment;
    public $certificate_of_employment_with_compensation;
    public $service_record;
    public $part_time_teaching_services;
    public $milc_certification;
    public $certificate_of_no_pending_administrative_case;
    public $other_documents;

    public function mount($index){

        try {
            $documentrequestdata = $this->editDocumentRequest($index);
            $this->authorize('update', $documentrequestdata);
        } catch (AuthorizationException $e) {
            abort(404);
        }
        
        $this->index = $index;
        $loggedInUser = auth()->user();
        $employeeRecord = Employee::select('first_name', 'middle_name', 'last_name', 'department_id', 'current_position', 'employee_type' )
                                    ->where('employee_id', $loggedInUser->employee_id)
                                    ->first();   
        $departmentName = DB::table('departments')->where('department_id', $employeeRecord->department_id)->value('department_name');

        $this->first_name = $employeeRecord->first_name;
        $this->middle_name = $employeeRecord->middle_name;
        $this->last_name = $employeeRecord->last_name;
        $this->department_name = $departmentName;
        $this->current_position = $employeeRecord->current_position;
        $this->employee_type = $employeeRecord->employee_type;


        $this->date_of_filling = $documentrequestdata->date_of_filling;
        $this->ref_number = $documentrequestdata->reference_num;
        $this->status = $documentrequestdata->status;
        $this->requests = $documentrequestdata->requests;
        $this->milc_description = $documentrequestdata->milc_description;
        $this->other_request = $documentrequestdata->other_request;
        $this->purpose = $documentrequestdata->purpose;
        if($documentrequestdata->signature_requesting_party){
            $this->signature_requesting_party = " ";
        }
        $properties = [
            // 'signature_requesting_party' ,
            'certificate_of_employment' ,
            'certificate_of_employment_with_compensation' ,
            'service_record' ,
            'part_time_teaching_services' ,
            'milc_certification' ,
            'certificate_of_no_pending_administrative_case' ,
            'other_documents',
        ];

        foreach ($properties as $propertyName) {
            if (is_null($this->$propertyName)) {

            } else {
               $this->$propertyName = " ";
            }
        }
    }

    public function editDocumentRequest($index){
        $documentrequest = Documentrequest::where('reference_num', $index)->first();
        if(!$documentrequest){
            abort(404);
        }
        // $this->leaverequest = $leaverequest;
        return $documentrequest;
    }

    public function getApplicantSignature(){
        $imageFile = $this->editDocumentRequest($this->index);
        return $imageFile->signature_requesting_party;
    }

    protected $rules = [
        'requests' => 'required|array|min:1',
        // 'requests.*' => 'in:Certificate of Employment,Certificate of Employment with Compensation,Service Record,Part time Teaching Services,MILC Certification,Certificate of No Pending Administrative Case,Others',
        'requests.*' => 'in:Certificate of Employment,Certificate of Employment with Compensation,Service Record,Part time Teaching Services,MILC Certification,Others',
        'purpose' => 'required|min:2|max:1000', 
    ];

    public function submit(){
        $properties = [
            'milc_description' => 'MILC Certification',
            'other_request' => 'Others',
        ];

        foreach($properties as $property => $value){
            if(in_array($value, $this->requests ?? [])){
                $this->validate([$property => 'required']);
            }
        }

        $this->validate();


        $documentrequestdata = Documentrequest::where('reference_num', $this->index)->first();
        if(!$documentrequestdata){
            abort(404);
        }

        if(is_string($this->signature_requesting_party)){
            // $documentrequestdata->signature_requesting_party = $documentrequestdata->signature_requesting_party;
        } else{
            $this->validate(['signature_requesting_party' => 'mimes:jpg,png,pdf|extensions:jpg,png,pdf']);
            $documentrequestdata->signature_requesting_party = file_get_contents($this->signature_requesting_party->getRealPath());
            $documentrequestdata->signature_requesting_party = base64_encode($documentrequestdata->signature_requesting_party);
        }

        $updateData = [
            'requests' => $this->requests,
            'milc_description' => $this->milc_description, 
            'other_request' => $this->other_request, 
            'purpose' => $this->purpose, 
            'signature_requesting_party' => $documentrequestdata->signature_requesting_party,
            'updated_at' => now(),
          ];

        
        Documentrequest::where('reference_num', $this->index)
                               ->update($updateData);

       
        $this->js("alert('Document Request has been updated!')"); 
 
        // $documentrequestdata->update();

        return redirect()->to(route('RequestDocumentTable'));

    }
    
    public function render()
    {
        return view('livewire.requestdocuments.request-document-update')->extends('components.layouts.app');
    }
}
