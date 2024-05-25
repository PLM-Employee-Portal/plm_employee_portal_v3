<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Employeeinformation as empInformation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employeeinformation extends Component
{

    public $employeeRecord;
    public $employeeHistory;
    public $employeeImage;

    public $empDiploma;
    public $emp_tor;
    public $empCertOfTrainingsSeminars;
    public $empAuthCopyOfCscOrPrc;
    public $empAuthCopyOfPrcBoardRating;
    public $empMedCertif;
    public $empNBIClearance;
    public $empPSABirthCertif;
    public $empPSAMarriageCertif;
    public $empServiceRecordFromOtherGovtAgency;
    public $empApprovedClearancePrevEmployer;
    public $otherDocuments;
    
    public function mount(){
        $employee_id = auth()->user()->employee_id;
        $employee = Employee::where('employee_id', $employee_id)->first(); // Replace $employee_id with the actual employee ID
        $this->employeeImage = $employee->emp_image;
        $this->employeeRecord = Employee::where('employee_id', $employee_id)->first();
        $this->empDiploma = json_decode($employee->emp_diploma, true) ?? [];
        $this->emp_tor = json_decode($employee->emp_tor, true) ?? [];
        $this->empCertOfTrainingsSeminars = json_decode($employee->emp_cert_of_trainings_seminars, true) ?? [];
        $this->empAuthCopyOfCscOrPrc = json_decode($employee->emp_auth_copy_of_csc_or_prc, true) ?? [];
        $this->empAuthCopyOfPrcBoardRating = json_decode($employee->emp_auth_copy_of_prc_board_rating, true) ?? [];
        $this->empMedCertif = json_decode($employee->emp_med_certif, true) ?? [];
        $this->empNBIClearance = json_decode($employee->emp_nbi_clearance, true) ?? [];
        $this->empPSABirthCertif = json_decode($employee->emp_psa_birth_certif, true) ?? [];
        $this->empPSAMarriageCertif = json_decode($employee->emp_psa_marriage_certif, true) ?? [];
        $this->empServiceRecordFromOtherGovtAgency = json_decode($employee->emp_service_record_from_other_govt_agency, true) ?? [];
        $this->empApprovedClearancePrevEmployer = json_decode($employee->emp_approved_clearance_prev_employer, true) ?? [];
        $this->otherDocuments = json_decode($employee->other_documents, true) ?? [];
        

        // dd($this->employeeDiploma);
        if($this->employeeRecord->employee_history != null){
            $this->employeeHistory = json_decode($this->employeeRecord->employee_history);
        }
    }

    public function privateStorage(Media $media){
        return $media;
    }

    public function download($file, $index = 0){
        $employee_id = auth()->user()->employee_id;
        $employee = Employee::where('employee_id', $employee_id)->first(); // Replace $employee_id with the actual employee ID
        if($file == "photo"){
            return Storage::disk('public')->download($employee->emp_image);
        }
        else if ($file == "diploma"){
            $file = "emp_diploma";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "diploma.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "tor"){
            $file = "emp_tor";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "tor.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "certificate"){
            $file = "emp_cert_of_trainings_seminars";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "certificate.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "csc_eligibility"){
            $file = "emp_auth_copy_of_csc_or_prc";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "csc.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "prc_boardrating"){
            $file = "emp_auth_copy_of_prc_board_rating";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "Copy of CSC or PRC.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "med_cert"){
            $file = "emp_med_certif";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "Medical Certificate.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "nbi_clearance"){
            $file = "emp_nbi_clearance";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "Nbi Clearance.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "psa_birthcertificate"){
            $file = "emp_psa_birth_certif";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "PSA Birth Certificate.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "psa_marriagecertificate"){
            $file = "emp_psa_marriage_certif";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "PSA MArriage Certificate.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "service_record"){
            $file = "emp_service_record_from_other_govt_agency";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "Service Record.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == "approved_clearance"){
            $file = "emp_approved_clearance_prev_employer";
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "Approved Clearance.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }
        else if ($file == 'other_documents'){
            $imageFile = Employee::where('employee_id', $employee_id)->first();
            $imageFile = json_decode($imageFile->$file, true); 
            $fileName = "Additional.jpg";
            return Response::make(base64_decode($imageFile[$index]), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        }

        else{
            abort(404);
        }
    }
    
    public function render()
    {
        
        // dd($this->records);
        return view('livewire.employeeinformation');
    }
}
