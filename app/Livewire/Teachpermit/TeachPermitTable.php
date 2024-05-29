<?php

namespace App\Livewire\Teachpermit;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Teachpermit;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class TeachPermitTable extends Component
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
        $query = Teachpermit::where('employee_id', $loggedInUser->employee_id);
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
            $results = $query->where('status', '!=', 'Deleted')->where('application_date', 'like', '%' . $this->search . '%')->orderBy('application_date', 'desc')->paginate(5);
        } else {
            $results = $query->where('status', '!=', 'Deleted')->orderBy('application_date', 'desc')->paginate(5);
        }
        return view('livewire.teachpermit.teach-permit-table', [
            'TeachPermitData' => $results,
        ]);
    }

    public function removeTeachPermit($ref_num){
        $data = Teachpermit::where('reference_num', $ref_num)->first();
        $dataToUpdate = ['status' => 'Deleted',
                         'deleted_at' => now()];
        $this->authorize('delete', $data);
        Teachpermit::where('reference_num', $ref_num)->update($dataToUpdate);
        return redirect()->route('TeachPermitTable');
    }

    
}
