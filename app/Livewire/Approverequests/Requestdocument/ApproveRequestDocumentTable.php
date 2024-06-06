<?php

namespace App\Livewire\Approverequests\Requestdocument;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use App\Models\Documentrequest;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class ApproveRequestDocumentTable extends Component
{

    use WithPagination, WithoutUrlPagination;
    
    
    public $date_filter;

    public $status_filter;

    public $dateFilterName = "All";
    public $statusFilterName = "All";

    public $search = "";


    public function search()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $loggedInUser = auth()->user();
        
        $loggedInEmployeeData = Employee::where('employee_id', $loggedInUser->employee_id)->first();

        $dept_head_id = "Denied";
        foreach($loggedInEmployeeData->is_department_head as $index => $department_id){
            if($department_id == 1){
                $dept_head_id = $index;
            }
        }

        $college_head_id = "Denied";
        foreach($loggedInEmployeeData->is_college_head as $index => $college_id){
            if($college_id == 1){
                $college_head_id = $index;
            }
        }

        if($dept_head_id != "Denied"){
            $departmentHeadId = $loggedInEmployeeData->department_id[$dept_head_id];
        }
        if($college_head_id != "Denied"){
            $collegeDeanId = $loggedInEmployeeData->college_id[$college_head_id];
        }

        // Check if condition for department head is true
        if ($college_head_id != "Denied" && $dept_head_id != "Denied"){
            $documentRequestData = Documentrequest::join('employees', 'employees.employee_id', 'documentrequests.employee_id')
                ->where(function ($query) use ($collegeDeanId, $departmentHeadId) {
                    $query->orWhereJsonContains('employees.department_id', $departmentHeadId)
                        ->orWhereJsonContains('employees.college_id',  $collegeDeanId);
                })
                ->select('documentrequests.*') // Select only documentrequest columns
                ->distinct() // Ensure unique records
                ->orderBy('created_at', 'desc');
        }
        else if ($dept_head_id != "Denied") {
            $documentRequestData= Documentrequest::join('employees', 'employees.employee_id', 'documentrequests.employee_id')
                ->where(function ($query) use ($departmentHeadId) {
                    $query->orWhereJsonContains('employees.department_id', $departmentHeadId);
                })
                ->select('documentrequests.*') // Select only documentrequest columns
                ->distinct() // Ensure unique records
                ->orderBy('created_at', 'desc');
        }

        // Check if condition for college dean is true
        else if ($college_head_id != "Denied") {
            $documentRequestData = Documentrequest::join('employees', 'employees.employee_id', 'documentrequests.employee_id')
                ->where(function ($query) use ($collegeDeanId) {
                    $query->orWhereJsonContains('employees.college_id',  $collegeDeanId);
                })
                ->select('documentrequests.*') // Select only documentrequest columns
                ->distinct() // Ensure unique records
                ->orderBy('created_at', 'desc');
        }
        else if ($loggedInUser->role_id == 1) { // Change to role id of an HR Admin
            $documentRequestData = Documentrequest::orderBy('created_at', 'desc');
        } 
        else{
            abort(404);
        }

        switch ($this->date_filter) {
            case '1':
                $documentRequestData->whereDate('date_of_filling',  Carbon::today());
                $this->dateFilterName = "Today";
                break;
            case '2':
                $documentRequestData->whereBetween('date_of_filling', [Carbon::today()->startOfWeek(), Carbon::today()]);
                $this->dateFilterName = "Last 7 Days";
                break;
            case '3':
                $documentRequestData->whereBetween('date_of_filling', [Carbon::today()->subDays(30), Carbon::today()]);
                $this->dateFilterName = "Last 30 days";
                break;
            case '4':
                $documentRequestData->whereBetween('date_of_filling', [Carbon::today()->subMonths(6), Carbon::today()]);
                // $documentRequestData->whereDate('date_of_filling', '>=', Carbon::today()->subMonths(6), '<=', Carbon::today());
                $this->dateFilterName = "Last 6 Months";
                break;
            case '5':
                $documentRequestData->whereBetween('date_of_filling', [Carbon::today()->subYear(), Carbon::today()]);
                $this->dateFilterName = "Last Year";
                break;
        }

        switch ($this->status_filter) {
            case '1':
                $documentRequestData->where('status',  'Approved');
                $this->statusFilterName = "Approved";
                break;
            case '2':
                $documentRequestData->where('status', 'Pending');
                $this->statusFilterName = "Pending";
                break;
            case '3':
                $documentRequestData->where('status', 'Declined');
                $this->statusFilterName = "Declined";
                break;
        }

        if(strlen($this->search) >= 1){
            $documentRequestData = $documentRequestData->where('status', '!=', 'Deleted')->where('date_of_filling', 'like', '%' . $this->search . '%')->orderBy('date_of_filling', 'desc');
        } else {
            $documentRequestData = $documentRequestData->where('status', '!=', 'Deleted')->orderBy('date_of_filling', 'desc');
        }
      
        return view('livewire.approverequests.requestdocument.approve-request-document-table', [
            'DocumentRequestData' => $documentRequestData->paginate(5),
        ]);

    }

    public function downloadDocument($index, $request){
        $documentRequest = Documentrequest::findOrFail($index);
        try {
           $this->authorize('view', $documentRequest);
        } catch (AuthorizationException $e) {
           abort(404);
        }
        $requestName = str_replace(' ', '_', $request);
        $requestName = strtolower($requestName);
        $employee_id = auth()->user()->employee_id;
        if($documentRequest->$requestName != null){
           return Storage::disk('local')->download($documentRequest->$requestName, $request);
        } else{
           return abort(404);
        }
   }

   public function getStatusOfDocument($index, $request){
       $documentRequest = Documentrequest::where('reference_num', $index)->first();
       $requestName = str_replace(' ', '_', $request);
       $requestName = strtolower($requestName);
       $loggedInUser = auth()->user();
       $loggedInEmployeeData = Employee::where('employee_id', $loggedInUser->employee_id)->first();
       $employee_id = auth()->user()->employee_id;
       $head = explode(',', $loggedInEmployeeData->is_department_head_or_dean[0] ?? ' ');
       if ($request == "Others")
            $requestName = 'other_documents';
    //    if($documentRequest->$requestName && ($employee_id == $documentRequest->employee_id || $head[0] == 1 || $head[1] == 1 )){
    //        return "Approved";
    //    }
       if(isset($documentRequest->$requestName)){
            if($documentRequest->$requestName && ($employee_id == $documentRequest->employee_id || $head[0] == 1 || $head[1] == 1 )){
            return "Approved";
        }
       }
       return "Pending";

   }

   public function editRequestDocument($id){
       return redirect()->route('RequestDocumentEdit', ['index' => $id]);
   }

   public function removeRequestDocument($id){
       $ipcrToBeDeleted = Documentrequest::findOrFail($id);
       $this->authorize('delete', $ipcrToBeDeleted);
       $ipcrToBeDeleted->delete();
       return redirect()->route('RequestDocumentTable');
   }
    
 
}
