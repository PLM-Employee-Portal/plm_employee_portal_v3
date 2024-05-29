<?php

namespace App\Livewire\Requestdocuments;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documentrequest;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class RequestDocumentTable extends Component
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

         if ($loggedInUser->is_admin) {
            $results = Documentrequest::orderBy('date_of_filling', 'desc')->paginate(10);
        } else{
            $query = Documentrequest::where('employee_id', $loggedInUser->employee_id);
            switch ($this->date_filter) {
                case '1':
                    $query->whereDate('date_of_filling',  Carbon::today());
                    $this->dateFilterName = "Today";
                    break;
                case '2':
                    $query->whereBetween('date_of_filling', [Carbon::today()->startOfWeek(), Carbon::today()]);
                    $this->dateFilterName = "Last 7 Days";
                    break;
                case '3':
                    $query->whereBetween('date_of_filling', [Carbon::today()->subDays(30), Carbon::today()]);
                    $this->dateFilterName = "Last 30 days";
                    break;
                case '4':
                    $query->whereBetween('date_of_filling', [Carbon::today()->subMonths(6), Carbon::today()]);
                    // $query->whereDate('date_of_filling', '>=', Carbon::today()->subMonths(6), '<=', Carbon::today());
                    $this->dateFilterName = "Last 6 Months";
                    break;
                case '5':
                    $query->whereBetween('date_of_filling', [Carbon::today()->subYear(), Carbon::today()]);
                    $this->dateFilterName = "Last Year";
                    break;
            }
    
            switch ($this->status_filter) {
                case '1':
                    $query->where('status',  'Approved');
                    $this->statusFilterName = "Approved";
                    break;
                case '2':
                    $query->where('status', 'Pending');
                    $this->statusFilterName = "Pending";
                    break;
                case '3':
                    $query->where('status', 'Declined');
                    $this->statusFilterName = "Declined";
                    break;
            }
    
    
            if(strlen($this->search) >= 1){
                $results = $query->where('status', '!=', 'Deleted')->where('date_of_filling', 'like', '%' . $this->search . '%')->orderBy('date_of_filling', 'desc')->paginate(5);
            } else {
                $results = $query->where('status', '!=', 'Deleted')->orderBy('date_of_filling', 'desc')->paginate(5);
            }
        }
        
        return view('livewire.requestdocuments.request-document-table', [
            'DocumentRequestData' => $results,
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
         }else{
            return abort(404);
         }
    }

    public function getStatusOfDocument($index, $request){
        $documentRequest = Documentrequest::where('reference_num', $index)->first();
        $requestName = str_replace(' ', '_', $request);
        $requestName = strtolower($requestName);
        $employee_id = auth()->user()->employee_id;
        if(isset($documentRequest->$requestName)){
            if($documentRequest->$requestName && $employee_id == $documentRequest->employee_id){
                return "Approved";
            }
        }
        return "Pending";

    }

    public function editRequestDocument($id){
        return redirect()->route('RequestDocumentEdit', ['index' => $id]);
    }

    public function removeRequestDocument($ref_num){
        $data = Documentrequest::where('reference_num', $ref_num)->first();
        $dataToUpdate = ['status' => 'Deleted',
                         'deleted_at' => now()];
        $this->authorize('delete', $data);
        Documentrequest::where('reference_num', $ref_num)->update($dataToUpdate);
        return redirect()->route('RequestDocumentTable');
    }
}
